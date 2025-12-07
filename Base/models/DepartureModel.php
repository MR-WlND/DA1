<?php
class DepartureModel {
    public $db;

    public function __construct() {
        $baseModel = new BaseModel();
        $this->db = $baseModel->getConnection();
    }

    // Lấy danh sách departure kèm remaining_slots
    // Trong DepartureModel.php
/**
 * Lấy danh sách lịch khởi hành kèm tồn kho còn lại.
 * Nếu $tour_id được cung cấp, sẽ lọc theo Tour đó.
 */
public function getList($tour_id = null) {
    
    // 1. Khởi tạo mệnh đề WHERE (để hàm có thể lọc theo tour_id)
    $where_clause = '';
    $params = [];

    if ($tour_id) {
        $where_clause = "WHERE td.tour_id = :tour_id";
        $params[':tour_id'] = $tour_id;
    }
    
    $sql = "SELECT
                td.id AS departure_id,
                t.name AS tour_name,
                td.start_date,
                td.end_date,
                td.current_price,
                td.available_slots AS max_slots,
                
                -- LOGIC TÍNH TOÁN TỒN KHO CỐT LÕI
                td.available_slots - IFNULL(COUNT(BC.id), 0) AS remaining_slots
                
            FROM tour_departures td
            JOIN tours t ON td.tour_id = t.id
            LEFT JOIN bookings b ON b.departure_id = td.id
            LEFT JOIN booking_customers BC ON BC.booking_id = b.id AND b.status IN ('Confirmed', 'Pending') 
            
            {$where_clause} /* Chèn mệnh đề WHERE vào đây */
            
            GROUP BY td.id, t.name, td.start_date, td.end_date, td.current_price, td.available_slots
            ORDER BY td.start_date ASC";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute($params); 
    
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

public function saveDeparturesForTour($tour_id, $departures = []) {
    // 1. XÓA TẤT CẢ LỊCH KHỞI HÀNH CŨ (Bắt buộc khi UPDATE Tour)
    $this->db->prepare("DELETE FROM tour_departures WHERE tour_id = :tour_id")
             ->execute([':tour_id' => $tour_id]);
    // 2. CHÈN LẠI CÁC LỊCH KHỞI HÀNH MỚI
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
                // Đảm bảo xử lý NULL cho available_slots nếu không có dữ liệu
                ':available_slots' => $dep['available_slots'] ?? 0, 
            ]);
        }
    }
}
    
}
