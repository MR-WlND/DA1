<?php
class DepartureController
{
    public function listDeparture()
    {
        $departure = new DepartureModel();
        $listDeparture = $departure->getList();
        $title = "list";
        $view = "admin/departure/list-departure";
        require_once PATH_VIEW . 'main.php';
    }

    public function createDeparture()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $tourModel = new TourModel(); // hoặc TourModel tùy bạn đặt tên
            $listTours = $tourModel->getList(); // Lấy tất cả tour
            $title = "create";
            $view = "admin/departure/create-departure";
            require_once PATH_VIEW . 'main.php';
        } else {
            $departure = new DepartureModel();
            $departure->insert(
                $_POST['tour_id'],
                $_POST['start_date'],
                $_POST['end_date'],
                $_POST['current_price'],
                $_POST['available_slots']
            );
            header('Location:' . BASE_URL . '?action=list-departure');
        }
    }

    public function updateDeparture()
    {
        $departure = new DepartureModel();
        $data = $departure->getOne($_GET['id']); // Lấy dữ liệu hiện tại
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $tour = new TourModel();
            $listTour = $tour->getList();
            $title = "update";
            $view = "admin/departure/update-departure";
            require_once PATH_VIEW . 'main.php';
        } else {
            $departure->update(
                $_GET['id'],
                $_POST['tour_id'],
                $_POST['start_date'],
                $_POST['end_date'],
                $_POST['current_price'],
                $_POST['available_slots']
            );
            header('Location:' . BASE_URL . '?action=list-departure');
        }
    }

    public function deleteDeparture()
    {
        $departureModel = new DepartureModel();
        $id = $_GET['id'];

        // Kiểm tra xem có booking nào liên quan không
        if ($departureModel->hasBookings($id)) {
            // Nếu có, báo lỗi và không cho xóa
            $errorMessage = "Không thể xóa lịch khởi hành này vì đã có booking tồn tại.";
            header('Location:' . BASE_URL . '?action=list-departure&error=' . urlencode($errorMessage));
        } else {
            // Nếu không, tiến hành xóa
            $departureModel->delete($id);
            header('Location:' . BASE_URL . '?action=list-departure&success=1');
        }
        exit;
    }
    public function departureDetail()
{
    // BẢO VỆ TRANG (chỉ Admin/Staff mới được xem chi tiết)
    if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? 'user') !== 'admin') { 
        header('Location: ' . BASE_URL . '?action=homepage');
        exit;
    }
    
    $departureId = $_GET['id'] ?? null;

    if (!$departureId) {
        header('Location: ' . BASE_URL . '?action=list-departures');
        exit;
    }
    
    // Khởi tạo các Model cần thiết
    $departureModel = new DepartureModel(); // Giả định Model này tồn tại
    $tourLogModel = new TourLogModel();
    
    // 1. Lấy chi tiết chuyến đi
    $departure = $departureModel->getOne($departureId); 
    
    if (!$departure) {
        header('Location: ' . BASE_URL . '?action=list-departures');
        exit;
    }

    // 2. 🟢 LẤY LỊCH SỬ LOG HOẠT ĐỘNG
    $departureLogs = $tourLogModel->getLogsByDepartureId($departureId);
    
    // 3. Truyền dữ liệu sang View
    $data = [
        'departure' => $departure,
        'departureLogs' => $departureLogs, // 🟢 Truyền log đi
        // ... (Thêm list bookings, customers nếu cần)
    ];

    $title = "Chi tiết Chuyến đi";
    $view = "admin/departure/departure-detail"; // Đảm bảo đường dẫn View này chính xác
    require_once PATH_VIEW . 'main.php';
}
}
