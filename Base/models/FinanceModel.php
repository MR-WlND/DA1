<?php
// File: models/FinanceModel.php

class FinanceModel extends BaseModel
{
    public $db;
    public $table = "financial_transactions"; // Tên bảng

    public function __construct()
    {
        $baseModel = new BaseModel();
        $this->db = $baseModel->getConnection();
    }

    // 1. Lấy danh sách Giao dịch (Có JOIN để lấy tên Tour)
    public function getList()
    {
        $sql = "
            SELECT 
                ft.*,
                td.start_date,
                t.name AS tour_name
            FROM financial_transactions ft
            LEFT JOIN tour_departures td ON ft.departure_id = td.id
            LEFT JOIN tours t ON td.tour_id = t.id
            ORDER BY ft.transaction_date DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // 2. Lấy chi tiết 1 Giao dịch
    public function getOne($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // 3. Thêm Giao dịch mới (CREATE)
    public function insert($data)
    {
        $sql = "INSERT INTO {$this->table} (departure_id, transaction_type, amount, description, transaction_date)
                VALUES (:departure_id, :transaction_type, :amount, :description, :transaction_date)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':departure_id' => $data['departure_id'] ?? null,
            ':transaction_type' => $data['transaction_type'],
            ':amount' => $data['amount'],
            ':description' => $data['description'] ?? null,
            ':transaction_date' => $data['transaction_date']
        ]);
        return $this->db->lastInsertId();
    }

    // 4. Cập nhật Giao dịch (UPDATE)
    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table} SET departure_id=:departure_id, transaction_type=:transaction_type, 
                amount=:amount, description=:description, transaction_date=:transaction_date
                WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':departure_id' => $data['departure_id'] ?? null,
            ':transaction_type' => $data['transaction_type'],
            ':amount' => $data['amount'],
            ':description' => $data['description'] ?? null,
            ':transaction_date' => $data['transaction_date']
        ]);
    }

    // 5. Xóa Giao dịch (DELETE)
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}