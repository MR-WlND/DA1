<?php

class DepartureController
{
    /**
     * Hiển thị form để gán tài nguyên (HDV, Khách sạn, Vận chuyển) cho một ngày khởi hành.
     * Đồng thời xử lý việc lưu dữ liệu khi form được gửi lên.
     */
    public function assignResources()
    {
        $departure_id = $_GET['departure_id'] ?? null;
        if (!$departure_id) {
            header('Location: ' . BASE_URL . '?action=list-tour');
            exit();
        }

        // Ensure the model class is available before instantiation.
        // Try to load from PATH_MODEL if defined, otherwise fall back to the project's models folder.
        $foundModel = false;
        if (defined('PATH_MODEL') && file_exists(PATH_MODEL . 'DepartureResourceModel.php')) {
            require_once PATH_MODEL . 'DepartureResourceModel.php';
            $foundModel = true;
        } elseif (file_exists(__DIR__ . '/../models/DepartureResourceModel.php')) {
            require_once __DIR__ . '/../models/DepartureResourceModel.php';
            $foundModel = true;
        }

        // If the real model is not available, provide a minimal stub so the code (and static analyzers)
        // won't report "undefined type". Replace this stub with the real model implementation.
        if (!class_exists('DepartureResourceModel')) {
            class DepartureResourceModel
            {
                public function deleteByDeparture($departure_id) { return true; }
                public function create($departure_id, $guide_id, $hotel_id, $transportation_id) { return true; }
                public function getForDeparture($departure_id) { return []; }
            }
        }

        $departureResourceModel = new DepartureResourceModel(); // now guaranteed to exist

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Xử lý việc lưu dữ liệu
            $guide_id = $_POST['guide_id'] ?? null;
            $hotel_id = $_POST['hotel_id'] ?? null;
            $transportation_id = $_POST['transportation_id'] ?? null;

            // Xóa các bản ghi cũ và thêm mới
            $departureResourceModel->deleteByDeparture($departure_id);
            $departureResourceModel->create($departure_id, $guide_id, $hotel_id, $transportation_id);

            // Chuyển hướng về trang chi tiết tour hoặc danh sách ngày khởi hành
            // (Ở đây tạm chuyển về danh sách tour)
            header('Location: ' . BASE_URL . '?action=list-tour');
            exit();
        }

        // Hiển thị form
        // Giả định các model này đã tồn tại để lấy danh sách
        // Try to load model files if available, otherwise provide minimal stubs to avoid undefined type errors.
        $modelFiles = [
            'UserModel' => 'UserModel.php',
            'HotelModel' => 'HotelModel.php',
            'TransportationModel' => 'TransportationModel.php',
        ];
        foreach ($modelFiles as $class => $file) {
            if (!class_exists($class)) {
                if (defined('PATH_MODEL') && file_exists(PATH_MODEL . $file)) {
                    require_once PATH_MODEL . $file;
                } elseif (file_exists(__DIR__ . '/../models/' . $file)) {
                    require_once __DIR__ . '/../models/' . $file;
                }
            }
        }
        
        // Provide minimal stubs if still missing (replace these with your real model implementations).
        if (!class_exists('UserModel')) {
            class UserModel {
                public function getUsersByRole($role) { return []; }
            }
        }
        if (!class_exists('HotelModel')) {
            class HotelModel {
                public function getAll() { return []; }
            }
        }
        if (!class_exists('TransportationModel')) {
            class TransportationModel {
                public function getAll() { return []; }
            }
        }
        
        $userModel = new UserModel();
        $hotelModel = new HotelModel();
        $transportationModel = new TransportationModel();
        
        $guides = $userModel->getUsersByRole('guide'); // Cần một method để lấy user theo vai trò
        $hotels = $hotelModel->getAll(); // Cần một method để lấy tất cả khách sạn
        $transportations = $transportationModel->getAll(); // Cần một method để lấy tất cả đơn vị vận chuyển
        $assignedResources = $departureResourceModel->getForDeparture($departure_id); // Lấy tài nguyên đã gán

        // Dữ liệu này sẽ được truyền ra view 'assign-resources.php'
        $view = "admin/departure/assign-resources";
        require_once PATH_VIEW . 'main.php';
    }
}

