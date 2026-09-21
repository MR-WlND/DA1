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
            if ($user['role'] !== 'customer') {
                $error = 'Tài khoản không hợp lệ cho luồng khách hàng. Vui lòng truy cập trang dành cho quản trị.';
                require_once PATH_VIEW . 'auth/login.php';
                exit;
            }

            $_SESSION['user'] = $user;
            header("Location: index.php?action=public-tours");
            exit;
        } else {
            $error = 'Sai email hoặc mật khẩu!';
            require_once PATH_VIEW . 'auth/login.php';
            exit;
        }
    }

    public function adminIndex()
    {
        require_once PATH_VIEW . 'auth/admin_login.php';
    }

    public function handleAdminLogin()
    {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $userModel = new UserModel();
        $user = $userModel->findByEmailAndPassword($email, $password);

        if ($user) {
            if (!in_array($user['role'], ['admin', 'guide'])) {
                $error = 'Tài khoản không có quyền truy cập trang quản trị.';
                require_once PATH_VIEW . 'auth/admin_login.php';
                exit;
            }

            $_SESSION['user'] = $user;

            switch ($user['role']) {
                case 'admin':
                    header("Location: index.php?action=dashboard");
                    break;
                case 'guide':
                    header("Location: index.php?action=schedule");
                    break;
            }
            exit;
        } else {
            $error = 'Sai email hoặc mật khẩu!';
            require_once PATH_VIEW . 'auth/admin_login.php';
            exit;
        }
    }

    public function logout()
    {
        $role = $_SESSION['user']['role'] ?? '';
        session_destroy();
        
        if (in_array($role, ['admin', 'guide'])) {
            header("Location: index.php?action=admin-login");
        } else {
            header("Location: index.php?action=login");
        }
        exit;
    }
}
