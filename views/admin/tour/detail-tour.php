<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Chi tiết Tour: <?= htmlspecialchars($tour['name']) ?></h2>

    <div class="detail-container">
        <div class="detail-row">
            <div class="detail-label">ID:</div>
            <div class="detail-value"><?= $tour['id'] ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Tên Tour:</div>
            <div class="detail-value"><?= htmlspecialchars($tour['name']) ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Loại Tour:</div>
            <div class="detail-value"><?= htmlspecialchars($tour['tour_type']) ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Giá cơ bản:</div>
            <div class="detail-value"><?= number_format($tour['base_price'], 0, ',', '.') ?> ₫</div>
        </div>
        <div class="detail-row">
            <div class="detail-label">ID Điểm đến:</div>
            <div class="detail-value"><?= $tour['destination_id'] ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Mô tả:</div>
            <div class="detail-value"><?= nl2br(htmlspecialchars($tour['description'] ?? 'Chưa có mô tả.')) ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Chính sách hủy:</div>
            <div class="detail-value"><?= nl2br(htmlspecialchars($tour['cancellation_policy'] ?? 'Chưa có chính sách.')) ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Ngày tạo:</div>
            <div class="detail-value"><?= date('d/m/Y H:i:s', strtotime($tour['created_at'])) ?></div>
        </div>
    </div>
    <a href="<?= BASE_URL ?>?action=list-tour" class="btn btn-danger">Quay lại danh sách</a>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
