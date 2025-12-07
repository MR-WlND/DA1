<?php

class GuideController
{
    public function listGuide()
    {
        $guides = new GuideModel();
        $listGuides = $guides->getAll();
        $title = "Danh sách hướng dẫn viên";
        $view = "admin/guides/list-guide";
        require_once PATH_VIEW . 'main.php';
    }

    public function createGuide()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $title = "Thêm hướng dẫn viên";
            $view = "admin/guides/create-guide";
            require_once PATH_VIEW . 'main.php';
        } else {
            $file = $_FILES['photo_url'] ?? null;
            $photoPath = '';
            if ($file && $file['error'] === UPLOAD_ERR_OK) {
                $photoPath = upload_file('avatar', $file);
            }

            $guides = new GuideModel();
            $guides->insert(
                $_POST['email'],
                $_POST['password'],
                $_POST['name'],
                $_POST['phone'],
                $_POST['category'],
                $_POST['specialty_route'],
                $_POST['specialty_group'],
                $_POST['certification'],
                $_POST['health_status'],
                $_POST['notes'],
                !empty($_POST['date_of_birth']) ? $_POST['date_of_birth'] : null,
                $photoPath,
                !empty($_POST['experience_years']) ? $_POST['experience_years'] : null,
                !empty($_POST['languages']) ? trim($_POST['languages']) : null
            );

            header('Location:' . BASE_URL . '?action=list-guide');
        }
    }

    public function updateGuide()
    {
        $guides = new GuideModel();
        $data = $guides->getOne($_GET['id']);

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $title = "Cập nhật hướng dẫn viên";
            $view = "admin/guides/update-guide";
            require_once PATH_VIEW . 'main.php';
        } else {
            $file = $_FILES['photo_url'] ?? null;
            $photoPath = $data['photo_url'] ?? '';

            if ($file && $file['error'] === UPLOAD_ERR_OK) {
                if (!empty($photoPath) && file_exists(PATH_ASSETS_UPLOADS . '/avatar/' . $photoPath)) {
                    unlink(PATH_ASSETS_UPLOADS . '/avatar/' . $photoPath);
                }
                $photoPath = upload_file('avatar', $file);
            }

            $guides->update(
                $_GET['id'],
                $_POST['email'],
                $_POST['name'],
                $_POST['phone'],
                $_POST['category'],
                $_POST['specialty_route'],
                $_POST['specialty_group'],
                $_POST['certification'],
                $_POST['health_status'],
                $_POST['notes'],
                !empty($_POST['date_of_birth']) ? $_POST['date_of_birth'] : null,
                $photoPath,
                !empty($_POST['experience_years']) ? $_POST['experience_years'] : null,
                !empty($_POST['languages']) ? trim($_POST['languages']) : null
            );

            header('Location:' . BASE_URL . '?action=list-guide');
        }
    }

    public function deleteGuide()
    {
        $guides = new GuideModel();
        $data = $guides->getOne($_GET['id']);
        if (isset($data['photo_url']) != "") {
            unlink(PATH_ASSETS_UPLOADS . $data['photo_url']);
        }

        $guides->delete($_GET['id']);
        header('Location:' . BASE_URL . '?action=list-guide');
    }
    public function detailGuide()
    {
        $guides = new GuideModel();
        $data = $guides->getOne($_GET['id']); // Lấy thông tin guide theo id

        $title = "Chi tiết hướng dẫn viên";
        $view = "admin/guides/detail-guide";
        require_once PATH_VIEW . 'main.php';
    }

    public function viewDashboard()
    {
        // Kiểm tra session để lấy ID HDV đang đăng nhập (Bắt buộc)
        $guideId = $_SESSION['user']['id'];
        
        $guideModel = new GuideModel();
        
        // Lấy danh sách các chuyến đi được giao cho HDV này
        $assignedDepartures = $guideModel->getAssignedDepartures($guideId);
        
        $title = "Dashboard Hướng dẫn viên";
        $view = "guide/dashboard"; // View dành riêng cho HDV
        require_once PATH_VIEW . 'main.php'; 
    }
}
