<?php
// File: controllers/DashboardController.php

class DashboardController
{
    protected $statsModel; 
    protected $bookingModel;

    public function __construct()
    {
        // Khởi tạo các Model cần thiết
        $this->statsModel = new StatsModel(); 
        $this->bookingModel = new BookingModel();
    }

    public function index()
    {
        // 🛑 BƯỚC 1: XÁC THỰC VAI TRÒ (Phần "đếm"/kiểm tra người dùng)
        // Kiểm tra xem SESSION có tồn tại và role có phải là 'admin' không
        if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
            // Nếu không phải Admin, chuyển hướng về trang đăng nhập
            header('Location: ' . BASE_URL . '?action=login'); 
            exit;
        }

        // 🛑 BƯỚC 2: TRUY VẤN DỮ LIỆU (Thực hiện việc "đếm" số liệu tổng hợp)
        
        // 1. Lấy số liệu tổng hợp (KPIs)
        $stats = $this->statsModel->getGlobalStats();
        
        // 2. Lấy dữ liệu gần đây (ví dụ: 5 đơn hàng mới nhất)
        $recentBookings = $this->bookingModel->getRecent(5); 

        $data = [
            'stats' => $stats,
            'recentBookings' => $recentBookings,
        ];

        // 🛑 BƯỚC 3: HIỂN THỊ VIEW (Chỉ hiển thị khi check Admin thành công)
        $title = "Dashboard Tổng quan Hệ thống";
        // Sửa lỗi lặp đuôi file ở bước trước:
        $view = "admin/dashboard"; 
        
        require_once PATH_VIEW . 'main.php'; 
    }
}