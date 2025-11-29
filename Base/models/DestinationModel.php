<?php
class DestinationModel extends BaseModel
{
    protected $table = "destinations";

    public function getList()
    {
        $sql = "SELECT * FROM destinations ORDER BY id ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getOne($id)
    {
        $sql = "SELECT * FROM destinations WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":id" => $id]);
        return $stmt->fetch();
    }
    public function getOneByName($name)
    {
        $sql = "SELECT * FROM destinations WHERE name = :name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":name" => $name]);
        return $stmt->fetch();
    }
    public function insert($name, $country, $type)
    {
        $sql = "INSERT INTO destinations (name, country, type) VALUES (:name, :country, :type)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ":name" => $name,
            ":country" => $country,
            ":type" => $type
        ]);
    }

    public function update($id, $name, $country, $type)
    {
        $sql = "UPDATE destinations SET name = :name, country = :country, type = :type WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ":id" => $id,
            ":name" => $name,
            ":country" => $country,
            ":type" => $type
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM destinations WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":id" => $id]);
    }
}
