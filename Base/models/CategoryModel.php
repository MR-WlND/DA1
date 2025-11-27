    <?php
    class CategoryModel extends BaseModel
    {
        protected $table = "tour_categories";

        public function getList()
        {
            $sql = "SELECT * FROM tour_categories";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function getOne($id)
        {
            $sql = "SELECT * FROM tour_categories WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([":id" => $id]);
            return $stmt->fetch();
        }

        public function insert($name, $description)
        {
            $sql = "INSERT INTO tour_categories (name, description) VALUES (:name, :description)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ":name" => $name,
                ":description" => $description
            ]);
        }

        public function update($id, $name, $description)
        {
            $sql = "UPDATE tour_categories SET name = :name, description = :description WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ":id" => $id,
                ":name" => $name,
                ":description" => $description
            ]);
        }

        public function delete($id)
        {
            $sql = "DELETE FROM tour_categories WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([":id" => $id]);
        }
    }
    ?>
