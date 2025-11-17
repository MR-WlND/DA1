<?php
require_once "./models/BookingModel.php";

class BookingController {

    private $bookingModel;

    public function __construct($db) {
        $this->bookingModel = new BookingModel($db);
    }

    public function index() {
        $bookings = $this->bookingModel->getAll();
        include "./views/admin/bookings.php";
    }

    public function update() {
        if (isset($_POST['id']) && isset($_POST['status'])) {
            $this->bookingModel->updateStatus($_POST['id'], $_POST['status']);
        }
        header("Location: index.php?route=admin/bookings");
    }
}
