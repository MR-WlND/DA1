<?php
class TourController
{
    public function listTour()
    {
        $tour = new TourModel();
        $listTour = $tour->getList();
        $view = "admin/tour/list-tour";
        require_once PATH_VIEW . 'main.php';
    }
    public function createTour()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tourModel = new TourModel();
            $tourModel->insert(
                $_POST['name'],
                $_POST['tour_type'],
                $_POST['description'],
                $_POST['base_price'],
                $_POST['cancellation_policy'],
                $_POST['destination_id'],
                $_POST['image'] ?? null
            );
            header('Location:' . BASE_URL . '?action=list-tour');
            exit();
        }
        $view = "admin/tour/create-tour";
        require_once PATH_VIEW . 'main.php';
    }
    public function updateTour()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . '?action=list-tour');
            exit();
        }

        $tourModel = new TourModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tourModel->update(
                $id,
                $_POST['name'],
                $_POST['tour_type'],
                $_POST['description'],
                $_POST['base_price'],
                $_POST['cancellation_policy'],
                $_POST['destination_id'],
                $_POST['image']
            );
            header('Location: ' . BASE_URL . '?action=list-tour');
            exit();
        }

        $tour = $tourModel->getOne($id);
        if (!$tour) {
            header('Location: ' . BASE_URL . '?action=list-tour');
            exit();
        }
        require_once PATH_VIEW . 'admin/tour/update-tour.php';
    }
    public function detailTour()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . '?action=list-tour');
            exit();
        }

        $tourModel = new TourModel();
        $tour = $tourModel->getOne($id);

        if (empty($tour)) {
            header('Location: ' . BASE_URL . '?action=list-tour');
            exit();
        }

        require_once PATH_VIEW . 'admin/tour/detail-tour.php';
    }
    public function deleteTour()
    {
        $tour = new TourModel();
        $tour->delete($_GET['id']);
        header('Location: index.php?action=list-tour');
        exit();
    }
}
