<?php

class TourLogController
{
    /**
     * Hiển thị danh sách sự cố của một tour và form để thêm mới.
     */
    public function listAndCreate()
    {
        $tour_id = $_GET['tour_id'] ?? null;
        if (!$tour_id) {
            header('Location: ' . BASE_URL . '?action=list-tour');
            exit();
        }

        $tourLogModel = new TourLogModel(); // Giả định model này đã tồn tại

        // Xử lý khi có dữ liệu từ form gửi lên để tạo log mới
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['notes'])) {
            $notes = $_POST['notes'];
            $user_id = $_SESSION['user']['id']; // Lấy ID người dùng đang đăng nhập

            $tourLogModel->create($tour_id, $user_id, $notes);

            // Tải lại trang để hiển thị log mới nhất
            header('Location: ' . BASE_URL . '?action=tour-logs&tour_id=' . $tour_id);
            exit();
        }

        // Lấy danh sách các logs đã có của tour
        $logs = $tourLogModel->getLogsForTour($tour_id);

        // Lấy thông tin tour để hiển thị
        $tourModel = new TourModel();
        $tour = $tourModel->getOne($tour_id);

        // Dữ liệu này sẽ được truyền ra view 'tour-logs.php'
        // View này sẽ hiển thị cả danh sách logs và form để thêm mới
        $view = "admin/tour/tour-logs";
        require_once PATH_VIEW . 'main.php';
    }
}