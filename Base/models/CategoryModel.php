<?php 
class CategoryModel extends BaseModel
{
    public function getList() 
    {
        $sql = "SELECT `id`, `name`, `description`, `created_at` FROM `tour_categories`";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getOne($id)
    {
        $sql = "SELECT tour_categories.* FROM tour_categories
        WHERE tour_categories.id=:id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    public function insert($name, $description)
    {
        $sql = "INSERT INTO `tour_categories`(`name`, `description`) 
                VALUES (:name, :description)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':description' => $description,
        ]);
    }
    public function update($id, $name, $description)
    {
        $sql = "UPDATE `tour_categories` SET
                `name` = :name,
                `description` = :description
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':description' => $description,
        ]);
    }
    public function delete($id)
    {
        $sql = "DELETE FROM `tour_categories` WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
}
?>