<?php

class UserModel extends BaseModel
{
    protected $table = 'users';
    public $pdo;
    public function __construct()
    {
        $baseModel = new BaseModel();
        $this->pdo = $baseModel->getConnection();
    }
    public function findByEmailAndPassword($email, $password)
    {
        $sql = "SELECT `id`, `name`, `email`, `password`, `role`, `phone`, `hdv_experience`, `hdv_languages`, `created_at` 
        FROM `users` 
        WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':email' => $email,
        ]);
        $user = $stmt->fetch();

        if ($user && md5($password, $user['password'])) {
            unset($user['password']);
            return $user;
        }

        // Trả về null nếu không tìm thấy người dùng hoặc mật khẩu không khớp
        return null;
    }

    public function getList()
    {
        $sql = "SELECT `id`, `name`, `email`, `password`, `role`, `phone`, `hdv_experience`, `hdv_languages`, `created_at` 
        FROM `users`";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function insert($name, $email, $password, $phone, $role, $hdv_experience = null, $hdv_languages = null)
    {
        $sql = "INSERT INTO `users`(`name`, `email`, `password`, `phone`, `role`, `hdv_experience`, `hdv_languages`) 
        VALUES (:name, :email, :password, :phone, :role, :hdv_experience, :hdv_languages)";
        $stmt = $this->pdo->prepare($sql);

        // Mã hóa mật khẩu trước khi lưu
        $hashedPassword = md5($password);

        // Nếu role không phải là 'guide', đảm bảo giá trị là null


        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => $hashedPassword,
            ':phone' => $phone,
            ':role' => $role,
            ':hdv_experience' => ($hdv_experience === '') ? null : $hdv_experience,
            ':hdv_languages' => ($hdv_languages === '') ? null : $hdv_languages,
        ]);
    }
    public function getOne($id)
    {
        $sql = "SELECT users.* FROM users
        WHERE users.id=:id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    public function update($id, $name, $email, $password, $phone, $role, $hdv_experience, $hdv_languages)
    {
        $hdv_experience = ($hdv_experience === '' ? null : $hdv_experience);
        $hdv_languages = ($hdv_languages === '' ? null : $hdv_languages);
        $sql = "UPDATE `users` SET
        `name` = :name,
        `email` = :email,
        `password` = :password,
        `phone` = :phone,
        `role` = :role,
        `hdv_experience` = :hdv_experience,
        `hdv_languages` = :hdv_languages
        WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':email' => $email,
            ':password' => md5($password),
            ':phone' => $phone,
            ':role' => $role,
            ':hdv_experience' => $hdv_experience,
            ':hdv_languages' => $hdv_languages,
        ]);
    }
    public function delete($id)
    {
        $sql = "DELETE FROM `users` WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
}
