<?php
class BookingModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $sql = "SELECT b.*, u.name AS user_name, t.title AS tour_title 
                FROM bookings b
                JOIN users u ON b.user_id = u.id
                JOIN tours t ON b.tour_id = t.id
                ORDER BY b.id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $status) {
        $sql = "UPDATE bookings SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$status, $id]);
    }
}
