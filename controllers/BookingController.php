<?php

class BookingController
{
    public function index()
    {
        $bookings = (new BookingModel)->getAll();
        require_once __DIR__ . '/../views/admin/bookings.php';
    }

    public function updateStatus()
    {
        $id = $_GET['id'] ?? 0;
        $status = $_GET['status'] ?? '';

        if ($id && $status) {
            (new BookingModel)->updateStatus($id, $status);
        }

        header("Location: index.php?action=booking/index");
    }
}
