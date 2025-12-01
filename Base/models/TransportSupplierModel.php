<?php

class TransportSupplierModel extends BaseModel
{
    // Dùng public để đơn giản hóa truy cập (theo yêu cầu)
    public $pdo; 
    public $table = "transport_suppliers"; 

    public function __construct()
    {
        // Khởi tạo kết nối DB từ BaseModel
        $baseModel = new BaseModel();
        $this->pdo = $baseModel->getConnection();
    }

    /** Lấy danh sách NCC Vận tải */
    public function getList()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY supplier_name ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /** Lấy chi tiết 1 NCC Vận tải theo ID */
    public function getOne($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":id" => $id]);
        return $stmt->fetch();
    }

    /** Thêm NCC Vận tải mới */
    public function insert($supplier_name, $contact_person, $phone, $email, $details)
    {
        $sql = "INSERT INTO {$this->table} (supplier_name, contact_person, phone, email, details) 
                VALUES (:supplier_name, :contact_person, :phone, :email, :details)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ":supplier_name" => $supplier_name,
            ":contact_person" => $contact_person,
            ":phone" => $phone,
            ":email" => $email,
            ":details" => $details
        ]);
        return $this->pdo->lastInsertId();
    }

    /** Cập nhật NCC Vận tải */
    public function update($id, $supplier_name, $contact_person, $phone, $email, $details)
    {
        $sql = "UPDATE {$this->table} SET 
                supplier_name = :supplier_name, 
                contact_person = :contact_person, 
                phone = :phone, 
                email = :email, 
                details = :details
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ":id" => $id,
            ":supplier_name" => $supplier_name,
            ":contact_person" => $contact_person,
            ":phone" => $phone,
            ":email" => $email,
            ":details" => $details
        ]);
    }

    /** Xóa NCC Vận tải */
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([":id" => $id]);
    }
}