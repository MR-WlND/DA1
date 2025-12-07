<?php
// File: controllers/FinancialController.php

class FinancialController
{
    // 1. Hiển thị danh sách Giao dịch (READ List)
    public function listTransaction()
    {
        $model = new FinanceModel(); // <<< Sử dụng tên Model mới
        $listTransactions = $model->getList(); 
        
        $title = "Quản lý Giao dịch Tài chính";
        $view = "admin/finance/list-transaction"; 
        require_once PATH_VIEW . 'main.php';
    }

    // 2. Thêm Giao dịch mới (CREATE)
    public function createTransaction()
    {
        $departureModel = new DepartureModel();
        $listDepartures = $departureModel->getList(); // Lấy list chuyến đi để liên kết giao dịch

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $title = "Thêm Giao dịch Tài chính";
            $view = "admin/finance/create-transaction";
            require_once PATH_VIEW . 'main.php';
        } else {
            $model = new FinanceModel();
            
            // Lấy dữ liệu từ POST
            $data = [
                'departure_id' => $_POST['departure_id'],
                'transaction_type' => $_POST['transaction_type'],
                'amount' => $_POST['amount'],
                'description' => $_POST['description'] ?? null,
                'transaction_date' => $_POST['transaction_date']
            ];
            
            $model->insert($data);
            header("Location: " . BASE_URL . "?action=list-transaction");
            exit;
        }
    }
    
    // 3. Cập nhật Giao dịch (UPDATE)
    public function updateTransaction()
    {
        $id = $_GET['id'];
        $model = new FinanceModel();
        $data = $model->getOne($id); 

        // Load Master Data
        $departureModel = new DepartureModel();
        $listDepartures = $departureModel->getList();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $title = "Cập nhật Giao dịch";
            $view = "admin/finance/update-transaction";
            require_once PATH_VIEW . 'main.php';
        } else {
            // Lấy dữ liệu từ POST
            $data = [
                'departure_id' => $_POST['departure_id'],
                'transaction_type' => $_POST['transaction_type'],
                'amount' => $_POST['amount'],
                'description' => $_POST['description'] ?? null,
                'transaction_date' => $_POST['transaction_date']
            ];
            
            $model->update($id, $data);
            header("Location: " . BASE_URL . "?action=list-transaction");
            exit;
        }
    }

    // 4. Xóa Giao dịch (DELETE)
    public function deleteTransaction()
    {
        $id = $_GET['id'];
        $model = new FinanceModel();
        
        $model->delete($id);
        header("Location: " . BASE_URL . "?action=list-transaction");
        exit;
    }
}