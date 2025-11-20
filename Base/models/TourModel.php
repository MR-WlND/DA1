<?php

class TourModel extends BaseModel
{
    public function getList()
    {
        $sql = "SELECT `id`, `name`, `tour_type`, `description`, `base_price`, `cancellation_policy`, `destination_id`, `image`, `created_at`
        FROM `tours`";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function insert($name, $tour_type, $description, $base_price, $cancellation_policy, $destination_id, $image)
    {
        $sql = "INSERT INTO `tours`(`name`, `tour_type`, `description`, `base_price`, `cancellation_policy`, `destination_id`, `image`) 
                VALUES (:name, :tour_type, :description, :base_price, :cancellation_policy, :destination_id, :image)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':tour_type' => $tour_type,
            ':description' => $description,
            ':base_price' => $base_price,
            ':cancellation_policy' => $cancellation_policy,
            ':destination_id' => $destination_id,
            ':image' => $image,
        ]);
    }

    public function getOne($id)
    {
        $sql = "SELECT tours.* FROM tours
        WHERE tours.id=:id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    public function update($id, $name, $tour_type, $description, $base_price, $cancellation_policy, $destination_id, $image)
    {
        $sql = "UPDATE `tours` SET
                `name` = :name,
                `tour_type` = :tour_type,
                `description` = :description,
                `base_price` = :base_price,
                `cancellation_policy` = :cancellation_policy,
                `destination_id` = :destination_id,
                `image` = :image
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':tour_type' => $tour_type,
            ':description' => $description,
            ':base_price' => $base_price,
            ':cancellation_policy' => $cancellation_policy,
            ':destination_id' => $destination_id,
            ':image' => $image,
        ]);
    }
    public function delete($id)
    {
        $sql = "DELETE FROM `tours` WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

}
?>
