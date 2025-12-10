<?php
class BookingCustomerController
{
    public function listCustomers()
    {
        $bookingId = $_GET['booking_id'] ?? null; // Lấy ID Booking để lọc
        
        $customerModel = new BookingCustomersModel();
        
        // Lấy danh sách khách theo Booking ID
        $listCustomers = $customerModel->getCustomersByBookingId($bookingId);
        
        $title = "Danh sách Khách tham gia";
        $view = "admin/booking/list-customers"; // View hiển thị manifest
        require_once PATH_VIEW . 'main.php';
    }

    // 2. Cập nhật Trạng thái Check-in
    public function updateCheckInStatus()
    {
        // Lấy ID khách (booking_customers.id) và trạng thái mới (1 hoặc 0)
        $customerId = $_GET['customer_id'];
        $status = $_GET['status']; // 1: Check-in, 0: Check-out
        $bookingId = $_GET['booking_id']; // ID Booking để chuyển hướng quay lại
        
        $customerModel = new BookingCustomersModel();
        
        // Gọi Model để cập nhật trạng thái mà không cần kiểm tra lỗi
        $customerModel->updateCheckInStatus($customerId, $status);
        
        header('Location: ' . BASE_URL . '?action=detail-booking&id=' . $bookingId);
        exit;
    }
    
}