<?php
require_once __DIR__ . '/../configs/database.php';

class RoomModel
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function all()
    {
        $sql = "SELECT * FROM rooms";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $sql = "SELECT * FROM rooms WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}
