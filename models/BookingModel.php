<?php
require_once __DIR__ . '/../Database.php';
class BookingModel
{
    private $conn;

    public function __construct()
    {

        $this->conn = Database::connect();
    }
    public function getAll()
    {
        $sql = "SELECT 
                b.*, 
                t.name AS tour_name
            FROM bookings b
            JOIN tour_departures td ON b.departure_id = td.id
            JOIN tours t ON td.tour_id = t.id
            ORDER BY b.id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getById($id)
    {
        $sql = "SELECT b.*, t.title AS tour_name
                FROM bookings b
                JOIN tours t ON b.tour_id = t.id
                WHERE b.id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function create($data)
    {
        $sql = "INSERT INTO bookings (tour_id, customer_name, email, phone, created_at)
                VALUES (:tour_id, :customer_name, :email, :phone, NOW())";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':tour_id', $data['tour_id']);
        $stmt->bindParam(':customer_name', $data['customer_name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':phone', $data['phone']);
        return $stmt->execute();
    }


    public function update($id, $data)
    {
        $sql = "UPDATE bookings SET
                    tour_id = :tour_id,
                    customer_name = :customer_name,
                    email = :email,
                    phone = :phone
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':tour_id', $data['tour_id']);
        $stmt->bindParam(':customer_name', $data['customer_name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }


    public function delete($id)
    {
        $sql = "DELETE FROM bookings WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

