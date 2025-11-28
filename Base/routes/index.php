<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'                 => (new AuthController)->index(),
    'login'             => (new AuthController)->index(),
    'handleLogin'       => (new AuthController)->handleLogin(),
    'logout'            => (new AuthController)->logout(),

    // Dashboard theo vai trò
    'dashboard'         => (new DashboardController)->index(),
    'guideSchedule'     => (new GuideViewController)->schedule(),

    // User Management 
    'list-user'         => (new UsersController)->listUser(),
    'delete-user'       => (new UsersController)->deleteUser(),
    'create-user'       => (new UsersController)->createUser(),
    'update-user'       => (new UsersController)->updateUser(),
    'detail-user'       => (new UsersController)->detailUser(),

    // Tour Management
    'list-tour'         => (new TourController)->listTour(),
    'create-tour'       => (new TourController)->createTour(),
    'update-tour'       => (new TourController)->updateTour(),
    'delete-tour'       => (new TourController)->deleteTour(),
    'detail-tour'       => (new TourController)->detailTour(),

    // Categories Management
    'list-category'         => (new CategoryController)->listCategory(),
    'create-category'       => (new CategoryController)->createCategory(),
    'update-category'       => (new CategoryController)->updateCategory(),
    'delete-category'       => (new CategoryController)->deleteCategory(),

    // Customer Management
    'list-customer'         => (new CustomerController)->listCustomer(),
    'create-customer'       => (new CustomerController)->createCustomer(),
    'update-customer'       => (new CustomerController)->updateCustomer(),
    'delete-customer'       => (new CustomerController)->deleteCustomer(),

// Guide Management

'list-guide'   => (new GuideViewController)->listGuide(),
'create-guide' => (new GuideViewController)->createGuide(),
'update-guide' => (new GuideViewController)->updateGuide(),
'delete-guide' => (new GuideViewController)->deleteGuide(),
'detail-guide' => (new GuideViewController)->detailGuide(),



};
