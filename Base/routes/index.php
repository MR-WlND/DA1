<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'                 => (new AuthController)->index(),
    'login'             => (new AuthController)->index(),
    'handleLogin'       => (new AuthController)->handleLogin(),
    'logout'            => (new AuthController)->logout(),

    // Dashboard theo vai trò
    'dashboard'         => (new DashboardController)->index(),

    // User Management 
    'list-user'         => (new UsersController)->listUser(),
    'delete-user'       => (new UsersController)->deleteUser(),
    'create-user'       => (new UsersController)->createUser(),
    'update-user'       => (new UsersController)->updateUser(),
    'detail-user'       => (new UsersController)->detailUser(),

    // Bookings
    'bookings'          => (new BookingController)->index(),
    'booking-create'    => (new BookingController)->create(),
    'booking-edit'      => (new BookingController)->edit(),
    'booking-delete'    => (new BookingController)->delete(),


    // Tour Management
    'list-tour'         => (new TourController)->listTour(),
    'create-tour'       => (new TourController)->createTour(),
    'update-tour'       => (new TourController)->updateTour(),
    'delete-tour'       => (new TourController)->deleteTour(),
    'detail-tour'       => (new TourController)->detailTour(),
};
