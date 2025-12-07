<?php
class DestinationModel extends BaseModel
{
    protected $table = "destinations";

    public function getList()
    {
        $sql = "SELECT * FROM destinations ORDER BY id ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getOne($id)
    {
        $sql = "SELECT * FROM destinations WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":id" => $id]);
        return $stmt->fetch();
    }
    public function getOneByName($name)
    {
        $sql = "SELECT * FROM destinations WHERE name = :name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":name" => $name]);
        return $stmt->fetch();
    }
    public function insert($name, $country, $type)
    {
        $sql = "INSERT INTO destinations (name, country, type) VALUES (:name, :country, :type)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ":name" => $name,
            ":country" => $country,
            ":type" => $type
        ]);
    }

    public function update($id, $name, $country, $type)
    {
        $sql = "UPDATE destinations SET name = :name, country = :country, type = :type WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ":id" => $id,
            ":name" => $name,
            ":country" => $country,
            ":type" => $type
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM destinations WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":id" => $id]);
    }
    public function saveDeparturesForTour($tour_id, $departures = []) {
    
    // 1. Lặp qua tất cả các dòng dữ liệu khởi hành gửi từ form
    if (empty($departures)) {
        return; 
    }
    
    foreach ($departures as $dep) {
        // Lấy ID chuyến khởi hành cũ (Nếu tồn tại, nó là bản ghi UPDATE)
        // ID này được truyền từ View update-tour.php (input type=hidden)
        $departureId = $dep['id'] ?? null; 

        // Các biến cần thiết
        $startDate = $dep['start_date'];
        $endDate = $dep['end_date'];
        $currentPrice = $dep['current_price'];
        $availableSlots = $dep['available_slots'];

        if ($departureId && is_numeric($departureId)) {
            // THAO TÁC 1: UPDATE (Nếu đây là bản ghi cũ - Bỏ qua DELETE để tránh lỗi FK)
            $sql = "UPDATE tour_departures SET start_date=:start_date, end_date=:end_date, current_price=:current_price, available_slots=:available_slots WHERE id=:id AND tour_id=:tour_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id' => $departureId,
                ':tour_id' => $tour_id,
                ':start_date' => $startDate,
                ':end_date' => $endDate,
                ':current_price' => $currentPrice,
                ':available_slots' => $availableSlots
            ]);

        } else {
            // THAO TÁC 2: INSERT (Nếu đây là bản ghi hoàn toàn mới)
            $sql = "INSERT INTO tour_departures (tour_id, start_date, end_date, current_price, available_slots) 
                    VALUES (:tour_id, :start_date, :end_date, :current_price, :available_slots)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':tour_id' => $tour_id,
                ':start_date' => $startDate,
                ':end_date' => $endDate,
                ':current_price' => $currentPrice,
                ':available_slots' => $availableSlots
            ]);
        }
    }
}
}
