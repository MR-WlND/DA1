<?php
class TourController
{
    // Sử dụng public thay cho private để đơn giản hóa truy cập
    public $tourModel;
    public $categoryModel;
    public $destinationModel;
    public $policyModel;

    public function __construct()
    {
        // Khởi tạo tất cả các Model cần thiết
        $this->tourModel = new TourModel();
        $this->categoryModel = new CategoryModel();
        $this->destinationModel = new DestinationModel();
        $this->policyModel = new CancellationPolicyModel();
    }

    // 1. Hiển thị danh sách Tour (Read)
    public function listTour()
    {
        $listTours = $this->tourModel->getList();
        $title = "Quản lý Sản phẩm Tour";
        $view = "admin/tours/list-tour";
        require_once PATH_VIEW . 'main.php';
    }

    public function createTour()
    {
        $tourModel = $this->tourModel;
        $categoryModel = $this->categoryModel;
        $destinationModel = $this->destinationModel;
        $policyModel = $this->policyModel;

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $listCategories = $categoryModel->getList();
            $listDestinations = $destinationModel->getList();
            $listPolicies = $policyModel->getList();

            $title = "Thêm Tour mới";
            $view = "admin/tours/create-tour";
            require_once PATH_VIEW . 'main.php';
        } else {
            // 1. Xử lý Upload Ảnh Gallery (Lưu ý: Không cần xóa file cũ ở đây)
            $uploaded_images = [];
            if (!empty($_FILES['gallery_images']['name'][0])) {
                // Hàm helper phải xử lý mảng tệp và trả về mảng đường dẫn
                $uploaded_images = upload_multiple_files('tours_gallery', $_FILES['gallery_images']);
            }
            // 2. Chuẩn bị Dữ liệu chính và mảng phụ thuộc
            $data = $_POST;
            $destinations = $data['destinations'] ?? []; // Array Lộ trình N:M (order_number)
            $departures = $data['departures'] ?? [];     // Array Lịch khởi hành 1:N

            // 3. Xử lý các giá trị mặc định cho ENUMs và FK
            $data['tour_origin'] = $data['tour_origin'] ?? 'Catalog';
            $data['policy_id'] = $data['policy_id'] ?? null;
            $data['category_id'] = $data['category_id'] ?? null;

            try {
                $this->tourModel->insert(
                    $data,
                    $destinations,
                    $departures,
                    $uploaded_images
                );
                header('Location: ' . BASE_URL . '?action=list-tour');
                exit;
            } catch (Exception $e) {
                echo "Lỗi tạo Tour: " . $e->getMessage();
            }
        }
    }
    public function updateTour()
{
    $tour_id = $_GET['id'] ?? null;
    if (!$tour_id) {
        header('Location: ' . BASE_URL . '?action=list-tour');
        exit;
    }

    // Lấy dữ liệu cũ (tour + gallery + destinations + departures)
    $data = $this->tourModel->getOne($tour_id);
    if (!$data) {
        header('Location: ' . BASE_URL . '?action=list-tour');
        exit;
    }

    // Danh sách phụ trợ cho view
    $listCategories = $this->categoryModel->getList();
    $listDestinations = $this->destinationModel->getList();
    $listPolicies = $this->policyModel->getList();

    // Mặc định mảng nếu null
    $origDestinations = is_array($data['destinations'] ?? null) ? $data['destinations'] : [];
    $origDepartures = is_array($data['departures'] ?? null) ? $data['departures'] : [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Lấy mảng từ POST (nếu không tồn tại thì gán mảng rỗng)
        $postDest = $_POST['destinations'] ?? [];
        $postDep = $_POST['departures'] ?? [];

        // --- XỬ LÝ NÚT REMOVE (X) ---
        if (isset($_POST['remove_destination'])) {
            $idx = (int) $_POST['remove_destination'];
            if (isset($postDest[$idx])) {
                unset($postDest[$idx]);
                $postDest = array_values($postDest); // reindex
            }
            // giữ dữ liệu để render lại form
            $data = array_merge($data, $_POST);
            $data['destinations'] = $postDest;
            $data['departures'] = $postDep;
            $view = "admin/tours/update-tour";
            require_once PATH_VIEW . 'main.php';
            return;
        }

        if (isset($_POST['remove_departure'])) {
            $idx = (int) $_POST['remove_departure'];
            if (isset($postDep[$idx])) {
                unset($postDep[$idx]);
                $postDep = array_values($postDep);
            }
            $data = array_merge($data, $_POST);
            $data['destinations'] = $postDest;
            $data['departures'] = $postDep;
            $view = "admin/tours/update-tour";
            require_once PATH_VIEW . 'main.php';
            return;
        }

        // --- XỬ LÝ NÚT ADD (thêm dòng mới) ---
        if (isset($_POST['add_destination'])) {
            $postDest[] = ['destination_id' => '', 'order_number' => ''];
            $data = array_merge($data, $_POST);
            $data['destinations'] = $postDest;
            $data['departures'] = $postDep;
            $view = "admin/tours/update-tour";
            require_once PATH_VIEW . 'main.php';
            return;
        }

        if (isset($_POST['add_departure'])) {
            $postDep[] = ['start_date' => '', 'end_date' => '', 'current_price' => '', 'available_slots' => ''];
            $data = array_merge($data, $_POST);
            $data['destinations'] = $postDest;
            $data['departures'] = $postDep;
            $view = "admin/tours/update-tour";
            require_once PATH_VIEW . 'main.php';
            return;
        }

        // --- Nếu tới đây nghĩa là bấm "Cập nhật Tour" (lưu vào DB) ---
        // Chuẩn bị uploaded images
        $old_images = is_array($data['gallery'] ?? null) ? $data['gallery'] : [];
        $uploaded_images = [];

        if (!empty($_FILES['gallery_images']['name'][0])) {
            // Xóa file vật lý cũ (nếu bạn muốn xóa tất cả ảnh cũ khi upload ảnh mới)
            foreach ($old_images as $img) {
                $filePath = PATH_ASSETS_UPLOADS . 'tours_gallery/' . ($img['image_url'] ?? '');
                if (!empty($img['image_url']) && file_exists($filePath)) {
                    @unlink($filePath);
                }
            }
            // Upload mới (bạn có hàm helper upload_multiple_files)
            $uploaded_images = upload_multiple_files('tours_gallery', $_FILES['gallery_images']);
        } else {
            // Nếu không upload ảnh mới: giữ lại tên ảnh cũ nếu có input hidden gửi về
            if (!empty($_POST['gallery_images_old']) && is_array($_POST['gallery_images_old'])) {
                $uploaded_images = array_values($_POST['gallery_images_old']);
            } else {
                // fallback: dùng dữ liệu gốc từ DB (nếu có)
                $uploaded_images = is_array($old_images) ? array_column($old_images, 'image_url') : [];
            }
        }

        // Chuẩn bị data để update: lấy các trường cần thiết từ POST (hoặc gộp)
        $updateData = [
            'name' => $_POST['name'] ?? $data['name'] ?? '',
            'tour_type' => $_POST['tour_type'] ?? $data['tour_type'] ?? '',
            'description' => $_POST['description'] ?? $data['description'] ?? null,
            'base_price' => $_POST['base_price'] ?? $data['base_price'] ?? 0,
            'policy_id' => $_POST['policy_id'] ?? $data['policy_id'] ?? null,
            'category_id' => $_POST['category_id'] ?? $data['category_id'] ?? null,
            'tour_origin' => $_POST['tour_origin'] ?? $data['tour_origin'] ?? 'Catalog',
            // add other fields if needed
        ];

        // Destinations & departures lấy từ POST (đã xử lý ở trên)
        $destinations = $postDest;
        $departures = $postDep;

        try {
            $this->tourModel->update(
                $tour_id,
                $updateData,
                $destinations,
                $departures,
                $uploaded_images
            );
            header('Location:' . BASE_URL . '?action=list-tour');
            exit;
        } catch (Exception $e) {
            // Nếu lỗi, render lại view kèm thông báo lỗi
            $error = "Lỗi cập nhật: " . $e->getMessage();
            $data = array_merge($data, $_POST);
            $data['destinations'] = $destinations;
            $data['departures'] = $departures;
            $view = "admin/tours/update-tour";
            require_once PATH_VIEW . 'main.php';
            return;
        }
    }

    // GET request: render form với dữ liệu lấy từ DB
    $view = "admin/tours/update-tour";
    require_once PATH_VIEW . 'main.php';
}

    // Trong TourController.php

    public function detailTour()
    {
        $model = new TourModel();
        $tour = $model->getOne($_GET['id']);
        $view = "admin/tours/detail-tour";
        require_once PATH_VIEW . "main.php";
    }

    // 5. Xóa Tour (Delete)
    public function deleteTour()
{
    $id = $_GET['id'];
    $this->tourModel->delete($id); 
    header('Location:' . BASE_URL . '?action=list-tour');
    exit;
}
}
