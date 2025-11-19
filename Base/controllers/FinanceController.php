<?php
class FinanceController {
    private $model;
    public function __construct(){
        $this->model = new FinanceModel();
    }
    public function index()
     {
        $finances = $this->model->getAll();
        require_once PATH_VIEW . 'admin/finance.php';
    }
}
