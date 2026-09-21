<?php
class UsersController {

    public function listAdmin() {
        requireAdmin();
        $user = new UserModel();
        $listUser = $user->getList();

        $view = "admin/user/list-admin";
        require_once PATH_VIEW . "main.php";
    }
    public function listCustomer() {
        requireAdmin();
        $user = new UserModel();
        $listUser = $user->getList();

        $view = "admin/user/list-customer";
        require_once PATH_VIEW . "main.php";
    }

    public function createUser() {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $model = new UserModel();
            $model->insert(
                $_POST['name'],
                $_POST['email'],
                $_POST['password'],
                $_POST['phone'],
                $_POST['role'],
            );

            header("Location: " . BASE_URL . "?action=list-customer");
            exit();
        }

        $view = "admin/user/create-user";
        require_once PATH_VIEW . "main.php";
    }

    public function updateUser() {
        requireAdmin();
        $model = new UserModel();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $user = $model->getOne($_GET['id']);
            $view = "admin/user/update-user";
            require_once PATH_VIEW . "main.php";
            return;
        }

        // POST UPDATE
        $model->update(
            $_GET['id'],
            $_POST['name'],
            $_POST['email'],
            $_POST['password'],  // có thể rỗng
            $_POST['phone'],
            $_POST['role'],
        );

        header("Location: " . BASE_URL . "?action=list-customer");
        exit();
    }

    public function detailUser() {
        checkAuth();
        $model = new UserModel();
        $user = $model->getOne($_GET['id']);

        $view = "admin/user/detail-user";
        require_once PATH_VIEW . "main.php";
    }

    public function deleteUser() {
        requireAdmin();
        $model = new UserModel();
        $model->delete($_GET['id']);
        header("Location: " . BASE_URL . "?action=list-customer");
    }
}
