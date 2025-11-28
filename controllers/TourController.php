<?php
class TourController {

    public function listTour() {
        $tourModel = new TourModel();
        $listTour = $tourModel->getList();
        $title = "list";
        $view = "admin/tours/list-tour"; // Lưu ý: đường dẫn theo folder views/admin/tour/
        require_once PATH_VIEW . 'main.php';
    }

    public function createTour() {
    $tourModel = new TourModel();
        $categoryModel = new CategoryModel();
        $destinationModel = new DestinationModel();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $listCategories = $categoryModel->getList();
            $listDestinations = $destinationModel->getList();
        $title = "create";
        $view = "admin/tours/create-tour";
        require_once PATH_VIEW . 'main.php';
    } else {
            // Xử lý ảnh upload
            $file = $_FILES['image'];
        $imagePath = '';
            if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
            $imagePath = upload_file('tours', $file);
        }

            // Destinations được chọn (mảng id)
        $destinations = $_POST['destinations'] ?? [];

            // Departures: mảng các lịch khởi hành (nếu có)
            $departures = $_POST['departures'] ?? [];

        $tourModel->insert(
                $_POST['name'],
                $_POST['tour_type'],
                $_POST['description'],
                $_POST['base_price'],
                $_POST['cancellation_policy'],
            $imagePath,
                $_POST['category_id'],
                $_POST['tour_origin'],
                $destinations,
                $departures,
        );

        header('Location:' . BASE_URL . '?action=list-tour');
    }
}

    public function updateTour() {
        $tourModel = new TourModel();
        $categoryModel = new CategoryModel();
        $destinationModel = new DestinationModel();

        $tour_id = $_GET['id'];
        $data = $tourModel->getOne($tour_id);

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $listCategories = $categoryModel->getList();
            $listDestinations = $destinationModel->getList();
            $title = "update";
            $view = "admin/tours/update-tour";
            require_once PATH_VIEW . 'main.php';
        } else {
            // Xử lý ảnh upload
            $file = $_FILES['image'];
            $imagePath = $data['image'];
            if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
                if (!empty($data['image'])) {
                    unlink(PATH_ASSETS_UPLOADS . '/' . $data['image']);
                }
                $imagePath = upload_file('tours', $file);
            }

            $destinations = $_POST['destinations'] ?? [];
            $departures = $_POST['departures'] ?? [];

            $tourModel->update(
                $tour_id,
                $_POST['name'],
                $_POST['tour_type'],
                $_POST['description'],
                $_POST['base_price'],
                $_POST['cancellation_policy'],
                $imagePath,
                $_POST['category_id'],
                $_POST['tour_origin'],
                $destinations,
                $departures
            );

            header('Location:' . BASE_URL . '?action=list-tour');
        }
    }

    public function deleteTour() {
        $tourModel = new TourModel();
        $tour_id = $_GET['id'];
        $tourModel->delete($tour_id);
        header('Location:' . BASE_URL . '?action=list-tour');
    }

    public function detailTour() {
        $tourModel = new TourModel();
        $tour_id = $_GET['id'];
        $data = $tourModel->getOne($tour_id);

        $title = "detail";
        $view = "admin/tours/detail-tour";
        require_once PATH_VIEW . 'main.php';
    }
}
