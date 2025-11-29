<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Local CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/layout.css">
    <link rel="stylesheet" href="assets/css/table.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<?php $action = $_GET['action'] ?? 'dashboard'; ?>

<body>
    <div class="layout">
        <div class="main-content">
            <!-- TOPBAR -->
            <div class="topBar">
                <div class="search">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Tìm kiếm..." />
                </div>
                <div class="user">
                    <span><?= $_SESSION['user']['name'] ?? 'Admin' ?></span>
                    <a href="<?= BASE_URL ?>?action=detail-user&id=<?= $_SESSION['user']['id'] ?>">
                        <div class="avatar"><i class="fa-regular fa-user"></i></div>
                    </a>
                </div>
            </div>
            <!-- SIDEBAR -->
            <div class="sidebar">
                <div class="brand">
                    <a href="<?= BASE_URL ?>?action=dashboard">GlobeTrek</a>
                </div>

                <?php $action = $_GET['action'] ?? 'dashboard'; ?>

                <div class="menu">
                    <!-- Dashboard -->
                    <a href="<?= BASE_URL ?>?action=dashboard" class="<?= ($action == 'dashboard') ? 'active' : '' ?>">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>

                    <!-- Quản lý Tour -->
                    <?php
                    $tour_actions = ['list-tour', 'list-departure', 'list-destination', 'list-category', 'list-custom-requests','list-policies'];
                    $is_tour_group_active = in_array($action, $tour_actions);
                    ?>
                    <div class="dropdown <?= $is_tour_group_active ? 'active' : '' ?>">
                        <span class="drop-btn"><i class="fas fa-suitcase-rolling"></i> Quản lý Tour</span>
                        <div class="drop-content">
                            <a href="<?= BASE_URL ?>?action=list-tour" class="<?= ($action == 'list-tour') ? 'active-sub' : '' ?>">• Sản Phẩm Tour</a>
                            <a href="<?= BASE_URL ?>?action=list-departure" class="<?= ($action == 'list-departure') ? 'active-sub' : '' ?>">• Lịch Khởi Hành</a>
                            <a href="<?= BASE_URL ?>?action=list-destination" class="<?= ($action == 'list-destination') ? 'active-sub' : '' ?>">• Điểm Đến</a>
                            <a href="<?= BASE_URL ?>?action=list-category" class="<?= ($action == 'list-category') ? 'active-sub' : '' ?>">• Danh Mục Tour</a>
                            <a href="<?= BASE_URL ?>?action=list-custom-requests" class="<?= ($action == 'list-custom-requests') ? 'active-sub' : '' ?>">• Tour Theo Yêu Cầu</a>
                            <a href="<?= BASE_URL ?>?action=list-policies" class="<?= ($action == 'list-policies') ? 'active-sub' : '' ?>">• Chính sách hủy</a>
                        </div>
                    </div>

                    <!-- Quản lý Đặt chỗ -->
                    <?php
                    $order_actions = ['order', 'list-order', 'list-payment', 'list-booking-customers'];
                    $is_order_group_active = in_array($action, $order_actions);
                    ?>
                    <div class="dropdown <?= $is_order_group_active ? 'active' : '' ?>">
                        <span class="drop-btn"><i class="fas fa-ticket-alt"></i> Quản lý Đặt chỗ</span>
                        <div class="drop-content">
                            <a href="<?= BASE_URL ?>?action=order" class="<?= ($action == 'order') ? 'active-sub' : '' ?>">• Phân bổ tài nguyên</a>
                            <a href="<?= BASE_URL ?>?action=list-order" class="<?= ($action == 'list-order') ? 'active-sub' : '' ?>">• Đơn đặt Tour</a>
                            <a href="<?= BASE_URL ?>?action=list-payment" class="<?= ($action == 'list-payment') ? 'active-sub' : '' ?>">• Thanh Toán</a>
                            <a href="<?= BASE_URL ?>?action=list-booking-customers" class="<?= ($action == 'list-booking-customers') ? 'active-sub' : '' ?>">• Khách Tham Gia</a>
                        </div>
                    </div>

                    <!-- Quản lý Tài nguyên -->
                    <div class="dropdown <?= $is_order_group_active ? 'active' : '' ?>">
                        <a href="<?= BASE_URL ?>?action=list-user" class="<?= ($action == 'list-user') ? 'active' : '' ?>"><i class="fas fa-users"></i> Quản lý User</a>
                        <a href="<?= BASE_URL ?>?action=list-guide" class="<?= ($action == 'list-guide') ? 'active' : '' ?>"><i class="fas fa-user-tie"></i> Hướng dẫn viên</a>
                        <a href="<?= BASE_URL ?>?action=list-hotel" class="<?= ($action == 'list-hotel') ? 'active' : '' ?>"><i class="fas fa-hotel"></i> Khách Sạn & NCC</a>
                    </div>
                    <!-- Báo cáo & Đăng xuất -->
                    <a href="<?= BASE_URL ?>?action=report" class="<?= ($action == 'report') ? 'active' : '' ?>"><i class="fas fa-file-alt"></i> Báo cáo</a>
                    <a href="<?= BASE_URL ?>?action=logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
                </div>
            </div>