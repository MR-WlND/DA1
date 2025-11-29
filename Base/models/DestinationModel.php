<?php
class DestinationModel
{
    public $db;

    public function __construct()
    {
        // Lấy kết nối PDO từ BaseModel
        $baseModel = new BaseModel();
        $this->db = $baseModel->getConnection();
    }

    // Lấy tất cả destinations
    public function getList()
    {
        $sql = "SELECT * FROM destinations";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getOne($id)
    {
        $sql = "SELECT * FROM destinations WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}