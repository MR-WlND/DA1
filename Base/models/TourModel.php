<?php

class TourModel extends BaseModel
{
    public function getList()
    {
        $sql = "SELECT 
        tours.*, 
        destinations.name AS destination_name, 
        destinations.country AS destination_country,
        tour_categories.name AS category_name
    FROM tours
    LEFT JOIN destinations ON tours.destination_id = destinations.id
    LEFT JOIN tour_categories ON tours.category_id = tour_categories.id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function insert($name, $tour_type, $description, $base_price, $cancellation_policy, $destination_id, $category_id, $image)
{
    $sql = "INSERT INTO `tours`(`name`, `tour_type`, `description`, `base_price`, `cancellation_policy`, `destination_id`, `category_id`, `image`) 
            VALUES (:name, :tour_type, :description, :base_price, :cancellation_policy, :destination_id, :category_id, :image)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':tour_type' => $tour_type,
        ':description' => $description,
        ':base_price' => $base_price,
        ':cancellation_policy' => $cancellation_policy,
        ':destination_id' => $destination_id,
        ':category_id' => $category_id, // phải có
        ':image' => $image,
    ]);
}

    public function getOne($id)
    {
        $sql = "SELECT tours.*, 
                   destinations.name AS destination_name, 
                   destinations.country AS destination_country, 
                   tour_categories.name AS category_name
            FROM tours
            LEFT JOIN destinations ON tours.destination_id = destinations.id
            LEFT JOIN tour_categories ON tours.category_id = tour_categories.id
            WHERE tours.id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
    public function update($id, $name, $tour_type, $description, $base_price, $cancellation_policy, $destination_id, $category_id, $image)
{
    $sql = "UPDATE `tours` SET
            `name` = :name,
            `tour_type` = :tour_type,
            `description` = :description,
            `base_price` = :base_price,
            `cancellation_policy` = :cancellation_policy,
            `destination_id` = :destination_id,
            `category_id` = :category_id,
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
        ':category_id' => $category_id, // phải có
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
