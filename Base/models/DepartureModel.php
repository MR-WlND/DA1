<?php
class DepartureModel {
    public $db;

    public function __construct() {
        $baseModel = new BaseModel();
        $this->db = $baseModel->getConnection();
    }

    /**
     * Lấy danh sách lịch khởi hành + số chỗ còn lại
     * Hỗ trợ lọc theo tour_id
     */
public function getList($tour_id = null) {

    $where = "";
    $params = [];

    if (!empty($tour_id)) {
        $where = "WHERE td.tour_id = :tour_id";
        $params[':tour_id'] = $tour_id;
    }

    $sql = "
        SELECT
            td.id AS departure_id,
            t.name AS tour_name,
            td.start_date,
            td.end_date,
            td.current_price,
            td.available_slots AS max_slots,

            -- Số chỗ còn lại = available_slots - số khách
            td.available_slots - IFNULL(COUNT(BC.id), 0) AS remaining_slots

        FROM tour_departures td
        JOIN tours t ON td.tour_id = t.id

        -- KHÔNG DÙNG b.status NỮA (vì đã xóa)
        LEFT JOIN bookings b 
            ON b.departure_id = td.id

        LEFT JOIN booking_customers BC 
            ON BC.booking_id = b.id

        $where
        GROUP BY td.id
        ORDER BY td.start_date ASC
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    /** Thêm departure */
    public function insert($tour_id, $start_date, $end_date, $current_price, $available_slots) {
        $sql = "INSERT INTO tour_departures(tour_id,start_date,end_date,current_price,available_slots)
                VALUES(:tour_id,:start_date,:end_date,:current_price,:available_slots)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':tour_id' => $tour_id,
            ':start_date' => $start_date,
            ':end_date' => $end_date,
            ':current_price' => $current_price,
            ':available_slots' => $available_slots
        ]);
    }

    /** Lấy 1 departure */
    public function getOne($id) {
        $sql = "SELECT * FROM tour_departures WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id'=>$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /** Update departure */
    public function update($id, $tour_id, $start_date, $end_date, $current_price, $available_slots) {
        $sql = "UPDATE tour_departures SET
                    tour_id=:tour_id,
                    start_date=:start_date,
                    end_date=:end_date,
                    current_price=:current_price,
                    available_slots=:available_slots
                WHERE id=:id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id'=>$id,
            ':tour_id'=>$tour_id,
            ':start_date'=>$start_date,
            ':end_date'=>$end_date,
            ':current_price'=>$current_price,
            ':available_slots'=>$available_slots
        ]);
    }

    /**
     * Kiểm tra xem departure có booking nào không
     */
    public function hasBookings($id) {
        $sql = "SELECT COUNT(*) FROM bookings WHERE departure_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetchColumn() > 0;
    }

    /** Xóa departure */
    public function delete($id) {
        $sql = "DELETE FROM tour_departures WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id'=>$id]);
    }

    /**
     * Lưu danh sách departures khi UPDATE Tour
     */
    public function saveDeparturesForTour($tour_id, $departures = []) {

        // 1. Xóa hết lịch cũ
        $this->db->prepare("DELETE FROM tour_departures WHERE tour_id = :tour_id")
                 ->execute([':tour_id' => $tour_id]);

        // 2. Thêm mới
        if (!empty($departures)) {
            $sql = "INSERT INTO tour_departures 
                    (tour_id, start_date, end_date, current_price, available_slots) 
                    VALUES (:tour_id, :start_date, :end_date, :current_price, :available_slots)";

            $stmt = $this->db->prepare($sql);

            foreach ($departures as $dep) {
                $stmt->execute([
                    ':tour_id' => $tour_id,
                    ':start_date' => $dep['start_date'],
                    ':end_date' => $dep['end_date'],
                    ':current_price' => $dep['current_price'],
                    ':available_slots' => $dep['available_slots'] ?? 0
                ]);
            }
        }
    }
}
