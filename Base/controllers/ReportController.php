<?php
// File: controllers/ReportController.php

class ReportController
{
    public function listProfitLoss()
    {
        // 1. GỌI MODEL
        $reportModel = new ReportModel();
        $dataReport = $reportModel->getProfitLossReport();
        
        // 2. CHUYỂN DỮ LIỆU SANG VIEW
        $title = "Báo cáo Lãi/Lỗ theo Chuyến đi";
        $view = "admin/reports/list-profit-loss";
        $data = [
            'profitLossReport' => $dataReport
        ]; 
        
        require_once PATH_VIEW . 'main.php';
    }
}