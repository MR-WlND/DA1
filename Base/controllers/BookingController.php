<?php

class BookingController
{
    // Cần khởi tạo các Model phụ thuộc cục bộ trong từng hàm

    // 1. Hiển thị danh sách Đơn đặt Tour (READ List)
    public function listBooking()
    {
        $model = new BookingModel();
        $listBookings = $model->getList();

        $title = "Quản lý Đơn đặt Tour";
        $view = "admin/booking/list-booking";
        require_once PATH_VIEW . 'main.php';
    }

    // 2. Tạo Đơn đặt Tour mới (CREATE Transactional)
    public function createBooking()
    {
        // Khởi tạo Models (Giả định tồn tại)
        $bookingModel = new BookingModel();
        $tourModel = new TourModel();
        $userModel = new UserModel(); // Cần để lấy danh sách khách hàng đặt

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Lấy dữ liệu nền tảng cho form
            $listDepartures = (new DepartureModel())->getList(); // Lấy lịch khởi hành để chọn
            $listUsers = $userModel->getList(); // Lấy danh sách khách hàng (User ID)

            $title = "Thêm Đơn đặt Tour";
            $view = "admin/booking/create-booking";
            require_once PATH_VIEW . 'main.php';
        } else {
            // Lấy dữ liệu chính và các mảng khách hàng (CustomerDetails)
            $dataBooking = [
                'user_id'      => $_POST['user_id'], // Người đặt
                'departure_id' => $_POST['departure_id'], // Chuyến đi được chọn
                'total_price'  => $_POST['total_price'], // Tổng giá trị
                'status'       => $_POST['status'] ?? 'Pending',
            ];

            // Lấy mảng chi tiết từng khách hàng (CustomerDetails)
            $customerDetails = $_POST['customer_details'] ?? [];

            // Gọi Model để insert Booking và giảm tồn kho
            $bookingModel->insertBooking($dataBooking, $customerDetails);

            // Chuyển hướng
            header('Location: ' . BASE_URL . '?action=list-booking');
            exit;
        }
    }

    // 3. Cập nhật Đơn đặt Tour (UPDATE)
    public function updateBooking()
    {
        $id = $_GET['id'];
        $model = new BookingModel();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data = $model->getOne($id);

            // Load list data for form dropdowns
            $listDepartures = (new DepartureModel())->getList();
            $listUsers = (new UserModel())->getList();

            $title = "Cập nhật Đơn đặt Tour";
            $view = "admin/booking/update-booking";
            require_once PATH_VIEW . 'main.php';
        } else {
            // Lấy dữ liệu và gọi Model update
            $status = $_POST['status'];
            $total_price = $_POST['total_price'];

            $model->update($id, $status, $total_price);

            header('Location:' . BASE_URL . '?action=list-booking');
            exit;
        }
    }

    // 4. Xóa Đơn đặt Tour (DELETE)
    public function deleteBooking()
    {
        $id = $_GET['id'];
        $model = new BookingModel();
        $model->delete($id);
        header('Location:' . BASE_URL . '?action=list-booking');
        exit;
    }
    public function detailBooking()
    {
        // Lấy ID trực tiếp từ URL (không kiểm tra tính hợp lệ của số)
        $id = $_GET['id'];
        $bookingModel = new BookingModel();

        // Gọi Model để lấy dữ liệu (sẽ là FALSE nếu ID không tồn tại)
        $booking = $bookingModel->getOne($id);

        // Thiết lập View
        $title = "Chi tiết Đơn đặt Tour";
        $view = "admin/booking/detail-booking";

        require_once PATH_VIEW . 'main.php';
    }
}
