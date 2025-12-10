<?php

class ReportModel extends BaseModel
{
    public $db;

    public function __construct()
    {
        $baseModel = new BaseModel();
        $this->db = $baseModel->getConnection();
    }

    /**
     * Lấy báo cáo Lãi/Lỗ tổng hợp từ Bookings, Resources và Transactions.
     */
    public function getProfitLossReport()
    {
        $sql = "
            SELECT 
                td.id AS departure_id,
                t.name AS tour_name,
                td.start_date,
                
                -- 1. TÍNH DOANH THU (REVENUE)
                (
                    -- Tiền từ Booking (Chỉ tính đã thanh toán 'Paid')
                    COALESCE((SELECT SUM(total_price) FROM bookings b WHERE b.departure_id = td.id AND b.payment_status = 'Paid'), 0)
                    +
                    -- Cộng thêm thu nhập khác từ sổ cái
                    COALESCE((SELECT SUM(amount) FROM financial_transactions ft WHERE ft.departure_id = td.id AND ft.transaction_type = 'Revenue'), 0)
                ) AS total_revenue,
                
                -- 2. TÍNH CHI PHÍ (EXPENSE)
                (
                    -- Chi phí hậu cần (Khách sạn, Xe, HDV)
                    COALESCE((SELECT SUM(cost) FROM departure_resources dr WHERE dr.departure_id = td.id), 0)
                    +
                    -- Cộng thêm chi phí khác từ sổ cái
                    COALESCE((SELECT SUM(amount) FROM financial_transactions ft WHERE ft.departure_id = td.id AND ft.transaction_type = 'Expense'), 0)
                ) AS total_expense
                
            FROM tour_departures td
            JOIN tours t ON td.tour_id = t.id
            
            -- Chỉ hiện các chuyến đi đã có doanh thu hoặc chi phí
            HAVING total_revenue > 0 OR total_expense > 0
            
            ORDER BY td.start_date DESC;
        ";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}