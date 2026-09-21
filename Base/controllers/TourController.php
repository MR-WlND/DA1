<?php
class TourController
{
    public $tourModel;
    public $categoryModel;
    public $destinationModel;
    public $customRequestModel;
    public function __construct()
    {
        // Khởi tạo tất cả các Model cần thiết
        $this->tourModel = new TourModel();
        $this->categoryModel = new CategoryModel();
        $this->destinationModel = new DestinationModel();
        $this->customRequestModel = new CustomTourRequestModel();
    }

    // 1. Hiển thị danh sách Tour (Read)
    public function listTour()
    {
        requireAdmin();
        $listTours = $this->tourModel->getList();
        $title = "Quản lý Sản phẩm Tour";
        $view = "admin/tours/list-tour";
        require_once PATH_VIEW . 'main.php';
    }

    // Trong TourController.php

    public function createTour()
    {
        requireAdmin();
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
        requireAdmin();
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

        // GET REQUEST (Render form khi không phải POST)
        $view = "admin/tours/update-tour";
        require_once PATH_VIEW . 'main.php';
    }

    public function detailTour()
    {
        requireAdmin();
        $model = new TourModel();
        $tour = $model->getOne($_GET['id']);
        $view = "admin/tours/detail-tour";
        require_once PATH_VIEW . "main.php";
    }

    // 5. Xóa Tour (Delete)
    public function deleteTour()
    {
        requireAdmin();
        $id = $_GET['id'];
        $this->tourModel->delete($id);
        header('Location: ' . BASE_URL . '?action=list-tour');
        exit;
    }
    public function requestTour()
{
    requireCustomer();
    $model = $this->customRequestModel;
    $message = null;
    $postData = []; // Khởi tạo để giữ dữ liệu dính (sticky data)

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postData = $_POST;
        
        // 1. Kiểm tra Dữ liệu Bắt buộc
        if (empty($postData['customer_name']) || empty($postData['customer_phone']) || empty($postData['num_people'])) {
            $message = "Vui lòng điền đầy đủ Tên, Số điện thoại và Số lượng người.";
        } else {
            try {
                $isSuccess = $model->insertRequest($postData);

                if ($isSuccess) {
                    $message = "Yêu cầu của bạn đã được gửi thành công! Chúng tôi sẽ liên hệ sớm nhất.";
                    // Xóa dữ liệu POST sau khi thành công để làm sạch form
                    $postData = []; 
                } else {
                    throw new Exception("Lỗi không xác định khi lưu yêu cầu.");
                }
            } catch (Exception $e) {
                // Lỗi SQL hoặc hệ thống
                $message = "Lỗi hệ thống: " . $e->getMessage();
            }
        }
    }
    
    // Gửi dữ liệu POST (hoặc rỗng) trở lại View để giữ form dính
    $data = $postData; 

    $title = "Đặt Tour Theo Yêu Cầu";
    $view = "guide/request-tour"; 
    require_once PATH_VIEW . 'main.php';
}
public function listCustomRequests()
{
    requireAdmin();
    // Sử dụng Model đã khởi tạo
    $listRequests = $this->customRequestModel->getListRequests();

    $title = "Quản lý Yêu cầu Tour Tùy chỉnh";
    $view = "admin/requests/list-requests"; // <<< View cần tạo ở bước sau
    require_once PATH_VIEW . 'main.php';
}
public function submitQuote()
{
    requireAdmin();
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . BASE_URL . '?action=list-requests');
        exit;
    }
    
   $data = $_POST;
    // Đảm bảo bạn lấy được ID của Admin (Nếu không có session, sẽ dùng ID mặc định, ví dụ 1)
    $staffId = $_SESSION['user']['id'] ?? 1; 

    try {
       if ($this->customRequestModel->insertQuote($data, $staffId)) {
            // Tùy chọn: Chuyển trạng thái yêu cầu sang 'Quoting'
            $this->customRequestModel->updateRequestStatus($data['request_id'], 'Quoting');
            // Tùy chọn: set_message("Báo giá đã được gửi thành công!", 'success');
        }
    } catch (Exception $e) {
        // Tùy chọn: set_message("Lỗi gửi báo giá: " . $e->getMessage(), 'error');
    }

    // Quay lại trang chi tiết yêu cầu
    header('Location: ' . BASE_URL . '?action=view-request&id=' . $data['request_id']);
    exit;
}

/**
 * Xử lý việc cập nhật trạng thái yêu cầu từ Admin
 */
public function updateRequestStatus()
{
    requireAdmin();
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['request_id']) || empty($_POST['status'])) {
        header('Location: ' . BASE_URL . '?action=list-requests');
        exit;
    }
    
    $requestId = $_POST['request_id'];
    $status = $_POST['status'];

    try {
        $this->customRequestModel->updateRequestStatus($requestId, $status);
    } catch (Exception $e) {
        // Xử lý lỗi
    }
    // Quay lại trang chi tiết yêu cầu
    header('Location: ' . BASE_URL . '?action=view-request&id=' . $requestId);
    exit;
}
// TRONG TourController.php
// TRONG TourController.php

public function viewCustomRequest()
{
    requireAdmin();
    $requestId = $_GET['id'] ?? null;
    
    // Cần đảm bảo $this->customRequestModel đã được khởi tạo
    $request = $this->customRequestModel->getRequestDetail($requestId);

    if (!$request) {
        header('Location: ' . BASE_URL . '?action=list-requests');
        exit;
    }

    $title = "Chi tiết Yêu cầu #" . $requestId;
    $view = "admin/requests/view-request-detail"; 
    require_once PATH_VIEW . 'main.php';
}
// TRONG TourController.php

/**
 * Hiển thị danh sách yêu cầu và báo giá cho người dùng đã đăng nhập
 */
// TRONG TourController.php::viewMyQuotes()

public function viewMyQuotes()
{
    requireCustomer();

    $userId = $_SESSION['user']['id'];
    
    // 🟢 DÒNG ĐÃ ĐƯỢC ĐƠN GIẢN HÓA: Chỉ cần lấy danh sách thô (flat list)
    $quotesData = $this->customRequestModel->getRequestsAndQuotesByUserId($userId);
    
    // KHÔNG CẦN VÒNG LẶP FOREACH PHỨC TẠP NỮA!

    $data = ['quotesData' => $quotesData]; // Đổi tên biến để rõ ràng hơn
    $title = "Báo giá của tôi";
    $view = "guide/my-quotes-simple"; // Tạo View mới cho phiên bản đơn giản
    require_once PATH_VIEW . 'main.php';
}

    // ---------------------------------------------------
    // CỔNG THÔNG TIN KHÁCH HÀNG (PUBLIC / CUSTOMER PORTAL)
    // ---------------------------------------------------

    public function publicTours()
    {
        // Lấy danh sách tất cả các tour (thêm logic WHERE active nếu cần)
        $listTours = $this->tourModel->getList();
        
        // Lấy filter nếu có
        $categoryId = $_GET['category_id'] ?? null;
        if ($categoryId) {
            $filtered = [];
            foreach ($listTours as $t) {
                if ($t['category_id'] == $categoryId) {
                    $filtered[] = $t;
                }
            }
            $listTours = $filtered;
        }

        $listCategories = $this->categoryModel->getList();

        $title = "Danh sách Tour Mới Nhất";
        $view = "tours/public-list";
        require_once PATH_VIEW . 'main.php';
    }

    public function publicDetailTour()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . '?action=public-tours');
            exit;
        }

        $tour = $this->tourModel->getOne($id);
        if (!$tour) {
            header('Location: ' . BASE_URL . '?action=public-tours');
            exit;
        }

        // Lấy lịch khởi hành tương lai cho tour này
        $departureModel = new DepartureModel();
        // Lấy tất cả lịch khởi hành và lọc
        $allDepartures = $departureModel->getList();
        $tourDepartures = [];
        $now = date('Y-m-d');
        foreach ($allDepartures as $dep) {
            if ($dep['tour_id'] == $id && $dep['start_date'] >= $now && $dep['available_slots'] > 0) {
                $tourDepartures[] = $dep;
            }
        }

        $title = $tour['name'];
        $view = "tours/public-detail";
        require_once PATH_VIEW . 'main.php';
    }
}
