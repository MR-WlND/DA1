<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <div class="container-fluid">
        <h2 class="mb-4">Cập nhật HDV: <?= htmlspecialchars($guide['name']) ?></h2>

        <form action="<?= BASE_URL ?>?action=update-guide&id=<?= $guide['id'] ?>" method="post" enctype="multipart/form-data">

            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-primary border-bottom pb-2">1. Thông tin tài khoản</h4>

                    <div class="form-group mt-3">
                        <label for="name" class="form-label">Tên HDV <span class="text-danger">*</span>:</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="<?= htmlspecialchars($guide['name']) ?>" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span>:</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="<?= htmlspecialchars($guide['email']) ?>" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span>:</label>
                        <input type="text" class="form-control" id="phone" name="phone"
                            value="<?= htmlspecialchars($guide['phone']) ?>" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="password" class="form-label">Mật khẩu mới (Để trống nếu không đổi):</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Ảnh đại diện hiện tại:</label><br>
                        <?php if (!empty($guide['photo_url'])): ?>
                            <img src="<?= BASE_URL . $guide['photo_url'] ?>" width="100" style="border-radius:10px; border: 1px solid #ddd; padding: 2px;">
                        <?php else: ?>
                            <span class="text-muted">Chưa có ảnh</span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group mt-2">
                        <label for="photo_url" class="form-label">Chọn ảnh mới (nếu muốn thay):</label>
                        <input type="file" class="form-control" id="photo_url" name="photo_url">
                    </div>
                </div>

                <div class="col-md-6">
                    <h4 class="text-success border-bottom pb-2">2. Hồ sơ chuyên môn</h4>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Phân loại:</label>
                                <select class="form-control form-select" name="category">
                                    <option value="domestic" <?= ($guide['category'] ?? '') == 'domestic' ? 'selected' : '' ?>>Nội địa</option>
                                    <option value="international" <?= ($guide['category'] ?? '') == 'international' ? 'selected' : '' ?>>Quốc tế</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Nhóm chuyên môn:</label>
                                <select class="form-control form-select" name="specialty_group">
                                    <option value="standard" <?= ($guide['specialty_group'] ?? '') == 'standard' ? 'selected' : '' ?>>Tiêu chuẩn</option>
                                    <option value="vip" <?= ($guide['specialty_group'] ?? '') == 'vip' ? 'selected' : '' ?>>VIP</option>
                                    <option value="corporate" <?= ($guide['specialty_group'] ?? '') == 'corporate' ? 'selected' : '' ?>>Doanh nghiệp</option>
                                    <option value="leisure" <?= ($guide['specialty_group'] ?? '') == 'leisure' ? 'selected' : '' ?>>Nghỉ dưỡng</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Tuyến điểm sở trường:</label>
                        <input type="text" class="form-control" name="specialty_route"
                            value="<?= htmlspecialchars($guide['specialty_route'] ?? '') ?>">
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="form-label">Ngôn ngữ thành thạo:</label>
                                <input type="text" class="form-control" name="languages"
                                    value="<?= htmlspecialchars($guide['languages'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Kinh nghiệm (năm):</label>
                                <input type="number" class="form-control" name="experience_years" min="0"
                                    value="<?= htmlspecialchars($guide['experience_years'] ?? '0') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Ngày sinh:</label>
                        <input type="date" class="form-control" name="date_of_birth"
                            value="<?= htmlspecialchars($guide['date_of_birth'] ?? '') ?>">
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <h4 class="text-info border-bottom pb-2">3. Thông tin bổ sung</h4>
                </div>

                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label class="form-label">Chứng chỉ / Bằng cấp:</label>
                        <textarea class="form-control" name="certification" rows="3"><?= htmlspecialchars($guide['certification'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label class="form-label">Tình trạng sức khỏe:</label>
                        <textarea class="form-control" name="health_status" rows="3"><?= htmlspecialchars($guide['health_status'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="form-group">
                        <label class="form-label">Ghi chú khác:</label>
                        <textarea class="form-control" name="notes" rows="2"><?= htmlspecialchars($guide['notes'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <div class="mt-4 mb-5">
                <button type="submit" class="btn btn-nut btn-lg">Cập nhật</button>
                <a href="<?= BASE_URL ?>?action=list-guide" class="btn btn-danger btn-lg ms-2">Quay lại</a>
            </div>

        </form>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>