<?php
// File: controllers/DepartureResourceController.php

class DepartureResourceController
{
    // 1. Hiá»ƒn thá»‹ danh sĂ¡ch PhĂ¢n cĂ´ng (READ List)
    public function listResource()
    {
        requireAdmin();
        $resourceModel = new DepartureResourceModel();
        $listResources = $resourceModel->getList();

        $title = "Quáº£n lĂ½ PhĂ¢n bá»• TĂ i nguyĂªn";
        $view = "admin/logistics/list-resource";
        require_once PATH_VIEW . 'main.php';
    }

    // 2. ThĂªm PhĂ¢n cĂ´ng má»›i (CREATE)
    public function createResource()
    {
        requireAdmin();
        // Khá»Ÿi táº¡o Models cá»¥c bá»™ Ä‘á»ƒ láº¥y Master Data cho dropdowns
        $departureModel = new DepartureModel();
        $userModel = new UserModel();
        $hotelModel = new HotelModel();
        $transportModel = new TransportSupplierModel();

        // Láº¥y danh sĂ¡ch cáº§n thiáº¿t cho form
        $listDepartures = $departureModel->getList();
        $listGuides = $userModel->getAllGuides();
        $listHotels = $hotelModel->getList();
        $listTransport = $transportModel->getList();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $title = "PhĂ¢n bá»• TĂ i nguyĂªn & Chi phĂ­";
            $view = "admin/logistics/create-resource";
            require_once PATH_VIEW . 'main.php';
        } else {
            // Xá»­ lĂ½ POST submission - cho phĂ©p chá»n nhiá»u tĂ i nguyĂªn cĂ¹ng lĂºc
            $resourceModel = new DepartureResourceModel();

            $departure_id = isset($_POST['departure_id']) ? (int) $_POST['departure_id'] : null;
            $cost = isset($_POST['cost']) ? (float) $_POST['cost'] : 0;
            $details = $_POST['details'] ?? null;

            // Kiá»ƒm tra departure_id
            if (empty($departure_id)) {
                header("Location: " . BASE_URL . "?action=create-resource");
                exit;
            }

            // Xá»­ lĂ½ tá»«ng loáº¡i tĂ i nguyĂªn náº¿u Ä‘Æ°á»£c chá»n
            $guide_id = isset($_POST['guide_id']) && !empty($_POST['guide_id']) ? (int) $_POST['guide_id'] : null;
            $hotel_id = isset($_POST['hotel_id']) && !empty($_POST['hotel_id']) ? (int) $_POST['hotel_id'] : null;
            $transport_id = isset($_POST['transport_id']) && !empty($_POST['transport_id']) ? (int) $_POST['transport_id'] : null;

            // ChĂ¨n tá»«ng tĂ i nguyĂªn Ä‘Æ°á»£c chá»n
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

    // 3. Cáº­p nháº­t PhĂ¢n cĂ´ng (UPDATE)
    public function updateResource()
    {
        requireAdmin();
        $id = $_GET['id'];
        $resourceModel = new DepartureResourceModel();

        // Load Master Data (Ä‘Ă£ loáº¡i bá» kiá»ƒm tra $resource tá»“n táº¡i)
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
            $title = "Cáº­p nháº­t PhĂ¢n bá»•";
            $view = "admin/logistics/update-resource";
            require_once PATH_VIEW . 'main.php';
        } else {
            // Xá»­ lĂ½ POST submission
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

    // 4. XĂ³a PhĂ¢n cĂ´ng (DELETE - Tá»‘i giáº£n)
    public function deleteResource()
    {
        requireAdmin();
        $id = $_GET['id'];
        $resourceModel = new DepartureResourceModel();

        $resourceModel->delete($id);
        header("Location: " . BASE_URL . "?action=list-resource");
        exit;
    }
}

