<?php
// File: models/TourLogModel.php

class TourLogModel extends BaseModel
{
    protected $table = "tour_logs";
    public $db;

    public function __construct() {
        $baseModel = new BaseModel();   // Tạo instance BaseModel
        $this->db = $baseModel->getConnection();  // Lấy kết nối PDO
    }

    /**
     * Lấy tất cả log cho một chuyến đi cụ thể.
     * @param int $departureId ID của chuyến đi
     * @return array Danh sách log
     */
    public function getLogsByDepartureId($departureId)
    {
        $sql = "SELECT tl.*, u.name as staff_name 
                FROM {$this->table} tl
                JOIN users u ON u.id = tl.staff_id
                WHERE tl.departure_id = :departure_id
                ORDER BY tl.log_date DESC"; // Log mới nhất ở trên

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':departure_id' => $departureId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Thêm một log mới vào chuyến đi.
     */
    public function addLog($departureId, $staffId, $content, $type = 'note')
    {
        $sql = "INSERT INTO {$this->table} 
                (departure_id, staff_id, log_content, log_type) 
                VALUES (:dep_id, :staff_id, :content, :type)";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':dep_id'  => $departureId,
            ':staff_id' => $staffId,
            ':content' => $content,
            ':type'    => $type
        ]);
    }
}