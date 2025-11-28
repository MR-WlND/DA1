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
   <link rel="stylesheet" href="assets/css/user.css">
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
               <a href="<?= BASE_URL ?>?action=dashboard">
                  GlobeTrek
               </a>
            </div>
            <div class="menu">

               <a href="<?= BASE_URL ?>?action=dashboard"
                  class="<?= ($action == 'dashboard') ? 'active' : '' ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a>

               <a href="<?= BASE_URL ?>?action=list-category"
                  class="<?= ($action == 'list-category') ? 'active' : '' ?>"><i class="fas fa-tags"></i> Danh mục Tour</a>

               <a href="<?= BASE_URL ?>?action=list-tour"
                  class="<?= ($action == 'list-tour') ? 'active' : '' ?>"><i class="fas fa-suitcase-rolling"></i> Quản lý Tour</a>

               <a href="<?= BASE_URL ?>?action=list-user"
                  class="<?= ($action == 'list-user') ? 'active' : '' ?>"><i class="fas fa-users"></i> Quản lý User</a>

               <a href="<?= BASE_URL ?>?action=order"
                  class="<?= ($action == 'order') ? 'active' : '' ?>"><i class="fas fa-ticket-alt"></i> Đơn đặt Tour</a>

               <a href="<?= BASE_URL ?>?action=list-guide"
                  class="<?= ($action == 'list-guide') ? 'active' : '' ?>"><i class="fas fa-user-tie"></i> Hướng dẫn viên</a>

               <a href="<?= BASE_URL ?>?action=report"
                  class="<?= ($action == 'report') ? 'active' : '' ?>"><i class="fas fa-file-alt"></i> Báo cáo</a>

               <a href="<?= BASE_URL ?>?action=logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>

            </div>
         </div>