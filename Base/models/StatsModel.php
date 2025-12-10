<?php
class StatsModel extends BaseModel
{
    protected $db;

    public function __construct()
    {
        parent::__construct();  // ⚠️ Quan trọng!
        $this->db = $this->getConnection();
    }

    public function getGlobalStats()
    {
        // ❌ Không được check !$this->db — vì PDO object luôn TRUE
        // Chỉ cần check instance đúng:
        if (!($this->db instanceof PDO)) {
            return [
                'total_revenue' => 0,
                'paid_bookings_count' => 0,
                'total_bookings_count' => 0,
                'total_users' => 0,
                'total_customers' => 0,
                'error' => 'Không thể kết nối DB'
            ];
        }

        // --- TRUY VẤN ---
        $sqlRevenue = "SELECT IFNULL(SUM(total_price),0) AS total_revenue,
                              COUNT(id) AS paid_bookings_count
                       FROM bookings 
                       WHERE payment_status = 'Paid'";
        $revenue = $this->db->query($sqlRevenue)->fetch(PDO::FETCH_ASSOC);

        $sqlTotalBookings = "SELECT COUNT(id) AS total_bookings_count FROM bookings";
        $totalBookings = $this->db->query($sqlTotalBookings)->fetch(PDO::FETCH_ASSOC);

        $sqlUsers = "SELECT COUNT(id) AS total_users FROM users";
        $users = $this->db->query($sqlUsers)->fetch(PDO::FETCH_ASSOC);

        $sqlCustomers = "SELECT COUNT(id) AS total_customers FROM booking_customers";
        $customers = $this->db->query($sqlCustomers)->fetch(PDO::FETCH_ASSOC);

        return array_merge($revenue, $totalBookings, $users, $customers);
    }
}
