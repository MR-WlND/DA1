<?php
class BookingModel extends BaseModel {
    // Lấy tất cả booking theo tour_id
    public function getByTour($tour_id) {
        $sql = "SELECT b.*, td.start_date, td.end_date
                FROM bookings b
                JOIN tour_departures td ON b.departure_id = td.id
                WHERE td.tour_id = :tour_id
                ORDER BY td.start_date ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':tour_id' => $tour_id]);
        return $stmt->fetchAll();
    }

    // Lấy chi tiết một booking theo id
    public function getOne($id) {
        $sql = "SELECT b.*, td.start_date, td.end_date, t.name AS tour_name
                FROM bookings b
                JOIN tour_departures td ON b.departure_id = td.id
                JOIN tours t ON td.tour_id = t.id
                WHERE b.id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}
?>
