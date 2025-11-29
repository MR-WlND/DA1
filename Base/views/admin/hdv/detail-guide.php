<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <div class="container-fluid">
        <h2 class="mb-4">Chi tiết HDV: <?= htmlspecialchars($guide['name']) ?></h2>

        <div class="detail-container">
            <h4 class="text-primary mt-3 mb-3 border-bottom">1. Thông tin tài khoản</h4>
            
            <div class="detail-row">
                <div class="detail-label">ID Hệ thống:</div>
                <div class="detail-value">#<?= $guide['id'] ?></div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Ảnh đại diện:</div>
                <div class="detail-value">
                    <?php if (!empty($guide['photo_url'])): ?>
                        <img src="<?= BASE_URL . $guide['photo_url'] ?>" alt="Avatar" style="max-width:150px; border-radius:10px; box-shadow: 0 0 5px rgba(0,0,0,0.2);">
                    <?php else: ?>
                        <span class="text-muted">Chưa cập nhật ảnh</span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Họ và tên:</div>
                <div class="detail-value"><strong><?= htmlspecialchars($guide['name']) ?></strong></div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Thông tin liên hệ:</div>
                <div class="detail-value">
                    <p class="mb-1">📧 Email: <?= htmlspecialchars($guide['email']) ?></p>
                    <p class="mb-0">📞 SĐT: <?= htmlspecialchars($guide['phone']) ?></p>
                </div>
            </div>

            <h4 class="text-success mt-4 mb-3 border-bottom">2. Hồ sơ chuyên môn</h4>

            <div class="detail-row">
                <div class="detail-label">Phân loại & Nhóm:</div>
                <div class="detail-value">
                    <span class="badge bg-info text-dark">
                        <?= ($guide['category'] == 'international') ? 'Quốc tế (International)' : 'Nội địa (Domestic)' ?>
                    </span>
                    <span class="badge bg-warning text-dark ms-2">
                        Nhóm: <?= ucfirst($guide['specialty_group'] ?? 'Standard') ?>
                    </span>
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Tuyến điểm sở trường:</div>
                <div class="detail-value"><?= htmlspecialchars($guide['specialty_route'] ?? 'Chưa cập nhật') ?></div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Ngôn ngữ thành thạo:</div>
                <div class="detail-value"><?= htmlspecialchars($guide['languages'] ?? '-') ?></div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Kinh nghiệm:</div>
                <div class="detail-value">
                    <?= htmlspecialchars($guide['experience_years'] ?? '0') ?> năm
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Ngày sinh:</div>
                <div class="detail-value">
                    <?= !empty($guide['date_of_birth']) ? date('d/m/Y', strtotime($guide['date_of_birth'])) : '-' ?>
                </div>
            </div>

            <h4 class="text-info mt-4 mb-3 border-bottom">3. Thông tin bổ sung</h4>

            <div class="detail-row">
                <div class="detail-label">Chứng chỉ / Bằng cấp:</div>
                <div class="detail-value text-break">
                    <?= nl2br(htmlspecialchars($guide['certification'] ?? 'Không có thông tin')) ?>
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Tình trạng sức khỏe:</div>
                <div class="detail-value">
                    <?= htmlspecialchars($guide['health_status'] ?? 'Bình thường') ?>
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Ghi chú:</div>
                <div class="detail-value text-muted font-italic">
                    <?= nl2br(htmlspecialchars($guide['notes'] ?? 'Không có ghi chú')) ?>
                </div>
            </div>

        </div>

        <div class="mt-4 mb-5">
            <a href="<?= BASE_URL ?>?action=update-guide&id=<?= $guide['id'] ?>" class="btn btn-primary">✏️ Sửa thông tin</a>
            <a href="<?= BASE_URL ?>?action=list-guide" class="btn btn-secondary ms-2">Quay lại danh sách</a>
        </div>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>