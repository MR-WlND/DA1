<?php
class TourModel {
    private $db;

    public function __construct() {
        $baseModel = new BaseModel();
        $this->db = $baseModel->getConnection();
    }

    /** Lấy danh sách tour */
    public function getList() {
        $sql = "SELECT t.*, c.name AS category_name
                FROM tours t
                LEFT JOIN tour_categories c ON t.category_id = c.id
                ORDER BY t.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /** Lấy chi tiết tour */
    public function getOne($id) {
        $sql = "SELECT t.*, c.name AS category_name
                FROM tours t
                LEFT JOIN tour_categories c ON t.category_id = c.id
                WHERE t.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $tour = $stmt->fetch();

        if ($tour) {
            $tour['destinations'] = $this->getDestinations($id);
            $tour['departures']   = $this->getDepartures($id);
        }

        return $tour;
    }

    /** Tạo tour mới */
    public function insert($name, $tour_type, $description, $base_price, $cancellation_policy, $image, $category_id, $tour_origin, $destinations = [], $departures = []) {
        $sql = "INSERT INTO tours 
                (name, tour_type, description, base_price, cancellation_policy, image, category_id, tour_origin)
                VALUES (:name, :tour_type, :description, :base_price, :cancellation_policy, :image, :category_id, :tour_origin)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':tour_type' => $tour_type,
            ':description' => $description,
            ':base_price' => $base_price,
            ':cancellation_policy' => $cancellation_policy,
            ':image' => $image,
            ':category_id' => $category_id,
            ':tour_origin' => $tour_origin
        ]);

        $tour_id = $this->db->lastInsertId();

        // Chèn lộ trình (N:M)
        $this->saveDestinations($tour_id, $destinations);

        // Chèn lịch khởi hành
        $this->saveDepartures($tour_id, $departures);

        return $tour_id;
    }

    /** Cập nhật tour */
    public function update($id, $name, $tour_type, $description, $base_price, $cancellation_policy, $image, $category_id, $tour_origin, $destinations = [], $departures = []) {
        $sql = "UPDATE tours SET
                    name = :name,
                    tour_type = :tour_type,
                    description = :description,
                    base_price = :base_price,
                    cancellation_policy = :cancellation_policy,
                    image = :image,
                    category_id = :category_id,
                    tour_origin = :tour_origin
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':tour_type' => $tour_type,
            ':description' => $description,
            ':base_price' => $base_price,
            ':cancellation_policy' => $cancellation_policy,
            ':image' => $image,
            ':category_id' => $category_id,
            ':tour_origin' => $tour_origin
        ]);

        // Cập nhật lộ trình (N:M)
        $this->saveDestinations($id, $destinations);

        // Cập nhật lịch khởi hành
        $this->saveDepartures($id, $departures);
    }

    /** Xóa tour */
    public function delete($id) {
        // Xóa các liên kết tour_destinations
        $sql = "DELETE FROM tour_destinations WHERE tour_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        // Xóa các lịch khởi hành
        $sql2 = "DELETE FROM tour_departures WHERE tour_id = :id";
        $stmt2 = $this->db->prepare($sql2);
        $stmt2->execute([':id' => $id]);

        // Xóa tour
        $sql3 = "DELETE FROM tours WHERE id = :id";
        $stmt3 = $this->db->prepare($sql3);
        $stmt3->execute([':id' => $id]);
    }

    /** Lấy destinations của tour */
    public function getDestinations($tour_id) {
        $sql = "SELECT d.*
                FROM tour_destinations td
                JOIN destinations d ON td.destination_id = d.id
                WHERE td.tour_id = :tour_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':tour_id' => $tour_id]);
        return $stmt->fetchAll();
    }

    /** Lấy departures của tour */
    public function getDepartures($tour_id) {
        $sql = "SELECT td.*
                FROM tour_departures td
                WHERE td.tour_id = :tour_id
                ORDER BY td.start_date ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':tour_id' => $tour_id]);
        return $stmt->fetchAll();
    }

    /** Lưu lộ trình tour: Xóa cũ và chèn mới */
    private function saveDestinations($tour_id, $destinations = []) {
        // Xóa cũ
        $sql = "DELETE FROM tour_destinations WHERE tour_id = :tour_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':tour_id' => $tour_id]);

        // Chèn mới
       if (!empty($destinations)) {
        $sql2 = "INSERT INTO tour_destinations (tour_id, destination_id, order_number) VALUES (:tour_id, :destination_id, :order_number)";
        $stmt2 = $this->db->prepare($sql2);
           foreach ($destinations as $dest) {
            $stmt2->execute([
                ':tour_id' => $tour_id,
                // BẮT BUỘC: Dữ liệu gửi từ Controller phải chứa 'destination_id' và 'order_number'
                ':destination_id' => $dest['destination_id'], 
                ':order_number' => $dest['order_number'] 
            ]);
            }
        }
    }

    /** Lưu lịch khởi hành: Xóa cũ và chèn mới */
    private function saveDepartures($tour_id, $departures = []) {
        // Xóa cũ
        $sql = "DELETE FROM tour_departures WHERE tour_id = :tour_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':tour_id' => $tour_id]);

        // Chèn mới
        if (!empty($departures)) {
            $sql2 = "INSERT INTO tour_departures (tour_id, start_date, end_date, current_price, available_slots)
                     VALUES (:tour_id, :start_date, :end_date, :current_price, :available_slots)";
            $stmt2 = $this->db->prepare($sql2);
            foreach ($departures as $dep) {
                $stmt2->execute([
                    ':tour_id' => $tour_id,
                    ':start_date' => $dep['start_date'],
                    ':end_date' => $dep['end_date'],
                    ':current_price' => $dep['current_price'],
                    ':available_slots' => $dep['available_slots']
                ]);
            }
        }
    }
}
