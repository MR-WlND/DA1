<?php

class AuthController
{
    public function index()
    {
        require_once PATH_VIEW . 'auth/login.php';
    }

    public function handleLogin()
    {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $userModel = new UserModel();
        $user = $userModel->findByEmailAndPassword($email, $password);

        if ($user) {
            $_SESSION['user'] = $user;

            switch ($user['role']) {
                case 'admin':
                    header("Location: index.php?action=adminDashboard");
                    break;
                default:
                    header("Location: index.php?action=guideSchedule");
                    break;
            }
            exit;
        } else {
            $error = 'Sai email hoặc mật khẩu!';
            require_once PATH_VIEW . 'auth/login.php';
            exit;
        }
    }

    public function logout()
    {
        session_destroy();
        header("Location: index.php?action=login");
        exit;
    }
}
