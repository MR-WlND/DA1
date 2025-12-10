<?php
class GuideViewController
{
    public function schedule()
    {
        // Ensure user is logged in and is a guide
        if (empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'guide') {
            header('Location: ' . BASE_URL . '?action=login');
            exit;
        }

        $guideId = $_SESSION['user']['id'];
        $guideModel = new GuideModel();
        $assignments = $guideModel->getAssignedDepartures($guideId);

        // Compute simple stats
        $total = count($assignments);
        $upcoming = 0;
        $guestTotal = 0;
        $now = new DateTime();
        foreach ($assignments as $a) {
            $guestTotal += (int) ($a['total_booked_guests'] ?? 0);
            $start = isset($a['start_date']) ? new DateTime($a['start_date']) : null;
            if ($start && $start > $now) $upcoming++;
        }

        require_once PATH_VIEW . 'guide/schedule.php';
    }
    public function getTourLogs()
    {
        header('Content-Type: application/json');
        
        // Auth check
        if (empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'guide') {
            http_response_code(403);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        $departureId = $_GET['departure_id'] ?? null;
        if (!$departureId) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing departure_id']);
            exit;
        }

        $logModel = new TourLogModel();
        $logs = $logModel->getLogsByDepartureId($departureId);
        
        echo json_encode($logs);
        exit;
    }

    public function addTourLog()
    {
        header('Content-Type: application/json');

        // Auth check
        if (empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'guide') {
            http_response_code(403);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        // Get data from POST request
        $data = json_decode(file_get_contents('php://input'), true);
        $departureId = $data['departure_id'] ?? null;
        $content = $data['log_content'] ?? null;
        $staffId = $_SESSION['user']['id'];

        if (!$departureId || !$content || empty(trim($content))) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing or empty required fields']);
            exit;
        }

        $logModel = new TourLogModel();
        $result = $logModel->addLog($departureId, $staffId, $content, 'note');

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Log added successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to add log']);
        }
        exit;
    }
}
