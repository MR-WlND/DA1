<?php
class GuideViewController
{
    // ================================
    // 1. Danh sách HDV
    // ================================
    public function listGuide()
    {
        $guideModel = new GuideModel();
        $listGuide = $guideModel->getListWithProfile();

        $view = "admin/hdv/list-guide";
        require_once PATH_VIEW . 'main.php';
    }

    // ================================
    // 2. Tạo mới HDV (ĐÃ FIX LỖI DATE & EMAIL)
    // ================================
    public function createGuide()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Upload ảnh
            $photoUrl = null;
            if (!empty($_FILES['photo_url']['name'])) {
                $avatarDir = 'uploads/guide/';
                if (!is_dir($avatarDir)) mkdir($avatarDir, 0777, true);

                $photoUrl = $avatarDir . time() . '_' . basename($_FILES['photo_url']['name']);
                move_uploaded_file($_FILES['photo_url']['tmp_name'], $photoUrl);
            }

            $guideModel = new GuideModel();

            try {
                // Insert User
                $user_id = $guideModel->insert(
                    $_POST['name'] ?? '',
                    $_POST['email'] ?? '',
                    $_POST['password'] ?? '',
                    $_POST['phone'] ?? ''
                );

                // --- XỬ LÝ NGÀY SINH (QUAN TRỌNG) ---
                // Nếu không nhập thì gán NULL, không để chuỗi rỗng
                $dob = !empty($_POST['date_of_birth']) ? $_POST['date_of_birth'] : null;

                // Insert Profile
                $guideModel->insertProfile([
                    'user_id' => $user_id,
                    'category' => $_POST['category'] ?? 'domestic',
                    'specialty_route' => $_POST['specialty_route'] ?? null,
                    'specialty_group' => $_POST['specialty_group'] ?? 'standard',
                    'certification' => $_POST['certification'] ?? null,
                    'health_status' => $_POST['health_status'] ?? null,
                    'notes' => $_POST['notes'] ?? null,
                    'date_of_birth' => $dob, // <-- Đã sửa
                    'photo_url' => $photoUrl,
                    'experience_years' => $_POST['experience_years'] ?? 0,
                    'languages' => $_POST['languages'] ?? null
                ]);

                header('Location:' . BASE_URL . '?action=list-guide');
                exit();

            } catch (PDOException $e) {
                if ($e->getCode() == '23000' || strpos($e->getMessage(), 'Duplicate entry') !== false) {
                    $error_message = "Email '" . htmlspecialchars($_POST['email']) . "' đã tồn tại!";
                    echo "<script>alert('$error_message'); window.history.back();</script>";
                    exit(); 
                } else {
                    echo "Lỗi hệ thống: " . $e->getMessage();
                    exit();
                }
            }
        }

        $view = "admin/hdv/create-guide";
        require_once PATH_VIEW . 'main.php';
    }

    // ================================
    // 3. Cập nhật HDV (ĐÃ FIX LỖI DATE)
    // ================================
    public function updateGuide()
    {
        $guideModel = new GuideModel();
        $guide = $guideModel->getOneWithProfile($_GET['id']);

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $view = "admin/hdv/update-guide";
            require_once PATH_VIEW . 'main.php';
            return;
        }

        // Upload ảnh mới
        $photoUrl = $guide['photo_url'];
        if (!empty($_FILES['photo_url']['name'])) {
            $avatarDir = 'uploads/guide/';
            if (!is_dir($avatarDir)) mkdir($avatarDir, 0777, true);

            $photoUrl = $avatarDir . time() . '_' . basename($_FILES['photo_url']['name']);
            move_uploaded_file($_FILES['photo_url']['tmp_name'], $photoUrl);
        }

        try {
            // Update User
            $guideModel->update(
                $_GET['id'],
                $_POST['name'],
                $_POST['email'],
                $_POST['password'],
                $_POST['phone']
            );
    
            // --- XỬ LÝ NGÀY SINH CHO UPDATE ---
            $dob = !empty($_POST['date_of_birth']) ? $_POST['date_of_birth'] : null;

            // Update Profile
            $guideModel->updateProfile($_GET['id'], [
                'category' => $_POST['category'],
                'specialty_route' => $_POST['specialty_route'],
                'specialty_group' => $_POST['specialty_group'],
                'certification' => $_POST['certification'],
                'health_status' => $_POST['health_status'],
                'notes' => $_POST['notes'],
                'date_of_birth' => $dob, // <-- Đã sửa
                'photo_url' => $photoUrl,
                'experience_years' => $_POST['experience_years'],
                'languages' => $_POST['languages']
            ]);
    
            header('Location:' . BASE_URL . '?action=list-guide');
            exit();

        } catch (PDOException $e) {
            if ($e->getCode() == '23000' || strpos($e->getMessage(), 'Duplicate entry') !== false) {
                echo "<script>alert('Email này đã được sử dụng!'); window.history.back();</script>";
                exit();
            } else {
                echo "Lỗi: " . $e->getMessage();
                exit();
            }
        }
    }

    // ================================
    // 4. Chi tiết HDV
    // ================================
    public function detailGuide()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location:' . BASE_URL . '?action=list-guide');
            exit();
        }

        $guideModel = new GuideModel();
        $guide = $guideModel->getOneWithProfile($id);

        if (empty($guide)) {
            header('Location:' . BASE_URL . '?action=list-guide');
            exit();
        }

        $view = "admin/hdv/detail-guide";
        require_once PATH_VIEW . 'main.php';
    }

    // ================================
    // 5. Xóa HDV
    // ================================
    public function deleteGuide()
    {
        $guideModel = new GuideModel();
        $guideModel->delete($_GET['id']);

        header('Location:' . BASE_URL . '?action=list-guide');
        exit();
    }
}
?>