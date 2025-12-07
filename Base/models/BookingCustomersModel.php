<?php
// File: models/BookingCustomersModel.php

class BookingCustomersModel extends BaseModel
{
    public $db;
    public $table = "booking_customers"; 

    public function __construct()
    {
        $baseModel = new BaseModel();
        $this->db = $baseModel->getConnection();
    }

    // 1. Lấy danh sách khách hàng theo Booking ID (READ Manifest)
    public function getCustomersByBookingId($bookingId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE booking_id = :booking_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':booking_id' => $bookingId]);
        return $stmt->fetchAll();
    }

    // 2. Cập nhật Trạng thái Check-in (UNIQUE BUSINESS LOGIC)
    /**
     * @param int $customerId ID của khách hàng cá nhân (booking_customers.id)
     * @param int $status 1 cho Check-in, 0 cho Check-out
     */
    public function updateCheckInStatus($customerId, $status)
    {
        $sql = "UPDATE {$this->table} 
                SET is_checked_in = :status 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':status' => $status,
            ':id'     => $customerId
        ]);
    }

    // --- CÁC HÀM CRUD CƠ BẢN ---
    
    // Lưu ý: Hàm INSERT và DELETE khách hàng thường được gọi từ BookingModel 
    // bên trong Transaction, nhưng vẫn cần thiết cho quản lý trực tiếp.

    public function getList()
    {
        // Lấy danh sách khách tham gia (dùng cho Admin check tổng quát)
        $sql = "SELECT bc.*, b.departure_id 
                FROM {$this->table} bc
                JOIN bookings b ON bc.booking_id = b.id 
                ORDER BY bc.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function delete($id)
    {
        // Xóa khách hàng cá nhân khỏi đơn đặt
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

// Trong BookingModel.php


}