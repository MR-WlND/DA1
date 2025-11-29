<?php
require_once __DIR__ . '/../configs/database.php';
class BookingModel
{
    private $conn;
    private $pdo;    // 👈 thêm dòng này vào

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function all()
    {
        $sql = "SELECT b.*, u.name AS user_name, r.name AS room_name
                FROM bookings b
                JOIN users u ON b.user_id = u.id
                JOIN rooms r ON b.room_id = r.id
                ORDER BY b.id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   
    public function find($id)
    {
        $sql = "SELECT b.*, u.name AS user_name, r.name AS room_name
                FROM bookings b
                JOIN users u ON b.user_id = u.id
                JOIN rooms r ON b.room_id = r.id
                WHERE b.id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   
    public function isRoomAvailable($room_id, $start_date, $end_date, $ignore_id = null)
    {
        $sql = "SELECT COUNT(*) 
                FROM bookings
                WHERE room_id = :room_id
                AND (
                        (start_date <= :end_date AND end_date >= :start_date)
                    )";

        
        if (!empty($ignore_id)) {
            $sql .= " AND id != :ignore_id";
        }

        $stmt = $this->conn->prepare($sql);

        $params = [
            'room_id'    => $room_id,
            'start_date' => $start_date,
            'end_date'   => $end_date
        ];

        if (!empty($ignore_id)) {
            $params['ignore_id'] = $ignore_id;
        }

        $stmt->execute($params);

        return $stmt->fetchColumn() == 0;
    }

    public function insert($data)
    {
        $sql = "INSERT INTO bookings (user_id, room_id, start_date, end_date, total_price)
                VALUES (:user_id, :room_id, :start_date, :end_date, :total_price)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    public function update($id, $data)
    {
        $data['id'] = $id;

        $sql = "UPDATE bookings 
                SET user_id = :user_id,
                    room_id = :room_id,
                    start_date = :start_date,
                    end_date = :end_date,
                    total_price = :total_price
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    
    public function delete($id)
    {
        $sql = "DELETE FROM bookings WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
