<?php
class TourController
{
    // Sử dụng public thay cho private để đơn giản hóa truy cập
    public $tourModel;
    public $categoryModel;
    public $destinationModel;


    public function __construct()
    {
        // Khởi tạo tất cả các Model cần thiết
        $this->tourModel = new TourModel();
        $this->categoryModel = new CategoryModel();
        $this->destinationModel = new DestinationModel();
    }

    // 1. Hiển thị danh sách Tour (Read)
    public function listTour()
    {
        $listTours = $this->tourModel->getList();
        $title = "Quản lý Sản phẩm Tour";
        $view = "admin/tours/list-tour";
        require_once PATH_VIEW . 'main.php';
    }

    // Trong TourController.php

    public function createTour()
    {
        // Loại bỏ khai báo biến cục bộ thừa, sử dụng trực tiếp $this->Model
        $tourModel = $this->tourModel;
        $categoryModel = $this->categoryModel;
        $destinationModel = $this->destinationModel;

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // TẢI FORM: Lấy dữ liệu nền tảng
            $listCategories = $categoryModel->getList();
            $listDestinations = $destinationModel->getList();
            

            $title = "Thêm Tour mới";
            $view = "admin/tours/create-tour";
            require_once PATH_VIEW . 'main.php';
        } else {
            // --- XỬ LÝ POST: CHUẨN BỊ VÀ GỌI MODEL ---

            // 1. Xử lý Upload Ảnh Gallery
            $uploaded_images = [];
            if (!empty($_FILES['gallery_images']['name'][0])) {
                $uploaded_images = upload_multiple_files('tours_gallery', $_FILES['gallery_images']);
            }

            // 2. Chuẩn bị Dữ liệu chính và các mảng phụ thuộc
            $data = $_POST;
            $destinations = $data['destinations'] ?? [];
            $departures = $data['departures'] ?? [];
            $itineraryDetails = $data['itinerary_details'] ?? []; // <<< THU THẬP MẢNG MỚI

            // 3. Xử lý các giá trị mặc định cho ENUMs
            $data['tour_origin'] = $data['tour_origin'] ?? 'Catalog';
            $data['policy_id'] = $data['policy_id'] ?? null;
            $data['category_id'] = $data['category_id'] ?? null;

            try {
                $tourModel->insert(
                    $data,
                    $destinations,
                    $departures,
                    $uploaded_images,
                    $itineraryDetails // <<< TRUYỀN THAM SỐ CUỐI CÙNG
                );

                // THÀNH CÔNG
                header('Location: ' . BASE_URL . '?action=list-tour');
                exit;
            } catch (Exception $e) {
                // 4. XỬ LÝ LỖI NGHIÊM TRỌNG (Transaction Rollback)

                // Xóa các tệp vật lý vừa upload (vì DB đã Rollback)
                if (!empty($uploaded_images)) {
                    // Giả định hàm helper delete_files_by_path đã được định nghĩa
                    // (Chức năng này cần được xử lý cẩn thận trong môi trường không dùng Transaction)
                    // delete_uploaded_files($uploaded_images); 
                }

                echo "Lỗi tạo Tour: " . $e->getMessage();
            }
        }
    }

    // Trong TourController.php

    public function updateTour()
    {
        // 1. Kiểm tra ID và Lấy Dữ liệu cũ
        $tour_id = $_GET['id'] ?? null;
        if (!$tour_id || !is_numeric($tour_id)) {
            header('Location: ' . BASE_URL . '?action=list-tour');
            exit;
        }

        $tourModel = $this->tourModel;

        // Lấy dữ liệu cũ từ DB (Dùng cho cả View và Xóa file)
        $data = $tourModel->getOne($tour_id);
        if (!$data) {
            header('Location: ' . BASE_URL . '?action=list-tour');
            exit;
        }

        // Load static lists (cần cho form)
        $listCategories = $this->categoryModel->getList();
        $listDestinations = $this->destinationModel->getList();
        

        // ------------------------------------------------------------------
        // PHẦN 1: TẢI FORM & XỬ LÝ THAO TÁC (GET / POST Modify)
        // ------------------------------------------------------------------

        $postData = $_POST;
        $origGallery = $data['gallery'] ?? [];

        // Lấy các mảng phức tạp từ POST
        $postDest = $postData['destinations'] ?? [];
        $postDep = $postData['departures'] ?? [];
        $postItinerary = $postData['itinerary_details'] ?? [];

        // --- KIỂM TRA ACTION (ADD/REMOVE) ---
        // Nếu bất kỳ nút ADD/REMOVE nào được bấm, render lại form và DỪNG THỰC THI DB
        if (
            isset($postData['remove_destination']) || isset($postData['add_destination']) ||
            isset($postData['remove_departure']) || isset($postData['add_departure']) ||
            isset($postData['remove_itinerary_item']) || isset($postData['add_itinerary_item'])
        ) {

            // Hợp nhất dữ liệu POST (đã xử lý) vào $data để render lại View (Sticky Form)
            $data = array_merge($data, $postData);
            $data['destinations'] = $postDest;
            $data['departures'] = $postDep;
            $data['itinerary_details'] = $postItinerary;

            $view = "admin/tours/update-tour";
            require_once PATH_VIEW . 'main.php';
            return; // DỪNG LẠI sau khi render lại form
        }

        // ------------------------------------------------------------------
        // PHẦN 2: FINAL SUBMISSION (LƯU VÀO DB)
        // ------------------------------------------------------------------

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // A. XỬ LÝ ẢNH GALLERY VÀ FILE CLEANUP
            $uploaded_images = [];
            if (!empty($_FILES['gallery_images']['name'][0])) {
                // Xóa tệp vật lý cũ và Upload mới
                foreach ($origGallery as $img) {
                    $filePath = PATH_ASSETS_UPLOADS . 'tours_gallery/' . ($img['image_url'] ?? '');
                    if (!empty($img['image_url']) && file_exists($filePath)) {
                        @unlink($filePath);
                    }
                }
                $uploaded_images = upload_multiple_files('tours_gallery', $_FILES['gallery_images']);
            } else {
                // Giữ lại đường dẫn ảnh cũ từ DB/Form (Nếu không upload mới)
                $uploaded_images = $_POST['gallery_images_old'] ?? array_column($origGallery, 'image_url');
            }

            // B. CHUẨN BỊ DATA CHÍNH VÀ GỌI MODEL
            $updateData = [
                'name' => $_POST['name'] ?? $data['name'] ?? '',
                'tour_type' => $_POST['tour_type'] ?? $data['tour_type'] ?? '',
                'description' => $_POST['description'] ?? $data['description'] ?? null,
                'base_price' => $_POST['base_price'] ?? $data['base_price'] ?? 0,

                // SỬA LỖI: Kiểm tra an toàn cho các FK
                'cancellation_policy_text' => $_POST['cancellation_policy_text'] ?? $data['cancellation_policy_text'] ?? null,
                'category_id' => $_POST['category_id'] ?? $data['category_id'] ?? null,

                'tour_origin' => $_POST['tour_origin'] ?? $data['tour_origin'] ?? 'Catalog',
            ];

            try {
                $this->tourModel->update(
                    $tour_id, // 1. ID
                    $updateData, // 2. Mảng Data chính (chứa name, base_price, v.v.)
                    $postDest, // 3. Destinations
                    $postDep,  // 4. Departures
                    $uploaded_images, // 5. Images
                    $postItinerary, // 6. Itinerary Details
                    // ... Cần đảm bảo tất cả tham số được truyền đúng vị trí và số lượng
                );
                header('Location:' . BASE_URL . '?action=list-tour');
                exit;
            } catch (Exception $e) {
                // D. XỬ LÝ LỖI (Sticky Form Logic)
                $error = "Lỗi cập nhật: " . $e->getMessage();

                // Hợp nhất dữ liệu POST vào $data để form không bị mất input khi tải lại
                $data = array_merge($data, $postData);
                $data['destinations'] = $postDest;
                $data['departures'] = $postDep;
                $data['itinerary_details'] = $postItinerary;

                $view = "admin/tours/update-tour";
                require_once PATH_VIEW . 'main.php';
                return;
            }
        }

        // PHẦN 3: GET REQUEST (Render form khi không phải POST)
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
        header('Location: ' . BASE_URL . '?action=list-tour');
        exit;
    }
}
