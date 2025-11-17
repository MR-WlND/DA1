<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'         => (new HomeController)->index(),
    '/admin/bookings' => (new BookingController($db))->index(),
    '/admin/bookings' => (new BookingController($db))->update(),
};
