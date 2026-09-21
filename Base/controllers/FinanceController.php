<?php
// File: controllers/FinancialController.php

class FinanceController
{
    // 1. Hiá»ƒn thá»‹ danh sĂ¡ch Giao dá»‹ch (READ List)
    public function listTransaction()
    {
        requireAdmin();
        $model = new FinanceModel(); // <<< Sá»­ dá»¥ng tĂªn Model má»›i
        $listTransactions = $model->getList(); 
        
        $title = "Quáº£n lĂ½ Giao dá»‹ch TĂ i chĂ­nh";
        $view = "admin/finance/list-transaction"; 
        require_once PATH_VIEW . 'main.php';
    }

    // 2. ThĂªm Giao dá»‹ch má»›i (CREATE)
    public function createTransaction()
    {
        requireAdmin();
        $departureModel = new DepartureModel();
        $listDepartures = $departureModel->getList(); // Láº¥y list chuyáº¿n Ä‘i Ä‘á»ƒ liĂªn káº¿t giao dá»‹ch

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $title = "ThĂªm Giao dá»‹ch TĂ i chĂ­nh";
            $view = "admin/finance/create-transaction";
            require_once PATH_VIEW . 'main.php';
        } else {
            $model = new FinanceModel();
            
            // Láº¥y dá»¯ liá»‡u tá»« POST
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
    
    // 3. Cáº­p nháº­t Giao dá»‹ch (UPDATE)
    public function updateTransaction()
    {
        requireAdmin();
        $id = $_GET['id'];
        $model = new FinanceModel();
        $data = $model->getOne($id); 

        // Load Master Data
        $departureModel = new DepartureModel();
        $listDepartures = $departureModel->getList();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $title = "Cáº­p nháº­t Giao dá»‹ch";
            $view = "admin/finance/update-transaction";
            require_once PATH_VIEW . 'main.php';
        } else {
            // Láº¥y dá»¯ liá»‡u tá»« POST
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

    // 4. XĂ³a Giao dá»‹ch (DELETE)
    public function deleteTransaction()
    {
        requireAdmin();
        $id = $_GET['id'];
        $model = new FinanceModel();
        
        $model->delete($id);
        header("Location: " . BASE_URL . "?action=list-transaction");
        exit;
    }
}
