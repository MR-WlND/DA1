<?php
    class UsersController{
        public function listUser()
    {
        $user = new UserModel();
        $listUser = $user->getList();
        $view = "admin/user/list-user";
        require_once PATH_VIEW . 'main.php';
    }
    public function createUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Xử lý dữ liệu gửi lên
            $userModel = new UserModel();
            $userModel->insert(
                $_POST['name'],
                $_POST['email'],
                $_POST['password'],
                $_POST['phone'],
                $_POST['role'],
                $_POST['hdv_experience'] ?? null,
                $_POST['hdv_languages'] ?? null
            );
            header('Location:' . BASE_URL . '?action=list-user');
            exit();
        }
        // Hiển thị form tạo mới
        // Sửa lại để sử dụng layout chính
        $view = "admin/user/create-user";
        require_once PATH_VIEW . 'main.php';
    }
    public function updateUser()
    {
        $userModel = new UserModel();
        $data = $userModel->getOne($_GET['id']);
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Lấy thông tin chi tiết của người dùng để hiển thị ra form
            $user = $userModel->getOne($_GET['id']);
            // Hiển thị view update-user.php và truyền dữ liệu user vào
            require_once PATH_VIEW . 'admin/user/update-user.php';
        } else {
            // Xử lý dữ liệu từ form POST để cập nhật
            $userModel->update(
                $_GET['id'],
                $_POST['name'], 
                $_POST['email'], 
                $_POST['password'], 
                $_POST['phone'], 
                $_POST['role'], 
                $_POST['hdv_experience'], 
                $_POST['hdv_languages']
            );

            // Sau khi cập nhật, chuyển hướng về trang danh sách user
            header('Location:' . BASE_URL . '?action=list-user');
            exit();
        }
    }
    public function detailUser()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            // Nếu không có ID, chuyển hướng về trang danh sách
            header('Location: ' . BASE_URL . '?action=list-user');
            exit();
        }

        $userModel = new UserModel();
        $user = $userModel->getOne($id);

        if (empty($user)) {
            header('Location: ' . BASE_URL . '?action=list-user');
            exit();
        }

        require_once PATH_VIEW . 'admin/user/detail-user.php';
    }
    public function deleteUser()
    {
        $user = new UserModel();
        $user->delete($_GET['id']);
        header('Location: index.php?action=list-user');
        exit();
    }
    }
?>