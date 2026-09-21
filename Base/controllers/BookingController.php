<?php
class BookingController
{
    protected $bookingModel;
    public function __construct() 
    {
        // Khởi tạo Model để sử dụng lại
        $this->bookingModel = new BookingModel();
    }
    public function listBooking()
    {
        requireAdmin();
        $listBookings = $this->bookingModel->getList();

        $title = "Quản lý Đơn đặt Tour";
        $view = "admin/booking/list-booking";
        require_once PATH_VIEW . 'main.php';
    }
    public function createBooking()
    {
        requireAdmin();
        // Khởi tạo các Model phụ thuộc nếu cần (Chỉ khởi tạo nếu không có trong __construct)
        $userModel = new UserModel();
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Khởi tạo tạm thời các Model chỉ dùng trong GET
            $listDepartures = (new DepartureModel())->getList(); 
            $listUsers = $userModel->getList();

            $title = "Thêm Đơn đặt Tour";
            $view = "admin/booking/create-booking";
            require_once PATH_VIEW . 'main.php';
        } else {
            $departureId = $_POST['departure_id'];
            $customerDetails = $_POST['customer_details'] ?? [];
            $numCustomers = count($customerDetails);

            // Validate available slots
            $departureModel = new DepartureModel();
            $departure = $departureModel->getOne($departureId);
            $availableSlots = $departure['available_slots'] ?? 0;

            if ($numCustomers > $availableSlots) {
                $_SESSION['error'] = "Số lượng khách đặt ({$numCustomers}) vượt quá số chỗ còn lại ({$availableSlots}).";
                // Save form data to session to repopulate
                $_SESSION['form_data'] = $_POST;
                header('Location: ' . BASE_URL . '?action=create-booking' . (isset($_GET['id']) ? '&id=' . $_GET['id'] : '') . (isset($_GET['dep_id']) ? '&dep_id=' . $_GET['dep_id'] : ''));
                exit;
            }

            $dataBooking = [
                'user_id'      => $_POST['user_id'],
                'departure_id' => $departureId,
                'total_price'  => $_POST['total_price'],
            ];

            $this->bookingModel->insertBooking($dataBooking, $customerDetails);
            
            // Clear form data on success
            unset($_SESSION['form_data']);
            $_SESSION['success'] = "Tạo đơn đặt tour thành công!";
            header('Location: ' . BASE_URL . '?action=list-booking');
            exit;
        }
    }

    public function updateBooking()
    {
        requireAdmin();
        $id = $_GET['id'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data = $this->bookingModel->getOne($id); 

            // Khởi tạo tạm thời các Model phụ thuộc
            $listDepartures = (new DepartureModel())->getList();
            $listUsers = (new UserModel())->getList();

            $title = "Cập nhật Đơn đặt Tour";
            $view = "admin/booking/update-booking";
            require_once PATH_VIEW . 'main.php';
        } else {
            // Lấy dữ liệu và gọi Model update
            $total_price = $_POST['total_price'];
            // $status = $_POST['status']; // Nếu không cần thiết thì loại bỏ

            $this->bookingModel->update($id, $total_price); 

            header('Location:' . BASE_URL . '?action=list-booking');
            exit;
        }
    }
    public function deleteBooking()
    {
        requireAdmin();
        $id = $_GET['id'];
        $this->bookingModel->delete($id);

        header('Location:' . BASE_URL . '?action=list-booking');
        exit;
    }

    public function detailBooking()
    {
        requireAdmin();
        $id = $_GET['id'];
        
        // 🟢 SỬA LỖI: Dùng hàm find() đã tối ưu trong Model thay vì getOne() cũ
        $booking = $this->bookingModel->find($id);

        if (!$booking) {
            header('Location: ' . BASE_URL . '?action=list-booking');
            exit;
        }

        // Truyền biến $booking tới View
        $data['booking'] = $booking; 
        
        $title = "Chi tiết Đơn đặt Tour";
        $view = "admin/booking/detail-booking";
        
        require_once PATH_VIEW . 'main.php';
    }


    public function checkoutSimple()
    {
        requireCustomer();
        $bookingId = $_GET['id'] ?? null;
        
        // 🟢 Dùng hàm find() đã tối ưu trong Model
        $booking = $this->bookingModel->find($bookingId); 
        if (!$booking) {
            header('Location: ' . BASE_URL . '?action=my-bookings');
            exit;
        }
        $customerPhone = $booking['customer_phone'] ?? 'Liên hệ CSKH'; 

        $data = [
            'booking' => $booking,
            'customerPhone' => $customerPhone
        ];
        
        $title = "Thông tin Chuyển khoản";
        $view = "guide/bank-transfer-info";
        require_once PATH_VIEW . 'main.php';
    }

    // Đánh dấu đơn đã thanh toán
    public function markAsPaid()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['booking_id']) || !isset($_POST['transaction_id'])) {
            header("Location: " . BASE_URL . "?action=admin-dashboard");
            exit;
        }
        $bookingId = intval($_POST['booking_id']);
        $transactionId = trim($_POST['transaction_id']);

        if ($bookingId <= 0 || $transactionId === "") {
            header("Location: " . BASE_URL . "?action=list-booking");
            exit;
        }

        // 🟢 SỬA LỖI: Dùng $this->bookingModel để gọi hàm cập nhật thanh toán
        $updated = $this->bookingModel->updatePaymentStatus($bookingId, 'Paid', $transactionId);

        if ($updated) {
            // Tự động ghi nhận giao dịch doanh thu (Revenue)
            $booking = $this->bookingModel->find($bookingId);
            if ($booking) {
                $financeModel = new FinanceModel();
                $financeModel->insert([
                    'departure_id' => $booking['departure_id'],
                    'transaction_type' => 'Revenue',
                    'amount' => $booking['total_price'],
                    'description' => "Thanh toán cho Booking #" . $bookingId . " (GD: " . $transactionId . ")",
                    'transaction_date' => date('Y-m-d')
                ]);
            }
        }
        
        header("Location: " . BASE_URL . "?action=detail-booking&id=" . $bookingId);
        exit;
    }

    public function myBookings()
    {
        requireCustomer();

        $userId = $_SESSION['user']['id'];
        
        // Cần phương thức getBookingsByUserId trong BookingModel
        $sql = "SELECT b.*, t.name AS tour_name, td.start_date 
                FROM bookings b
                JOIN tour_departures td ON b.departure_id = td.id
                JOIN tours t ON td.tour_id = t.id
                WHERE b.user_id = :user_id
                ORDER BY b.booking_date DESC";
        $stmt = clone $this->bookingModel->db; // Tránh reference issue
        $stmt = clone $this->bookingModel->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        $listBookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $title = "Đơn hàng của tôi";
        $view = "user/my-bookings"; // Khách hàng xem lịch sử
        require_once PATH_VIEW . 'main.php';
    }
    
}