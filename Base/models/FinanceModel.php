<?php

class FinanceModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'finances';
    }

    // Lấy tổng doanh thu
    public function getTotalRevenue()
    {
        $stmt = $this->pdo->prepare("SELECT SUM(amount) AS total_revenue FROM {$this->table} WHERE type = 'revenue'");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_revenue'] ?? 0;
    }

    // Lấy doanh thu theo tháng
    public function getMonthlyRevenue($months = 6)
    {
        $stmt = $this->pdo->prepare("
            SELECT DATE_FORMAT(date, '%Y-%m') AS month, SUM(amount) AS revenue
            FROM {$this->table}
            WHERE type = 'revenue' AND date >= DATE_SUB(CURDATE(), INTERVAL :months MONTH)
            GROUP BY month
            ORDER BY month DESC
            LIMIT :months
        ");
        $stmt->bindValue(':months', (int)$months, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
