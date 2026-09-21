<?php
class OperationLogController
{
    // TRONG DepartureController.php::addDepartureLog()

public function addDepartureLog()
{
    // Báº¯t buá»™c pháº£i xĂ¡c thá»±c quyá»n staff/admin
    if (!isset($_SESSION['user'])) { /* ... */ }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $logModel = new TourLogModel();
        
        $departureId = $_POST['departure_id'];
        $logContent = $_POST['log_content'];
        $logType = $_POST['log_type'] ?? 'note';
        $staffId = $_SESSION['user']['id']; // Láº¥y ID ngÆ°á»i Ä‘ang Ä‘Äƒng nháº­p

        $logModel->addLog($departureId, $staffId, $logContent, $logType);

        // Chuyá»ƒn hÆ°á»›ng vá» trang chi tiáº¿t chuyáº¿n Ä‘i
        header("Location: " . BASE_URL . "?action=departure-detail&id=" . $departureId);
        exit;
    }
}
}
