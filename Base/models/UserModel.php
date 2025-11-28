<?php

class UserModel extends BaseModel
{
    protected $table = "users";
    public $pdo;

    public function __construct()
    {
        $baseModel = new BaseModel();
        $this->pdo = $baseModel->getConnection();
    }

    // LOGIN
    public function findByEmailAndPassword($email, $password)
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user && md5($password) === $user['password']) {
            unset($user['password']);
            return $user;
        }

        return null;
    }

    // LIST
    public function getList()
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // CREATE
    public function insert($name, $email, $password, $phone, $role)
    {
        $sql = "INSERT INTO users (name, email, password, phone, role)
                VALUES (:name, :email, :password, :phone, :role)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => md5($password),
            ':phone' => $phone,
            ':role' => $role,
        ]);
    }

    // GET 1 USER
    public function getOne($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // UPDATE
    public function update($id, $name, $email, $password, $phone, $role)
    {
        // Nếu không nhập mật khẩu mới -> giữ nguyên mật khẩu cũ
        if (empty($password)) {
            $stmt = $this->pdo->prepare("SELECT password FROM users WHERE id = :id LIMIT 1");
            $stmt->execute([':id' => $id]);
            $password = $stmt->fetchColumn();
        } else {
            $password = md5($password);
        }

        $sql = "UPDATE users SET
                    name = :name,
                    email = :email,
                    password = :password,
                    phone = :phone,
                    role = :role
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':email' => $email,
            ':password' => $password,
            ':phone' => $phone,
            ':role' => $role,
        ]);
    }

    // DELETE
    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}

