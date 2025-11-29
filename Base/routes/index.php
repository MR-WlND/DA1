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
    'list-category'   => (new CategoryController)->listCategory(),
    'create-category' => (new CategoryController)->createCategory(),
    'update-category' => (new CategoryController)->updateCategory(),
    'delete-category' => (new CategoryController)->deleteCategory(),


    // Destination Management
    'list-destination'         => (new DestinationController)->listDestination(),
    'create-destination'       => (new DestinationController)->createDestination(),
    'update-destination'       => (new DestinationController)->updateDestination(),
    'delete-destination'       => (new DestinationController)->deleteDestination(),

    // Departure Management
    'list-departure'         =>(new DepartureController)->listDeparture(),
    'create-departure'       => (new DepartureController)->createDeparture(),
    'update-departure'       => (new DepartureController)->updateDeparture(),
    'delete-departure'       => (new DepartureController)->deleteDeparture(),

    // Hotel Management
    'list-hotel'         => (new HotelController)->listHotel(),
    'create-hotel'       => (new HotelController)->createHotel(),
    'update-hotel'       => (new HotelController)->updateHotel(),
    'delete-hotel'       => (new HotelController)->deleteHotel(),

    // Guide Management
    'list-guide'         => (new GuideController)->listGuide(),
    'create-guide'       => (new GuideController)->createGuide(),
    'update-guide'       => (new GuideController)->updateGuide(),
    'delete-guide'       => (new GuideController)->deleteGuide(),
    'detail-guide'       => (new GuideController)->detailGuide(),

    // Cancellation Policy Management
    'list-policies'   => (new CancellationPolicyController)->listPolicies(),
    'create-policy'  => (new CancellationPolicyController)->createPolicy(),
    'update-policy'  => (new CancellationPolicyController)->updatePolicy(),
    'delete-policy'  => (new CancellationPolicyController)->deletePolicy(),
};
