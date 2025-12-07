<?php include PATH_VIEW . 'layout/header.php'; ?>

<style>
    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    h2 {
        margin: 0 0 24px;
        font-size: 26px;
        font-weight: 700;
    }

    /* FILTER BAR */
    .filter-bar {
        background: #fff;
        padding: 18px;
        border-radius: 12px;
        border: 1px solid #e5e5e5;
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 26px;
    }

    .filter-bar input,
    .filter-bar select {
        padding: 10px 14px;
        border-radius: 8px;
        border: 1px solid #d0d0d0;
        background: #fafafa;
        font-size: 14px;
    }

    .btn-add {
        margin-left: auto;
        padding: 10px 18px;
        background: #111;
        color: #fff;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-weight: 600;
    }

    /* CARD GRID */
    .grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 22px;
    }

    .card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #e6e6e6;
        overflow: hidden;
        transition: 0.2s ease;
        padding: 0%;
    }


    .card img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }

    .card-body {
        padding: 16px;
    }

    .card-title {
        font-size: 17px;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .card-info {
        font-size: 14px;
        color: #555;
        margin-bottom: 4px;
    }

    .actions {
        display: flex;
        margin-top: 10px;
        gap: 10px;
    }

    .btn {
        flex: 1;
        padding: 10px 0;
        font-size: 13px;
        border-radius: 6px;
        border: 1px solid #ccc;
        background: #f9f9f9;
        cursor: pointer;
        transition: 0.15s;
    }

    .btn a {
        text-decoration: none;
    }

    .btn:hover {
        background: #cae2ffff;
    }

    .view {
        border-color: #49ff80ff;
    }

    .edit {
        border-color: #6f83ffff;
    }

    .delete {
        border-color: #b70000;
        color: #b70000;
    }

    .page-header {
        margin-bottom: 24px;
    }

    .page-header .breadcrumb {
        font-size: 14px;
        color: #1e3a8a;
        font-weight: 500;
        margin-bottom: 6px;
    }

    h2 {
        color: #0f3d8f;
        border-left: 4px solid #0f3d8f;
        padding-left: 10px;
    }

    .filter-bar,
    .card {
        border: 1px solid #d0e2ff;
    }

    .btn-nut {
        background: #1e40af;
        margin-left: 250px;
    }

    .subtitle {
        font-size: 14px;
        color: #3b5998;
        margin-top: 4px;
        margin-left: 14px;
        opacity: 0.9;
    }

    .page-header {
        margin-bottom: 28px;
    }

    .redesigned.filter-bar {
        background: #fff;
        border: 1px solid #ccd8ff;
        padding: 18px;
        border-radius: 12px;
        display: flex;
        gap: 14px;
        margin-bottom: 28px;
    }

    .redesigned-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 26px;
    }

    .newcard {
        border: none;
        box-shadow: 0 3px 10px rgba(0, 35, 85, 0.08);
        border-radius: 14px;
        overflow: hidden;
        background: #ffffff;
        transition: 0.25s ease;
    }


    .newactions button {
        border-radius: 8px !important;
        background: #f5f8ff !important;
        border: 1px solid #b5c8ff !important;
        transition: 0.2s;
    }

    .newactions button:hover {
        background: #e5edff !important;
    }

    .card-category {
        font-size: 13px;
        color: #1e40af;
        background: #e8f0ff;
        display: inline-block;
        padding: 4px 10px;
        border-radius: 6px;
        margin-bottom: 8px;
        font-weight: 600;
    }

    .card-price {
        font-size: 17px;
        font-weight: 600;
        color: #0f3d8f;
        margin: 8px 0;
    }

    .card-desc {
        font-size: 13px;
        color: #444;
        line-height: 1.5;
        margin: 8px 0 12px 0;
        opacity: 1;
        display: block;
        word-wrap: break-word;
    }
</style>

<div class="main">

    <div class="header-wrapper">
        <div class="header-content">
            <div class="breadcrumb">Quản lý Tour / Danh sách tour</div>
            <h2 class="page-title">Danh sách Tour</h2>
            <p class="page-sub">Quản lý toàn bộ tour du lịch trong hệ thống admin</p>
        </div>
    </div>

    <!-- FILTER BAR -->
    <div class="filter-bar redesigned">
        <input type="text" placeholder="Tìm kiếm tour..." />
        <select>
            <option>Danh mục</option>
            <option>Trong nước</option>
            <option>Nước ngoài</option>
        </select>
        <select>
            <option>Sắp xếp</option>
            <option>Giá tăng dần</option>
            <option>Giá giảm dần</option>
        </select>
        <a href="<?= BASE_URL ?>?action=create-tour" class="btn btn-nut">+ Thêm Tour</a>
    </div>

    <!-- ---------- Grid card tour ---------- -->
    <div class="redesigned-grid">
        <?php foreach ($listTours as $tour): ?>
            <div class="card newcard">


                <?php if (!empty($tour['main_image_path'])): ?>
                    <img src="<?= BASE_ASSETS_UPLOADS . $tour['main_image_path'] ?>" alt="">
                <?php endif; ?>



                <div class="card-body">
                    <div class="card-title"><?= $tour['name'] ?></div>

                    <div class="card-category"><?= !empty($tour['category_name']) ? $tour['category_name'] : $tour['tour_type'] ?></div>

                    <div class="card-desc">
                        <?= !empty($tour['description']) ? substr($tour['description'], 0, 53) . (strlen($tour['description']) > 53 ? '...' : '') : '<i>Chưa có mô tả</i>' ?>
                    </div>
                    <div class="card-info"><strong>Lộ trình:</strong>
                        <?= !empty($tour['destination_route_summary']) ? $tour['destination_route_summary'] : '<i>Chưa có</i>' ?>
                    </div>

                    <div class="card-price">Giá:
                        <span class="price"><?= number_format($tour['base_price']) ?> đ</span>
                    </div>


                    <div class="actions newactions">
                        <a href="<?= BASE_URL ?>?action=detail-tour&id=<?= $tour['id'] ?>" class="btn btn-action view">
                            Xem</a>
                        <a href="<?= BASE_URL ?>?action=update-tour&id=<?= $tour['id'] ?>" class="btn btn-action edit">
                            Sửa
                        </a>
                        <a class="btn btn-action delete" href="<?= BASE_URL ?>?action=delete-tour&id=<?= $tour['id'] ?>"
                            onclick="return confirm('Bạn có chắc muốn xóa tour này không?')">Xóa</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php include PATH_VIEW . 'layout/footer.php'; ?>