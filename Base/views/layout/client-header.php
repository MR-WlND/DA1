<?php
// Xac dinh trang hien tai
$currentAction = $_GET['action'] ?? 'public-tours';
$isLoggedIn = !empty($_SESSION['user']);
$userName = $isLoggedIn ? ($_SESSION['user']['name'] ?? 'User') : null;
$userRole = $isLoggedIn ? ($_SESSION['user']['role'] ?? '') : null;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlobeTrek – Khám Phá Thế Giới</title>
    <meta name="description" content="GlobeTrek – Nền tảng đặt tour du lịch uy tín, chất lượng cao với hàng trăm hành trình hấp dẫn.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/client.css">
</head>
<body class="client-body">

<!-- NAVBAR -->
<nav class="client-navbar">
    <div class="nav-inner">
        <a href="<?= BASE_URL ?>?action=public-tours" class="brand">GlobeTrek</a>

        <div class="nav-links">
            <a href="<?= BASE_URL ?>?action=public-tours" class="<?= $currentAction === 'public-tours' || $currentAction === 'public-detail-tour' ? 'active' : '' ?>">
                <i class="fas fa-compass me-1"></i> Tour Du Lịch
            </a>
            <?php if ($isLoggedIn && $userRole === 'customer'): ?>
            <a href="<?= BASE_URL ?>?action=my-bookings" class="<?= $currentAction === 'my-bookings' ? 'active' : '' ?>">
                <i class="fas fa-ticket-alt me-1"></i> Đơn Hàng
            </a>
            <a href="<?= BASE_URL ?>?action=request-tour" class="<?= $currentAction === 'request-tour' || $currentAction === 'customer_list' ? 'active' : '' ?>">
                <i class="fas fa-suitcase me-1"></i> Tour Tùy Chỉnh
            </a>
            <a href="<?= BASE_URL ?>?action=my-quotes" class="<?= $currentAction === 'my-quotes' ? 'active' : '' ?>">
                <i class="fas fa-file-invoice-dollar me-1"></i> Báo Giá
            </a>
            <?php endif; ?>
        </div>

        <div class="nav-search">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Tìm kiếm tour..." id="navSearch">
        </div>

        <div class="nav-actions">
            <?php if ($isLoggedIn): ?>
                <a href="<?= BASE_URL ?>?action=detail-user&id=<?= $_SESSION['user']['id'] ?>" class="user-chip">
                    <i class="fas fa-user-circle"></i>
                    <?= htmlspecialchars($userName) ?>
                </a>
                <a href="<?= BASE_URL ?>?action=logout" class="btn-login" style="border-color:#ccc; color:#666;">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>?action=login" class="btn-login">Đăng nhập</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
