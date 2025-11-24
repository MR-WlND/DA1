<?php

class BookingModel extends BaseModel
{
    protected $table = 'bookings';

    // Lấy tất cả booking
    public function getAll()
    {
        return $this->all();
    }

    // Hàm all() chung
    public function all()
    {
        $sql = "SELECT * FROM $this->table";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy 1 booking theo id
    public function find($id)
    {
        $sql = "SELECT * FROM bookings WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm booking
    public function store($data)
    {
        $sql = "
            INSERT INTO bookings (customer_name, tour_id, quantity, total_price)
            VALUES (:customer_name, :tour_id, :quantity, :total_price)
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':customer_name' => $data['customer_name'],
            ':tour_id'       => $data['tour_id'],
            ':quantity'      => $data['quantity'],
            ':total_price'   => $data['total_price'],
        ]);
    }

    // Cập nhật booking
    public function update($id, $data)
    {
        $sql = "
            UPDATE bookings
            SET customer_name = :customer_name,
                tour_id       = :tour_id,
                quantity      = :quantity,
                total_price   = :total_price
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':customer_name' => $data['customer_name'],
            ':tour_id'       => $data['tour_id'],
            ':quantity'      => $data['quantity'],
            ':total_price'   => $data['total_price'],
            ':id'            => $id,
        ]);
    }

    // Xóa booking
    public function delete($id)
    {
        $sql = "DELETE FROM bookings WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    // Lấy danh sách tour
    public function getTours()
    {
        $sql = "SELECT id, name FROM tours";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
