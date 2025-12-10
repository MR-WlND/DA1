<?php
class BookingController
{
    protected $bookingModel;
    public function __construct() 
    {
        // Khởi tạo Model để sử dụng lại
        $this->bookingModel = new BookingModel();
    }
    public function listBooking()
    {
        // 🟢 SỬA LỖI: Dùng $this->bookingModel
        $listBookings = $this->bookingModel->getList();

        $title = "Quản lý Đơn đặt Tour";
        $view = "admin/booking/list-booking";
        require_once PATH_VIEW . 'main.php';
    }
    public function createBooking()
    {
        // Khởi tạo các Model phụ thuộc nếu cần (Chỉ khởi tạo nếu không có trong __construct)
        $userModel = new UserModel();
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Khởi tạo tạm thời các Model chỉ dùng trong GET
            $listDepartures = (new DepartureModel())->getList(); 
            $listUsers = $userModel->getList();

            $title = "Thêm Đơn đặt Tour";
            $view = "admin/booking/create-booking";
            require_once PATH_VIEW . 'main.php';
        } else {
            $dataBooking = [
                'user_id'      => $_POST['user_id'],
                'departure_id' => $_POST['departure_id'],
                'total_price'  => $_POST['total_price'],
                // Lưu ý: Status đã được xử lý thành payment_status trong Model
            ];

            $customerDetails = $_POST['customer_details'] ?? []; 

            // 🟢 SỬA LỖI: Dùng $this->bookingModel
            $this->bookingModel->insertBooking($dataBooking, $customerDetails);

            header('Location: ' . BASE_URL . '?action=list-booking');
            exit;
        }
    }

    public function updateBooking()
    {
        $id = $_GET['id'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data = $this->bookingModel->getOne($id); 

            // Khởi tạo tạm thời các Model phụ thuộc
            $listDepartures = (new DepartureModel())->getList();
            $listUsers = (new UserModel())->getList();

            $title = "Cập nhật Đơn đặt Tour";
            $view = "admin/booking/update-booking";
            require_once PATH_VIEW . 'main.php';
        } else {
            // Lấy dữ liệu và gọi Model update
            $total_price = $_POST['total_price'];
            // $status = $_POST['status']; // Nếu không cần thiết thì loại bỏ

            $this->bookingModel->update($id, $total_price); 

            header('Location:' . BASE_URL . '?action=list-booking');
            exit;
        }
    }
    public function deleteBooking()
    {
        $id = $_GET['id'];
        // 🟢 SỬA LỖI: Dùng $this->bookingModel
        $this->bookingModel->delete($id);

        header('Location:' . BASE_URL . '?action=list-booking');
        exit;
    }

    public function detailBooking()
    {
        $id = $_GET['id'];
        
        // 🟢 SỬA LỖI: Dùng hàm find() đã tối ưu trong Model thay vì getOne() cũ
        $booking = $this->bookingModel->find($id);

        if (!$booking) {
            header('Location: ' . BASE_URL . '?action=list-booking');
            exit;
        }

        // Truyền biến $booking tới View
        $data['booking'] = $booking; 
        
        $title = "Chi tiết Đơn đặt Tour";
        $view = "admin/booking/detail-booking";
        
        require_once PATH_VIEW . 'main.php';
    }


    // Giao diện thanh toán
    public function checkoutSimple()
    {
        $bookingId = $_GET['id'] ?? null;
        
        // 🟢 Dùng hàm find() đã tối ưu trong Model
        $booking = $this->bookingModel->find($bookingId); 
        if (!$booking) {
            header('Location: ' . BASE_URL . '?action=my-bookings');
            exit;
        }
        $customerPhone = $booking['customer_phone'] ?? 'Liên hệ CSKH'; 

        $data = [
            'booking' => $booking,
            'customerPhone' => $customerPhone
        ];
        
        $title = "Thông tin Chuyển khoản";
        $view = "site/bank-transfer-info";
        require_once PATH_VIEW . 'main.php';
    }

    // Đánh dấu đơn đã thanh toán
    public function markAsPaid()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['booking_id']) || !isset($_POST['transaction_id'])) {
            header("Location: " . BASE_URL . "?action=admin-dashboard");
            exit;
        }
        $bookingId = intval($_POST['booking_id']);
        $transactionId = trim($_POST['transaction_id']);

        if ($bookingId <= 0 || $transactionId === "") {
            header("Location: " . BASE_URL . "?action=list-booking");
            exit;
        }

        // 🟢 SỬA LỖI: Dùng $this->bookingModel để gọi hàm cập nhật thanh toán
        $updated = $this->bookingModel->updatePaymentStatus($bookingId, 'Paid', $transactionId);

        if (!$updated) {
            // Xử lý lỗi DB
        }
        header("Location: " . BASE_URL . "?action=detail-booking&id=" . $bookingId);
        exit;
    }
    
}