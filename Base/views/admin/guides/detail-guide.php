<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2 class="page-title">Chi tiết Hướng dẫn viên</h2>

    <div class="detail-guide-card">
        <!-- Ảnh -->
        <div class="avatar-section">
            <?php if (!empty($data['photo_url'])): ?>
                <img src="<?= BASE_ASSETS_UPLOADS . $data['photo_url'] ?>" alt="avatar">
            <?php else: ?>
                <span>Không có ảnh</span>
            <?php endif; ?>
        </div>

        <!-- Thông tin -->
        <div class="info-section">
            <h3 class="guide-name"><?= $data['name'] ?? '' ?></h3>
            <div class="info-grid">
                <div><i class="fa fa-envelope"></i> <span class="label">Email:</span> <span class="value"><?= $data['email'] ?? '' ?></span></div>
                <div><i class="fa fa-phone"></i> <span class="label">Điện thoại:</span> <span class="value"><?= $data['phone'] ?? '' ?></span></div>
                <div><i class="fa fa-tag"></i> <span class="label">Loại:</span> <span class="value"><?= $data['category'] ?? '' ?></span></div>
                <div><i class="fa fa-road"></i> <span class="label">Tuyến chuyên môn:</span> <span class="value"><?= $data['specialty_route'] ?? '' ?></span></div>
                <div><i class="fa fa-users"></i> <span class="label">Nhóm chuyên môn:</span> <span class="value"><?= $data['specialty_group'] ?? '' ?></span></div>
                <div><i class="fa fa-certificate"></i> <span class="label">Chứng chỉ:</span> <span class="value"><?= $data['certification'] ?? '' ?></span></div>
                <div><i class="fa fa-clock"></i> <span class="label">Kinh nghiệm:</span> <span class="badge"><?= $data['experience_years'] ?? '' ?> năm</span></div>
                <div><i class="fa fa-language"></i> <span class="label">Ngôn ngữ:</span> <span class="badge"><?= $data['languages'] ?? 'Không có' ?></span></div>
                <div><i class="fa fa-birthday-cake"></i> <span class="label">Ngày sinh:</span> <span class="value"><?= $data['date_of_birth'] ?? '' ?></span></div>
                <div class="notes"><i class="fa fa-sticky-note"></i> <span class="label">Ghi chú:</span> <span class="value"><?= $data['notes'] ?? '' ?></span></div>
            </div>
        </div>

    </div>
    <div class="mt-3 ">
        <a href="<?= BASE_URL ?>?action=list-guide" class="btn btn-nut"><i class="fa fa-arrow-left"></i> Quay lại</a>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>