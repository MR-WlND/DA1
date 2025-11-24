<?php

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

        // Hiển thị view dashboard của admin
        require_once PATH_VIEW . 'admin/dashboard.php';
    }
}
