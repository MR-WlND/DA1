<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Cập nhật Hướng dẫn viên :</h2>
    <div class="card">
        <div class="toph4">
            <h4><?= $data['name'] ?></h4>
        </div>

        <form action="<?= BASE_URL ?>?action=update-guide&id=<?= $data['id'] ?>" method="post" enctype="multipart/form-data">
            <div class="form-group mb-3">
                <label for="name">Tên:</label>
                <input type="text" name="name" id="name" class="form-control" value="<?= $data['name'] ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= $data['email'] ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="password" class="form-label">Mật khẩu mới (để trống nếu không đổi):</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu mới">
            </div>

            <div class="form-group mb-3">
                <label for="phone">Điện thoại:</label>
                <input type="text" name="phone" id="phone" class="form-control" value="<?= $data['phone'] ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="category">Loại:</label>
                <select name="category" id="category" class="form-control" required>
                    <option value="domestic" <?= $data['category'] == 'domestic' ? 'selected' : '' ?>>Domestic</option>
                    <option value="international" <?= $data['category'] == 'international' ? 'selected' : '' ?>>International</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="specialty_route">Tuyến chuyên môn:</label>
                <input type="text" name="specialty_route" id="specialty_route" class="form-control" value="<?= $data['specialty_route'] ?>">
            </div>

            <div class="form-group mb-3">
                <label for="specialty_group">Nhóm chuyên môn:</label>
                <select name="specialty_group" id="specialty_group" class="form-control">
                    <?php
                    $groups = ['standard', 'vip', 'corporate', 'leisure'];
                    foreach ($groups as $g): ?>
                        <option value="<?= $g ?>" <?= $data['specialty_group'] == $g ? 'selected' : '' ?>><?= ucfirst($g) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="certification">Chứng chỉ:</label>
                <input type="text" name="certification" id="certification" class="form-control" value="<?= $data['certification'] ?>">
            </div>

            <div class="form-group mb-3">
                <label for="health_status">Tình trạng sức khỏe:</label>
                <input type="text" name="health_status" id="health_status" class="form-control" value="<?= $data['health_status'] ?>">
            </div>

            <div class="form-group mb-3">
                <label for="experience_years">Kinh nghiệm (năm):</label>
                <input type="number" name="experience_years" id="experience_years" class="form-control" min="0" value="<?= $data['experience_years'] ?>">
            </div>

            <div class="form-group mb-3">
                <label for="languages">Ngôn ngữ:</label>
                <input type="text" name="languages" id="languages" class="form-control" value="<?= $data['languages'] ?>">
            </div>

            <div class="form-group mb-3">
                <label for="date_of_birth">Ngày sinh:</label>
                <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="<?= $data['date_of_birth']?>">
            </div>

            <div class="form-group mb-3">
                <label for="notes">Ghi chú:</label>
                <textarea name="notes" id="notes" class="form-control" rows="3"><?= $data['notes'] ?></textarea>
            </div>

            <div class="form-group mb-3">
                <label>Ảnh hiện tại:</label><br>
                <?php if (!empty($data['photo_url'])): ?>
                    <img src="<?= BASE_ASSETS_UPLOADS . $data['photo_url'] ?>" alt="avatar" style="width: 100px;">
                <?php endif; ?>
            </div>

            <div class="form-group mb-3">
                <label for="photo_url">Thay đổi ảnh:</label>
                <input type="file" name="photo_url" id="photo_url" class="form-control">
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Cập nhật Hướng dẫn viên</button>
                <a href="<?= BASE_URL ?>?action=delete-guide&id=<?= $data['id'] ?>"
                   onclick="return confirm('Bạn có chắc chắn muốn xóa hướng dẫn viên này không?')"
                   class="btn btn-danger">Xóa</a>
            </div>
        </form>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
