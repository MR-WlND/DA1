<?php
// File: controllers/ReportController.php

class ReportController
{
    public function listProfitLoss()
    {
        requireAdmin();
        // 1. Gá»ŒI MODEL
        $reportModel = new ReportModel();
        $dataReport = $reportModel->getProfitLossReport();
        
        // 2. CHUYá»‚N Dá»® LIá»†U SANG VIEW
        $title = "BĂ¡o cĂ¡o LĂ£i/Lá»— theo Chuyáº¿n Ä‘i";
        $view = "admin/reports/list-profit-loss";
        $data = [
            'profitLossReport' => $dataReport
        ]; 
        
        require_once PATH_VIEW . 'main.php';
    }
}
