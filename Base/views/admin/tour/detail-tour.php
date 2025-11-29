<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Chi tiết Tour: <?= $tour['name'] ?></h2>

    <div class="detail-container">
        <div class="detail-row">
            <div class="detail-label">ID:</div>
            <div class="detail-value"><?= $tour['id'] ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Tên Tour:</div>
            <div class="detail-value"><?= $tour['name'] ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Loại Tour:</div>
            <div class="detail-value"><?= $tour['tour_type'] ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Giá cơ bản:</div>
            <div class="detail-value"><?= number_format($tour['base_price'], 0, ',', '.') ?> ₫</div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Điểm đến:</div>
            <div class="detail-value"><?= $tour['destination_name'] ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Quốc gia:</div>
            <div class="detail-value"><?= $tour['destination_country'] ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Danh mục:</div>
            <div class="detail-value"><?= $tour['category_name'] ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Ảnh đại diện:</div>
            <div class="detail-value">
                <?php if (!empty($tour['image'])): ?>
                    <img src="<?= BASE_ASSETS_UPLOADS . $tour['image'] ?>" alt="Tour Image" style="max-width: 100px;">
                <?php else: ?>
                    Chưa có ảnh.
                <?php endif; ?>
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Mô tả:</div>
            <div class="detail-value"><?= $tour['description'] ?? 'Chưa có mô tả.' ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Chính sách hủy:</div>
            <div class="detail-value"><?= $tour['cancellation_policy'] ?? 'Chưa có chính sách.' ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Ngày tạo:</div>
            <div class="detail-value"><?= date('d/m/Y H:i:s', strtotime($tour['created_at'])) ?></div>
        </div>
    </div>
    <a href="<?= BASE_URL ?>?action=list-tour" class="btn btn-danger">Quay lại danh sách</a>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>