<?php
// File: controllers/DepartureResourceController.php

class DepartureResourceController
{
    // 1. Hiển thị danh sách Phân công (READ List)
    public function listResource()
    {
        $resourceModel = new DepartureResourceModel();
        $listResources = $resourceModel->getList();

        $title = "Quản lý Phân bổ Tài nguyên";
        $view = "admin/logistics/list-resource";
        require_once PATH_VIEW . 'main.php';
    }

    // 2. Thêm Phân công mới (CREATE)
    public function createResource()
    {
        // Khởi tạo Models cục bộ để lấy Master Data cho dropdowns
        $departureModel = new DepartureModel();
        $userModel = new UserModel();
        $hotelModel = new HotelModel();
        $transportModel = new TransportSupplierModel();

        // Lấy danh sách cần thiết cho form
        $listDepartures = $departureModel->getList();
        $listGuides = $userModel->getAllGuides();
        $listHotels = $hotelModel->getList();
        $listTransport = $transportModel->getList();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $title = "Phân bổ Tài nguyên & Chi phí";
            $view = "admin/logistics/create-resource";
            require_once PATH_VIEW . 'main.php';
        } else {
            // Xử lý POST submission - cho phép chọn nhiều tài nguyên cùng lúc
            $resourceModel = new DepartureResourceModel();

            $departure_id = isset($_POST['departure_id']) ? (int) $_POST['departure_id'] : null;
            $cost = isset($_POST['cost']) ? (float) $_POST['cost'] : 0;
            $details = $_POST['details'] ?? null;

            // Kiểm tra departure_id
            if (empty($departure_id)) {
                header("Location: " . BASE_URL . "?action=create-resource");
                exit;
            }

            // Xử lý từng loại tài nguyên nếu được chọn
            $guide_id = isset($_POST['guide_id']) && !empty($_POST['guide_id']) ? (int) $_POST['guide_id'] : null;
            $hotel_id = isset($_POST['hotel_id']) && !empty($_POST['hotel_id']) ? (int) $_POST['hotel_id'] : null;
            $transport_id = isset($_POST['transport_id']) && !empty($_POST['transport_id']) ? (int) $_POST['transport_id'] : null;

            // Chèn từng tài nguyên được chọn
            if ($guide_id) {
                $resourceModel->insert($departure_id, 'guide', $guide_id, $details, $cost);
            }
            if ($hotel_id) {
                $resourceModel->insert($departure_id, 'hotel', $hotel_id, $details, $cost);
            }
            if ($transport_id) {
                $resourceModel->insert($departure_id, 'transport', $transport_id, $details, $cost);
            }

            header("Location: " . BASE_URL . "?action=list-resource");
            exit;
        }
    }

    // 3. Cập nhật Phân công (UPDATE)
    public function updateResource()
    {
        $id = $_GET['id'];
        $resourceModel = new DepartureResourceModel();

        // Load Master Data (đã loại bỏ kiểm tra $resource tồn tại)
        $resource = $resourceModel->getOne($id);

        // Load Master Data cho form dropdowns
        $departureModel = new DepartureModel();
        $userModel = new UserModel();
        $hotelModel = new HotelModel();
        $transportModel = new TransportSupplierModel();
        $listDepartures = $departureModel->getList();
        $listGuides = $userModel->getAllGuides();
        $listHotels = (new HotelModel())->getList();
        $listTransport = (new TransportSupplierModel())->getList();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $title = "Cập nhật Phân bổ";
            $view = "admin/logistics/update-resource";
            require_once PATH_VIEW . 'main.php';
        } else {
            // Xử lý POST submission
            $departure_id = $_POST['departure_id'];
            $resource_type = $_POST['resource_type'];
            $cost = $_POST['cost'];

            $resource_id = null;
            $details = $_POST['details'];

            if ($resource_type === 'guide') {
                $resource_id = $_POST['guide_id'];
            } elseif ($resource_type === 'hotel') {
                $resource_id = $_POST['hotel_id'];
            } elseif ($resource_type === 'transport') {
                $resource_id = $_POST['transport_id'];
            }

            $resourceModel->update($id, $departure_id, $resource_type, $resource_id, $details, $cost);
            header("Location: " . BASE_URL . "?action=list-resource");
            exit;
        }
    }

    // 4. Xóa Phân công (DELETE - Tối giản)
    public function deleteResource()
    {
        $id = $_GET['id'];
        $resourceModel = new DepartureResourceModel();

        $resourceModel->delete($id);
        header("Location: " . BASE_URL . "?action=list-resource");
        exit;
    }
}
