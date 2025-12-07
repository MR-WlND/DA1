<?php
// File: models/ReportModel.php

class ReportModel extends BaseModel
{
    public $db;

    public function __construct()
    {
        $baseModel = new BaseModel();
        $this->db = $baseModel->getConnection();
    }

    /**
     * Lấy báo cáo Lãi/Lỗ cho TẤT CẢ các chuyến khởi hành.
     * Hàm này thực hiện việc tính toán Tổng Thu và Tổng Chi gán cho mỗi chuyến đi.
     */
    public function getProfitLossReport()
    {
        $sql = "
            SELECT 
                td.id AS departure_id,
                t.name AS tour_name,
                td.start_date,
                
                -- Tính TỔNG THU (REVENUE) từ bảng financial_transactions
                COALESCE(SUM(CASE WHEN ft.transaction_type = 'Revenue' THEN ft.amount ELSE 0 END), 0) AS total_revenue,
                
                -- Tính TỔNG CHI (EXPENSE) từ bảng financial_transactions
                COALESCE(SUM(CASE WHEN ft.transaction_type = 'Expense' THEN ft.amount ELSE 0 END), 0) AS total_expense
                
            FROM tour_departures td
            
            -- Nối với bảng Tour để lấy tên Tour
            JOIN tours t ON td.tour_id = t.id
            
            -- Nối với bảng Giao dịch Tài chính
            LEFT JOIN financial_transactions ft ON td.id = ft.departure_id
            
            -- Nhóm kết quả theo chuyến đi để tổng hợp Thu và Chi
            GROUP BY td.id, t.name, td.start_date
            
            ORDER BY td.start_date DESC;
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Bạn có thể thêm các hàm báo cáo khác tại đây (ví dụ: getSummaryByMonth)
}