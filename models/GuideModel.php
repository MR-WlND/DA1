<?php

class GuideModel
{
    public $db;
    protected $tableUser = 'users';
    protected $tableProfile = 'guide_profiles';

    public function __construct()
    {
        $baseModel = new BaseModel();
        $this->db = $baseModel->getConnection();
    }

    public function getAll()
    {
        $sql = "SELECT u.*, gp.* 
                FROM {$this->tableUser} u
                JOIN {$this->tableProfile} gp ON u.id = gp.user_id
                WHERE u.role='guide'
                ORDER BY u.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getOne($id)
    {
        $sql = "SELECT u.*, gp.* 
                FROM {$this->tableUser} u
                JOIN {$this->tableProfile} gp ON u.id = gp.user_id
                WHERE u.id=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function insert($email, $password, $name, $phone, $category, $specialty_route, $specialty_group, $certification, $health_status, $notes, $date_of_birth, $photo_url, $experience_years, $languages)
    {
        $sqlUser = "INSERT INTO {$this->tableUser} (email, password, name, phone, role)
                    VALUES (:email, :password, :name, :phone, 'guide')";
        $stmt = $this->db->prepare($sqlUser);
        $stmt->execute([
            ':email' => $email,
            ':password' => password_hash($password, PASSWORD_DEFAULT),
            ':name' => $name,
            ':phone' => $phone
        ]);

        $userId = $this->db->lastInsertId();

        $sqlProfile = "INSERT INTO {$this->tableProfile} 
            (user_id, category, specialty_route, specialty_group, certification, health_status, notes, date_of_birth, photo_url, experience_years, languages)
            VALUES (:user_id, :category, :specialty_route, :specialty_group, :certification, :health_status, :notes, :date_of_birth, :photo_url, :experience_years, :languages)";
        $stmt = $this->db->prepare($sqlProfile);
        $stmt->execute([
            ':user_id' => $userId,
            ':category' => $category,
            ':specialty_route' => $specialty_route,
            ':specialty_group' => $specialty_group,
            ':certification' => $certification,
            ':health_status' => $health_status,
            ':notes' => $notes,
            ':date_of_birth' => $date_of_birth,
            ':photo_url' => $photo_url,
            ':experience_years' => $experience_years,
            ':languages' => $languages
        ]);
    }

    public function update($id, $email, $name, $phone, $category, $specialty_route, $specialty_group, $certification, $health_status, $notes, $date_of_birth, $photo_url, $experience_years, $languages)
    {
        $sqlUser = "UPDATE {$this->tableUser} 
                    SET email=:email, name=:name, phone=:phone
                    WHERE id=:id";
        $stmt = $this->db->prepare($sqlUser);
        $stmt->execute([
            ':id' => $id,
            ':email' => $email,
            ':name' => $name,
            ':phone' => $phone
        ]);

        $sqlProfile = "UPDATE {$this->tableProfile} 
                       SET category=:category, specialty_route=:specialty_route, specialty_group=:specialty_group,
                           certification=:certification, health_status=:health_status, notes=:notes,
                           date_of_birth=:date_of_birth, photo_url=:photo_url, experience_years=:experience_years, languages=:languages
                       WHERE user_id=:user_id";
        $stmt = $this->db->prepare($sqlProfile);
        $stmt->execute([
            ':user_id' => $id,
            ':category' => $category,
            ':specialty_route' => $specialty_route,
            ':specialty_group' => $specialty_group,
            ':certification' => $certification,
            ':health_status' => $health_status,
            ':notes' => $notes,
            ':date_of_birth' => $date_of_birth,
            ':photo_url' => $photo_url,
            ':experience_years' => $experience_years,
            ':languages' => $languages
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM {$this->tableUser} WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
}
