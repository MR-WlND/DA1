<?php

class BookingController {
    private $model;

    public function __construct() {
        $this->model = new BookingModel();
    }

    public function index() {
        $bookings = $this->model->getAll();
        require_once PATH_VIEW . 'admin/bookings.php';
    }

    public function create() {
        $tours = $this->model->getTours();

        if (!empty($_POST)) {
            $this->model->store($_POST);
            header("Location: ?action=bookings");
            exit;
        }

        require_once PATH_VIEW . 'admin/booking-create.php';
    }

    public function edit() {
        $id = $_GET['id'];
        $booking = $this->model->find($id);
        $tours = $this->model->getTours();

        if (!empty($_POST)) {
            $this->model->update($id, $_POST);
            header("Location: ?action=bookings");
            exit;
        }

        require_once PATH_VIEW . 'admin/booking-edit.php';
    }

    public function delete() {
        $id = $_GET['id'];
        $this->model->delete($id);
        header("Location: ?action=bookings");
    }
}
