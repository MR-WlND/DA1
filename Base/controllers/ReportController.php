<?php
// File: controllers/ReportController.php

class ReportController
{
    // Hàm hiển thị Báo cáo Lãi/Lỗ
    public function listProfitLoss()
    {
        // 1. GỌI MODEL
        $reportModel = new ReportModel();
        $profitLossReport = $reportModel->getProfitLossReport();
        
        // 2. CHUYỂN DỮ LIỆU SANG VIEW
        $title = "Báo cáo Lãi/Lỗ theo Chuyến đi";
        $view = "admin/reports/list-profit-loss"; // Tên View mới
        
        // Dữ liệu cần truyền sang View
        $data = $profitLossReport; 
        
        require_once PATH_VIEW . 'main.php';
    }
}