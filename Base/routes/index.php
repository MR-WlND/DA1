<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'                 => (new AuthController)->index(),
    'login'             => (new AuthController)->index(),
    'handleLogin'       => (new AuthController)->handleLogin(),
    'logout'            => (new AuthController)->logout(),

    // Dashboard theo vai trò
    'adminDashboard'    => (new TourCoreController)->dashboard(),
    'guideSchedule'     => (new GuideViewController)->schedule(),
};
