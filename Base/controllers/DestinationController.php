<?php

class DestinationController
{
    public function listDestination()
    {
        $model = new DestinationModel();
        $listDestination = $model->getList();
        $title = "list";
        $view = "admin/destination/list-destination";
        require_once PATH_VIEW . 'main.php';
    }

    public function createDestination()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $listType = ['City', 'Country', 'Region'];
            $title = "create";
            $view = "admin/destination/create-destination";
            require_once PATH_VIEW . 'main.php';
        } else {
            $name = $_POST['name'];
            $country = $_POST['country'];
            $type = $_POST['type'] ?? 'City';

            $model = new DestinationModel();

            // Kiểm tra trùng tên
            $existing = $model->getOneByName($name);
            if ($existing) {
                echo "Tên điểm đến đã tồn tại!";
                return;
            }

            $model->insert($name, $country, $type);
            header("Location: " . BASE_URL . "?action=list-destination");
            exit;
        }
    }

    public function updateDestination()
    {
        $model = new DestinationModel();
        $data = $model->getOne($_GET['id']);
        if (!$data) {
            echo "Điểm đến không tồn tại!";
            return;
        }

        $listType = ['City', 'Country', 'Region'];

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $title = "update";
            $view = "admin/destination/update-destination";
            require_once PATH_VIEW . 'main.php';
        } else {
            $name = $_POST['name'];
            $country = $_POST['country'];
            $type = $_POST['type'] ?? 'City';

            // Kiểm tra trùng tên
            $existing = $model->getOneByName($name);
            if ($existing && $existing['id'] != $_GET['id']) {
                echo "Tên điểm đến đã tồn tại!";
                return;
            }

            $model->update($_GET['id'], $name, $country, $type);
            header("Location: " . BASE_URL . "?action=list-destination");
            exit;
        }
    }

    public function deleteDestination()
    {
        $model = new DestinationModel();
        $data = $model->getOne($_GET['id']);
        if (!$data) {
            echo "Điểm đến không tồn tại!";
            return;
        }

        $model->delete($_GET['id']);
        header("Location: " . BASE_URL . "?action=list-destination");
        exit;
    }
}
