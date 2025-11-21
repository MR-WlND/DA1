<?php

class UserModel extends BaseModel
{
    protected $table = 'users';

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

        if ($user && md5($password) === $user['password']) { 
            unset($user['password']);
            return $user;
        }

        // Trả về null nếu không tìm thấy người dùng hoặc mật khẩu không khớp
        return null;
    }
}
