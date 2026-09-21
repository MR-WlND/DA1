<?php

class GuideController
{
    public function listGuide()
    {
        requireAdmin();
        $guides = new GuideModel();
        $listGuides = $guides->getAll();
        $title = "Danh sĂ¡ch hÆ°á»›ng dáº«n viĂªn";
        $view = "admin/guides/list-guide";
        require_once PATH_VIEW . 'main.php';
    }

    public function createGuide()
    {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $title = "ThĂªm hÆ°á»›ng dáº«n viĂªn";
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
        requireAdmin();
        $guides = new GuideModel();
        $data = $guides->getOne($_GET['id']);

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $title = "Cáº­p nháº­t hÆ°á»›ng dáº«n viĂªn";
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
        requireAdmin();
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
        requireAdmin();
        $guides = new GuideModel();
        $data = $guides->getOne($_GET['id']); // Láº¥y thĂ´ng tin guide theo id

        $title = "Chi tiáº¿t hÆ°á»›ng dáº«n viĂªn";
        $view = "admin/guides/detail-guide";
        require_once PATH_VIEW . 'main.php';
    }

    public function viewDashboard()
    {
        requireAdmin();
        // Kiá»ƒm tra session Ä‘á»ƒ láº¥y ID HDV Ä‘ang Ä‘Äƒng nháº­p (Báº¯t buá»™c)
        $guideId = $_SESSION['user']['id'];
        
        $guideModel = new GuideModel();
        
        // Láº¥y danh sĂ¡ch cĂ¡c chuyáº¿n Ä‘i Ä‘Æ°á»£c giao cho HDV nĂ y
        $assignedDepartures = $guideModel->getAssignedDepartures($guideId);
        
        $title = "Dashboard HÆ°á»›ng dáº«n viĂªn";
        $view = "guide/dashboard"; // View dĂ nh riĂªng cho HDV
        require_once PATH_VIEW . 'main.php'; 
    }
}

