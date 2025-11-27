<?php
class HotelController
{
    public function listHotel()
    {
        $model = new HotelModel();
        $listHotel = $model->getList();
        $title = "list";
        $view = "admin/hotel/list-hotel";
        require_once PATH_VIEW . 'main.php';
    }

    public function createHotel()
    {
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
        $model = new HotelModel();
        $data = $model->getOne($_GET['id']);
        if (!$data) {
            echo "Khách sạn không tồn tại!";
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
        $model = new HotelModel();
        $data = $model->getOne($_GET['id']);
        if (!$data) {
            echo "Khách sạn không tồn tại!";
            return;
        }

        $model->delete($_GET['id']);
        header("Location: " . BASE_URL . "?action=list-hotel");
        exit;
    }
}
?>
