<?php
class BookingCustomerController
{
    public function listCustomers()
    {
        requireAdmin();
        $bookingId = $_GET['booking_id'] ?? null; // Láº¥y ID Booking Ä‘á»ƒ lá»c
        
        $customerModel = new BookingCustomersModel();
        
        // Láº¥y danh sĂ¡ch khĂ¡ch theo Booking ID
        $listCustomers = $customerModel->getCustomersByBookingId($bookingId);
        
        $title = "Danh sĂ¡ch KhĂ¡ch tham gia";
        $view = "admin/booking/list-customers"; // View hiá»ƒn thá»‹ manifest
        require_once PATH_VIEW . 'main.php';
    }

    // 2. Cáº­p nháº­t Tráº¡ng thĂ¡i Check-in
    public function updateCheckInStatus()
    {
        requireAdmin();
        // Láº¥y ID khĂ¡ch (booking_customers.id) vĂ  tráº¡ng thĂ¡i má»›i (1 hoáº·c 0)
        $customerId = $_GET['customer_id'];
        $status = $_GET['status']; // 1: Check-in, 0: Check-out
        $bookingId = $_GET['booking_id']; // ID Booking Ä‘á»ƒ chuyá»ƒn hÆ°á»›ng quay láº¡i
        
        $customerModel = new BookingCustomersModel();
        
        // Gá»i Model Ä‘á»ƒ cáº­p nháº­t tráº¡ng thĂ¡i mĂ  khĂ´ng cáº§n kiá»ƒm tra lá»—i
        $customerModel->updateCheckInStatus($customerId, $status);
        
        header('Location: ' . BASE_URL . '?action=detail-booking&id=' . $bookingId);
        exit;
    }
    
}
