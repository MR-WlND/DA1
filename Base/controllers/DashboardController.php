<?php

// Giả định rằng các file Model đã được include hoặc có cơ chế autoload
require_once PATH_MODEL . 'BookingModel.php';
require_once PATH_MODEL . 'PaymentModel.php';
require_once PATH_MODEL . 'FinancialTransactionModel.php';

class DashboardController
{
    public function index()
    {
        // Bảo vệ trang: Kiểm tra người dùng đã đăng nhập và có phải là admin không
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            // Nếu không, chuyển hướng về trang đăng nhập
            header('Location: index.php?action=login');
            exit;
        }

        // Lấy dữ liệu tổng quan cho dashboard (ví dụ)
        $bookingModel = new BookingModel();
        $totalBookings = $bookingModel->getTotalBookings();
        $pendingBookings = $bookingModel->countByStatus('pending');

        // Hiển thị view dashboard của admin
        // Truyền dữ liệu sang view
        require_once PATH_VIEW . 'admin/dashboard.php'; 
    }

    /**
     * Cập nhật trạng thái của một đơn hàng (Booking).
     * Khi trạng thái là "Confirmed", ghi nhận một giao dịch tài chính.
     */
    public function updateBookingStatus()
    {
        $this->checkAdmin();

        $bookingId = $_POST['booking_id'] ?? null;
        $status = $_POST['status'] ?? null; // 'Confirmed' hoặc 'Cancelled'

        if ($bookingId && in_array($status, ['Confirmed', 'Cancelled'])) {
            $bookingModel = new BookingModel();
            $booking = $bookingModel->findById($bookingId);

            if ($booking) {
                $bookingModel->updateStatus($bookingId, $status);

                // Nếu xác nhận đơn hàng, ghi nhận giao dịch tài chính là một khoản thu
                if ($status === 'Confirmed') {
                    $transactionModel = new FinancialTransactionModel();
                    $transactionModel->create(
                        'income',
                        $booking['total_price'],
                        "Thu từ đơn hàng #{$bookingId}",
                        $bookingId
                    );
                }
                $_SESSION['success'] = "Cập nhật trạng thái đơn hàng #{$bookingId} thành công!";
            } else {
                $_SESSION['error'] = "Không tìm thấy đơn hàng!";
            }
        } else {
            $_SESSION['error'] = "Dữ liệu không hợp lệ!";
        }

        header('Location: index.php?action=adminBookings'); // Chuyển hướng về trang quản lý đơn hàng
        exit;
    }

    /**
     * Ghi nhận một khoản chi (ví dụ: chi phí hoạt động, lương hướng dẫn viên).
     */
    public function recordExpense()
    {
        $this->checkAdmin();

        $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
        $description = trim($_POST['description'] ?? '');

        if ($amount > 0 && !empty($description)) {
            $transactionModel = new FinancialTransactionModel();
            $transactionModel->create('expense', $amount, $description);
            $_SESSION['success'] = 'Ghi nhận chi phí thành công!';
        } else {
            $_SESSION['error'] = 'Số tiền và mô tả không hợp lệ!';
        }

        header('Location: index.php?action=financialReport'); // Chuyển hướng về trang báo cáo
        exit;
    }

    /**
     * Tổng hợp thu chi và hiển thị báo cáo lãi/lỗ.
     */
    public function financialReport()
    {
        $this->checkAdmin();

        $transactionModel = new FinancialTransactionModel();

        $totalIncome = $transactionModel->getTotalByType('income');
        $totalExpense = $transactionModel->getTotalByType('expense');
        $profitOrLoss = $totalIncome - $totalExpense;

        // Truyền dữ liệu sang view để hiển thị báo cáo
        require_once PATH_VIEW . 'admin/financial_report.php';
    }

    /**
     * Kiểm tra quyền admin.
     */
    private function checkAdmin()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?action=login');
            exit;
        }
    }
}
