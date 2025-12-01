<?php include PATH_VIEW . 'layout/header.php'; ?>

<style>
/* ---------- Form lọc ---------- */
.tour-filter-form {
    margin-bottom: 25px;
    padding: 15px;
    border: 1px solid #c5c5c5ff;
    border-radius: 12px;
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}

.tour-filter-form input,
.tour-filter-form select {
    padding: 8px 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 14px;
    outline: none;
}

.tour-filter-form input:focus,
.tour-filter-form select:focus {
    border-color: #7c3aed;
    box-shadow: 0 0 5px rgba(124,58,237,0.5);
}

.btn-filter {
    background: linear-gradient(180deg, #4e54c8, #8f94fb);
    color: white;
    padding: 8px 16px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    transition: 0.25s;
    text-decoration: none;
}

.btn-filter:hover {
    background: #7745ffff;
}

/* ---------- Grid card ---------- */
.tour-grid-premium {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}

/* ---------- Card ---------- */
.tour-card-premium {
    background: linear-gradient(145deg, #ffffff, #f1f1f1);
    border-radius: 18px;
    overflow: hidden;
    border: 2px solid transparent;
    background-clip: padding-box;
    position: relative;
    padding-bottom: 10px;
    transition: 0.35s;
    box-shadow:
        0 10px 25px rgba(0,0,0,0.12),
        inset 0 0 20px rgba(255,255,255,0.4);
}

.tour-card-premium:hover {
    transform: translateY(-6px);
    box-shadow:
        0 18px 40px rgba(0,0,0,0.2),
        inset 0 0 25px rgba(255,255,255,0.6);
    border: 2px solid #c7afffff;
}

.tour-img-wrap {
    position: relative;
}

.tour-img-wrap img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.no-img-premium {
    height: 150px;
    background: #ddd;
    display: flex;
    justify-content: center;
    align-items: center;
}

.tour-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: linear-gradient(180deg, #4e54c8, #8f94fb);
    padding: 5px 10px;
    border-radius: 25px;
    color: white;
    font-size: 12px;
    font-weight: 600;
    box-shadow: 0 4px 10px rgba(124,58,237,0.4);
}

.tour-body {
    padding: 12px 15px;
}

.tour-title {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 10px;
    color: #333;
}

.tour-info p {
    font-size: 13px;
    color: #555;
    margin: 4px 0;
}

.tour-info i {
    color: #7d66fdff;
    margin-right: 4px;
}

.price-row {
    margin: 10px 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.price {
    font-size: 17px;
    font-weight: 700;
    color: #10b981;
}

.btn-schedule {
    background: #6366f1;
    color: white;
    padding: 4px 10px;
    border-radius: 8px;
    font-size: 12px;
    text-decoration: none;
}

.btn-schedule:hover {
    background: #4f46e5;
}

.tour-actions-premium {
    display: flex;
    gap: 8px;
    margin-top: 12px;
}

.btn-action {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    color: white;
    cursor: pointer;
    text-decoration: none;
}

.btn-action.edit {
    background: #f59e0b;
}

.btn-action.edit:hover {
    background: #d97706;
}

.btn-action.view {
    background: #3b82f6;
}

.btn-action.view:hover {
    background: #2563eb;
}
</style>

<div class="main">

    <h2>Quản lý Tour</h2>

    <!-- ---------- Form lọc ---------- -->
    <div class="tour-filter-form">
        <form method="get" action="">
            <input type="text" name="keyword" placeholder="Tìm kiếm tour..." value="<?= $_GET['keyword'] ?? '' ?>">

            <select name="category">
                <option value="">Tất cả danh mục</option>
                <?php foreach($listCategories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= (($_GET['category'] ?? '') == $cat['id']) ? 'selected' : '' ?>>
                        <?= $cat['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="status">
                <option value="">Tất cả trạng thái</option>
                <option value="open" <?= (($_GET['status'] ?? '') == 'open') ? 'selected' : '' ?>>Đang mở</option>
                <option value="close" <?= (($_GET['status'] ?? '') == 'close') ? 'selected' : '' ?>>Tạm ngưng</option>
            </select>

            <input type="number" name="price_max" placeholder="Giá tối đa" value="<?= $_GET['price_max'] ?? '' ?>">

            <button type="submit" class="btn btn-nut">Lọc</button>
            <a href="<?= BASE_URL ?>?action=create-tour" class="btn btn-nut">+ Thêm Tour</a>
        </form>
    </div>

    <!-- ---------- Grid card tour ---------- -->
    <div class="tour-grid-premium">
        <?php foreach ($listTours as $tour): ?>
            <div class="tour-card-premium">

                <div class="tour-img-wrap">
                    <?php if (!empty($tour['main_image_path'])): ?>
                        <img src="<?= BASE_ASSETS_UPLOADS . $tour['main_image_path'] ?>" alt="">
                    <?php else: ?>
                        <div class="no-img-premium">Không có ảnh</div>
                    <?php endif; ?>

                    <span class="tour-badge">
                        <?= $tour['category_name'] ?? 'Danh mục' ?>
                    </span>
                </div>

                <div class="tour-body">
                    <h3 class="tour-title"><?= $tour['name'] ?></h3>

                    <div class="tour-info">
                        <p><i class="fas fa-tag"></i> <strong>Loại tour:</strong> <?= $tour['tour_type'] ?></p>
                        <p><i class="fas fa-store"></i> <strong>Loại hình bán:</strong> <?= $tour['tour_origin'] ?></p>
                        <p><i class="fas fa-route"></i> <strong>Lộ trình:</strong>
                            <?= !empty($tour['destination_route_summary']) ? $tour['destination_route_summary'] : '<i>Chưa có</i>' ?>
                        </p>
                    </div>

                    <div class="price-row">
                        <span class="price"><?= number_format($tour['base_price']) ?> đ</span>

                        <?php if ($tour['total_departures_count'] > 0): ?>
                            <a href="<?= BASE_URL ?>?action=list-departure&tour_id=<?= $tour['id'] ?>"
                               class="btn-schedule">Lịch (<?= $tour['total_departures_count'] ?>)</a>
                        <?php endif; ?>
                    </div>

                    <div class="tour-actions-premium">
                        <a href="<?= BASE_URL ?>?action=update-tour&id=<?= $tour['id'] ?>" class="btn-action edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= BASE_URL ?>?action=detail-tour&id=<?= $tour['id'] ?>" class="btn-action view">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
