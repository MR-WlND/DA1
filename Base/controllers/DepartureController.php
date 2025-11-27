<?php
class DepartureController
{
    public function listDeparture()
    {
        $departure = new DepartureModel();
        $listDeparture = $departure->getList();
        $title = "list";
        $view = "admin/departure/list-departure";
        require_once PATH_VIEW . 'main.php';
    }

    public function createDeparture()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $tourModel = new TourModel(); // hoặc TourModel tùy bạn đặt tên
            $listTours = $tourModel->getList(); // Lấy tất cả tour
            $title = "create";
            $view = "admin/departure/create-departure";
            require_once PATH_VIEW . 'main.php';
        } else {
            $departure = new DepartureModel();
            $departure->insert(
                $_POST['tour_id'],
                $_POST['start_date'],
                $_POST['end_date'],
                $_POST['current_price'],
                $_POST['available_slots']
            );
            header('Location:' . BASE_URL . '?action=list-departure');
        }
    }

    public function updateDeparture()
    {
        $departure = new DepartureModel();
        $data = $departure->getOne($_GET['id']); // Lấy dữ liệu hiện tại
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $tour = new TourModel();
            $listTour = $tour->getList();
            $title = "update";
            $view = "admin/departure/update-departure";
            require_once PATH_VIEW . 'main.php';
        } else {
            $departure->update(
                $_GET['id'],
                $_POST['tour_id'],
                $_POST['start_date'],
                $_POST['end_date'],
                $_POST['current_price'],
                $_POST['available_slots']
            );
            header('Location:' . BASE_URL . '?action=list-departure');
        }
    }

    public function deleteDeparture()
    {
        $departure = new DepartureModel();
        $departure->delete($_GET['id']);
        header('Location:' . BASE_URL . '?action=list-departure');
    }
    public function listDepartureByTour() {
        $tour_id = $_GET['tour_id'] ?? null;
        if (!$tour_id) {
            header('Location: ' . BASE_URL . '?action=list-tour');
            exit;
        }

        $departureModel = new DepartureModel();
        $listDepartures = $departureModel->getListByTour($tour_id);

        $title = "Lịch khởi hành Tour";
        $view = "list-departure-by-tour"; // file view
        require_once PATH_VIEW . 'main.php';
    }
}
