<?php
class HotelController
{
    public function listHotel()
    {
        requireAdmin();
        $model = new HotelModel();
        $listHotel = $model->getList();
        $title = "list";
        $view = "admin/hotel/list-hotel";
        require_once PATH_VIEW . 'main.php';
    }

    public function createHotel()
    {
        requireAdmin();
        $destinationModel = new DestinationModel();
        $listDestination = $destinationModel->getList();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $title = "create";
            $view = "admin/hotel/create-hotel";
            require_once PATH_VIEW . 'main.php';
        } else {
            $name = $_POST['name'];
            $address = $_POST['address'] ?? '';
            $destination_id = $_POST['destination_id'];

            $model = new HotelModel();
            $model->insert($name, $address, $destination_id);

            header("Location: " . BASE_URL . "?action=list-hotel");
            exit;
        }
    }

    public function updateHotel()
    {
        requireAdmin();
        $model = new HotelModel();
        $data = $model->getOne($_GET['id']);
        if (!$data) {
            echo "KhĂ¡ch sáº¡n khĂ´ng tá»“n táº¡i!";
            return;
        }

        $destinationModel = new DestinationModel();
        $listDestination = $destinationModel->getList();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $title = "update";
            $view = "admin/hotel/update-hotel";
            require_once PATH_VIEW . 'main.php';
        } else {
            $name = $_POST['name'];
            $address = $_POST['address'] ?? '';
            $destination_id = $_POST['destination_id'];

            $model->update($_GET['id'], $name, $address, $destination_id);

            header("Location: " . BASE_URL . "?action=list-hotel");
            exit;
        }
    }

    public function deleteHotel()
    {
        requireAdmin();
        $model = new HotelModel();
        $data = $model->getOne($_GET['id']);
        if (!$data) {
            echo "KhĂ¡ch sáº¡n khĂ´ng tá»“n táº¡i!";
            return;
        }

        $model->delete($_GET['id']);
        header("Location: " . BASE_URL . "?action=list-hotel");
        exit;
    }
}
?>

