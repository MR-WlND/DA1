<?php
class OperationLogController
{
    // TRONG DepartureController.php::addDepartureLog()

public function addDepartureLog()
{
    // Bắt buộc phải xác thực quyền staff/admin
    if (!isset($_SESSION['user'])) { /* ... */ }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $logModel = new TourLogModel();
        
        $departureId = $_POST['departure_id'];
        $logContent = $_POST['log_content'];
        $logType = $_POST['log_type'] ?? 'note';
        $staffId = $_SESSION['user']['id']; // Lấy ID người đang đăng nhập

        $logModel->addLog($departureId, $staffId, $logContent, $logType);

        // Chuyển hướng về trang chi tiết chuyến đi
        header("Location: " . BASE_URL . "?action=departure-detail&id=" . $departureId);
        exit;
    }
}
}