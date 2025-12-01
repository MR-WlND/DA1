<?php

class TransportSupplierController
{
    public function listSupplier()
    {
        $model = new TransportSupplierModel(); // Khởi tạo Model cục bộ
        $listSuppliers = $model->getList();
        $title = "Quản lý NCC Vận tải";
        $view = "admin/transport/list-supplier";
        require_once PATH_VIEW . 'main.php';
    }

    // 2. Thêm NCC mới (CREATE)
    public function createSupplier()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Có thể cần TourModel để lấy list Destinations nếu NCC liên kết với địa điểm
            // $destinationModel = new DestinationModel(); 
            // $listDestination = $destinationModel->getList(); 

            $title = "Thêm NCC Vận tải";
            $view = "admin/transport/create-supplier";
            require_once PATH_VIEW . 'main.php';
        } else {
            // Lấy dữ liệu từ form và gọi Model
            $name = $_POST['supplier_name'];
            $contact = $_POST['contact_person'] ?? null;
            $phone = $_POST['phone'] ?? null;
            $email = $_POST['email'] ?? null;
            $details = $_POST['details'] ?? null;

            try {
                $model = new TransportSupplierModel();
                $model->insert($name, $contact, $phone, $email, $details);

                // Chuyển hướng sau khi tạo thành công
                header("Location: " . BASE_URL . "?action=list-supplier");
                exit;
            } catch (Exception $e) {
                // Xử lý lỗi CSDL
                echo "Lỗi: Không thể thêm NCC. " . $e->getMessage();
            }
        }
    }

    // 3. Cập nhật NCC (UPDATE)
    public function updateSupplier()
    {
        $id = $_GET['id'] ?? null;
        $model = new TransportSupplierModel();
        $supplier = $model->getOne($id);
        
        if (!$supplier) {
            echo "Nhà cung cấp không tồn tại!";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $title = "Cập nhật NCC Vận tải";
            $view = "admin/transport/update-supplier";
            require_once PATH_VIEW . 'main.php';
        } else {
            // Lấy dữ liệu và gọi Model
            $name = $_POST['supplier_name'];
            $contact = $_POST['contact_person'] ?? null;
            $phone = $_POST['phone'] ?? null;
            $email = $_POST['email'] ?? null;
            $details = $_POST['details'] ?? null;

            $model->update($id, $name, $contact, $phone, $email, $details);

            header("Location: " . BASE_URL . "?action=list-supplier");
            exit;
        }
    }

    // 4. Xóa NCC (DELETE)
    public function deleteSupplier()
    {
        $id = $_GET['id'] ?? null;
        $model = new TransportSupplierModel();
        
        // Cần lấy dữ liệu trước để kiểm tra tồn tại và xử lý FK (nếu cần)
        if (!$model->getOne($id)) {
            echo "Nhà cung cấp không tồn tại!";
            return;
        }

        try {
            $model->delete($id);
            header("Location: " . BASE_URL . "?action=list-supplier");
            exit;
        } catch (Exception $e) {
            // Bắt lỗi FK nếu NCC này còn được tham chiếu trong departure_resources
            echo "Lỗi: Không thể xóa NCC (Có thể còn liên kết với chuyến khởi hành).";
        }
    }
}