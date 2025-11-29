<?php

class CancellationPolicyController
{
    public function listPolicies()
    {
        $model = new CancellationPolicyModel();
        $listPolicies = $model->getList();

        $title = "Danh sách chính sách hủy";
        $view = "admin/policies/list-policies";
        require_once PATH_VIEW . 'main.php';
    }

    public function createPolicy()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            $title = "Thêm chính sách hủy";
            $view = "admin/policies/create-policy";

            require_once PATH_VIEW . 'main.php';

        } else {

            $model = new CancellationPolicyModel();
            $model->insert(
                $_POST['policy_name'],
                $_POST['details']
            );

            header("Location: " . BASE_URL . "?action=list-policies");
        }
    }

    public function updatePolicy() {
    $policyModel = new CancellationPolicyModel();

    $id = $_GET['id'];
    $policy = $policyModel->getOne($id); // Lấy chính sách từ DB

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $title = "update";
        $view = "admin/policies/update-policy"; // Đường dẫn view
        require_once PATH_VIEW . 'main.php';
    } else {
        $policyModel->update(
            $id,
            $_POST['policy_name'],
            $_POST['details']
        );
        header('Location:' . BASE_URL . '?action=list-policies');
    }
}


    public function deletePolicy()
    {
        $model = new CancellationPolicyModel();
        $model->delete($_GET['id']);

        header("Location: " . BASE_URL . "?action=list-policies");
    }
}

