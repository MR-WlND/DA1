<?php
class HotelModel extends BaseModel
{
    protected $table = "hotels";

    public function getList()
    {
        $sql = "SELECT h.*, d.name AS destination_name 
                FROM hotels h
                LEFT JOIN destinations d ON h.destination_id = d.id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getOne($id)
    {
        $sql = "SELECT * FROM hotels WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":id" => $id]);
        return $stmt->fetch();
    }

    public function insert($name, $address, $destination_id)
    {
        $sql = "INSERT INTO hotels (name, address, destination_id) 
                VALUES (:name, :address, :destination_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ":name" => $name,
            ":address" => $address,
            ":destination_id" => $destination_id
        ]);
    }

    public function update($id, $name, $address, $destination_id)
    {
        $sql = "UPDATE hotels 
                SET name = :name, address = :address, destination_id = :destination_id 
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ":id" => $id,
            ":name" => $name,
            ":address" => $address,
            ":destination_id" => $destination_id
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM hotels WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":id" => $id]);
    }
}
?>
