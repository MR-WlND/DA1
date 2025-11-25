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
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $destinationModel = new DestinationModel();
            $listDestinations = $destinationModel->getList();

            $categoryModel = new CategoryModel();
            $listCategories = $categoryModel->getList();
            // GET → hiện form
            $view = "admin/tour/create-tour";
            require_once PATH_VIEW . 'main.php';
        } else {
            // POST → xử lý dữ liệu
            $file = $_FILES['image'] ?? null;
            $path = '';
            if ($file && $file['error'] === UPLOAD_ERR_OK) {
                $path = upload_file('tours', $file);
            }

            $tourModel = new TourModel();
            $tourModel->insert(
                $_POST['name'] ?? '',
                $_POST['tour_type'] ?? '',
                $_POST['description'] ?? '',
                $_POST['base_price'] ?? 0,
                $_POST['cancellation_policy'] ?? '',
                $_POST['destination_id'] ?? null,
                $_POST['category_id'] ?? null,
                $path,              
            );

            header('Location:' . BASE_URL . '?action=list-tour');
            exit();
        }
    }

    public function updateTour()
    {
        $tourModel = new TourModel();
        $tour = $tourModel->getOne($_GET['id']);

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $destinationModel = new DestinationModel();
            $listDestinations = $destinationModel->getList();

            $categoryModel = new CategoryModel();
            $listCategories = $categoryModel->getList();
            // GET → hiện form với dữ liệu cũ
            $view = "admin/tour/update-tour";
            require_once PATH_VIEW . 'main.php';
        } else {
            // POST → xử lý upload file
            $file = $_FILES['image'] ?? null;
            $path = $tour['image']; // giữ ảnh cũ
            if ($file && $file['error'] === UPLOAD_ERR_OK) {
                // Xóa ảnh cũ nếu có
                if (!empty($tour['image']) && file_exists(PATH_ASSETS_UPLOADS . 'tours/' . $tour['image'])) {
                    unlink(PATH_ASSETS_UPLOADS . 'tours/' . $tour['image']);
                }
                // Upload ảnh mới
                $path = upload_file('tours', $file);
            }

            // Cập nhật tour
            $tourModel->update(
                $_GET['id'],
                $_POST['name'] ?? '',
                $_POST['tour_type'] ?? '',
                $_POST['description'] ?? '',
                $_POST['base_price'] ?? 0,
                $_POST['cancellation_policy'] ?? '',
                $_POST['destination_id'] ?? null,
                $_POST['category_id'] ?? null,
                $path,
            );

            header('Location:' . BASE_URL . '?action=list-tour');
            exit();
        }
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
        $tourModel = new TourModel();
        $tour = $tourModel->getOne($_GET['id']); // Lấy thông tin tour trước khi xóa

        if (isset($tour['image']) != "") {
            unlink(PATH_ASSETS_UPLOADS . '/' . $tour['image']);
        }
        $tourModel->delete($_GET['id']);
        header('Location:' . BASE_URL . '?action=list-tour');
        exit();
    }
}
