<?php
class DepartureModel {
    public $db;

    public function __construct() {
        $baseModel = new BaseModel();
        $this->db = $baseModel->getConnection();
    }

    // Lấy danh sách departure kèm remaining_slots
    public function getList() {
        $sql = "SELECT
                    td.id AS departure_id,
                    t.name AS tour_name,
                    td.start_date,
                    td.end_date,
                    td.current_price,
                    td.available_slots AS max_slots,
                    td.available_slots - IFNULL(COUNT(BC.id), 0) AS remaining_slots
                FROM tour_departures td
                JOIN tours t ON td.tour_id = t.id
                LEFT JOIN bookings b ON b.departure_id = td.id
                LEFT JOIN booking_customers BC ON BC.booking_id = b.id AND b.status IN ('Confirmed', 'Pending')
                GROUP BY td.id, t.name, td.start_date, td.end_date, td.current_price, td.available_slots
                ORDER BY td.start_date ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function insert($tour_id, $start_date, $end_date, $current_price, $available_slots) {
        $sql = "INSERT INTO tour_departures(tour_id,start_date,end_date,current_price,available_slots)
                VALUES(:tour_id,:start_date,:end_date,:current_price,:available_slots)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':tour_id'=>$tour_id,
            ':start_date'=>$start_date,
            ':end_date'=>$end_date,
            ':current_price'=>$current_price,
            ':available_slots'=>$available_slots
        ]);
    }

    public function getOne($id) {
        $sql = "SELECT * FROM tour_departures WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id'=>$id]);
        return $stmt->fetch();
    }

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

    public function delete($id) {
        $sql = "DELETE FROM tour_departures WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id'=>$id]);
    }
}
