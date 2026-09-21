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
    <link rel="icon" type="image/svg+xml" href="<?= BASE_URL ?>favicon.svg?v=<?= time() ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/client.css?v=<?= time() ?>">
</head>
<body class="client-body">

<!-- TOP BAR -->
<div class="top-bar">
    <div class="tb-inner">
        <div class="tb-left">
            <span>Omotenashi Concierge: <strong>1900 6868</strong></span>
        </div>
        <div class="tb-right">
            <span>VNĐ</span>
            <span class="sep">·</span>
            <span>VI / EN / JA</span>
        </div>
    </div>
</div>

<!-- NAVBAR -->
<nav class="client-navbar">
    <div class="nav-inner">
        <a href="<?= BASE_URL ?>?action=public-tours" class="brand-wrap">
            <div class="brand-logo">
                <div class="red-dot"></div>
            </div>
            <div class="brand-text">
                <div class="brand-name">GLOBETREK</div>
                <div class="brand-sub">WORLDWIDE JOURNEYS · JAPANESE SPIRIT</div>
            </div>
        </a>

        <div class="nav-links">
            <a href="<?= BASE_URL ?>?action=public-tours" class="active">Tuyển Tập Trải Nghiệm</a>
            <a href="<?= BASE_URL ?>?action=public-tours">Điểm Đến Mùa Này</a>
            <a href="<?= BASE_URL ?>?action=request-tour">Thiết Kế Riêng</a>
            <a href="#">Cảm Thức Lữ Hành</a>
        </div>

        <div class="nav-actions">
            <button class="icon-btn"><i class="fas fa-search"></i></button>
            <button class="icon-btn"><i class="far fa-heart"></i></button>
            <?php if ($isLoggedIn): ?>
                <a href="<?= BASE_URL ?>?action=detail-user&id=<?= $_SESSION['user']['id'] ?>" class="user-profile">
                    <i class="far fa-user-circle"></i>
                    <?= htmlspecialchars($userName) ?>
                </a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>?action=login" class="user-profile">
                    <i class="far fa-user-circle"></i>
                    Đăng nhập
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>
