<?php

class DestinationController
{
    public function listDestination()
    {
        requireAdmin();
        $model = new DestinationModel();
        $listDestination = $model->getList();
        $title = "list";
        $view = "admin/destination/list-destination";
        require_once PATH_VIEW . 'main.php';
    }

    public function createDestination()
    {
        requireAdmin();
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

            // Kiá»ƒm tra trĂ¹ng tĂªn
            $existing = $model->getOneByName($name);
            if ($existing) {
                echo "TĂªn Ä‘iá»ƒm Ä‘áº¿n Ä‘Ă£ tá»“n táº¡i!";
                return;
            }

            $model->insert($name, $country, $type);
            header("Location: " . BASE_URL . "?action=list-destination");
            exit;
        }
    }

    public function updateDestination()
    {
        requireAdmin();
        $model = new DestinationModel();
        $data = $model->getOne($_GET['id']);
        if (!$data) {
            echo "Äiá»ƒm Ä‘áº¿n khĂ´ng tá»“n táº¡i!";
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

            // Kiá»ƒm tra trĂ¹ng tĂªn
            $existing = $model->getOneByName($name);
            if ($existing && $existing['id'] != $_GET['id']) {
                echo "TĂªn Ä‘iá»ƒm Ä‘áº¿n Ä‘Ă£ tá»“n táº¡i!";
                return;
            }

            $model->update($_GET['id'], $name, $country, $type);
            header("Location: " . BASE_URL . "?action=list-destination");
            exit;
        }
    }

    public function deleteDestination()
    {
        requireAdmin();
        $destinationID = $_GET['id'];
        $tourModel = new TourModel();
        $tourCount = $tourModel->countToursByDestinationId($destinationID);

        if ($tourCount > 0) {
            $_SESSION['error'] = "KhĂ´ng thá»ƒ xĂ³a Ä‘iá»ƒm Ä‘áº¿n nĂ y vĂ¬ Ä‘ang cĂ³ tour thuá»™c Ä‘iá»ƒm Ä‘áº¿n nĂ y.";
        } else {
            $destinationModel = new DestinationModel();
            $destinationModel->delete($destinationID);
            $_SESSION['success'] = "XĂ³a Ä‘iá»ƒm Ä‘áº¿n thĂ nh cĂ´ng!";
        }

        header("Location: " . BASE_URL . "?action=list-destination");
        exit;
    }
}

