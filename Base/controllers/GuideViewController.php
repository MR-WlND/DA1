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
}
