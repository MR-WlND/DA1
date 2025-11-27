<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Cập nhật Hướng dẫn viên</h2>

    <form action="<?= BASE_URL ?>?action=update-guide&id=<?= $data['id'] ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Tên:</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($data['name']) ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($data['email']) ?>" required>
        </div>

        <div class="form-group">
            <label for="phone">Điện thoại:</label>
            <input type="text" name="phone" id="phone" class="form-control" value="<?= htmlspecialchars($data['phone']) ?>" required>
        </div>

        <div class="form-group">
            <label for="category">Loại:</label>
            <select name="category" id="category" class="form-control" required>
                <option value="domestic" <?= $data['category'] == 'domestic' ? 'selected' : '' ?>>Domestic</option>
                <option value="international" <?= $data['category'] == 'international' ? 'selected' : '' ?>>International</option>
            </select>
        </div>

        <div class="form-group">
            <label for="specialty_route">Tuyến chuyên môn:</label>
            <input type="text" name="specialty_route" id="specialty_route" class="form-control" value="<?= htmlspecialchars($data['specialty_route']) ?>">
        </div>

        <div class="form-group">
            <label for="specialty_group">Nhóm chuyên môn:</label>
            <select name="specialty_group" id="specialty_group" class="form-control">
                <?php
                $groups = ['standard', 'vip', 'corporate', 'leisure'];
                foreach ($groups as $g): ?>
                    <option value="<?= $g ?>" <?= $data['specialty_group'] == $g ? 'selected' : '' ?>><?= ucfirst($g) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="certification">Chứng chỉ:</label>
            <input type="text" name="certification" id="certification" class="form-control" value="<?= htmlspecialchars($data['certification']) ?>">
        </div>

        <div class="form-group">
            <label for="health_status">Tình trạng sức khỏe:</label>
            <input type="text" name="health_status" id="health_status" class="form-control" value="<?= htmlspecialchars($data['health_status']) ?>">
        </div>

        <div class="form-group">
            <label for="experience_years">Kinh nghiệm (năm):</label>
            <input type="number" name="experience_years" id="experience_years" class="form-control" min="0" value="<?= htmlspecialchars($data['experience_years']) ?>">
        </div>

        <div class="form-group">
            <label for="languages">Ngôn ngữ:</label>
            <input type="text" name="languages" id="languages" class="form-control" value="<?= htmlspecialchars($data['languages']) ?>">
        </div>

        <div class="form-group">
            <label for="date_of_birth">Ngày sinh:</label>
            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="<?= htmlspecialchars($data['date_of_birth']) ?>">
        </div>

        <div class="form-group">
            <label for="notes">Ghi chú:</label>
            <textarea name="text" id="notes" class="form-control" rows="3"><?= $data['notes'] ?></textarea>
        </div>

        <div class="form-group">
            <label>Ảnh hiện tại:</label><br>
            <?php if ($data['photo_url'] != ""): ?>
                <img src="<?= BASE_ASSETS_UPLOADS . $data['photo_url'] ?>" alt="avatar" style="width: 100px;">
            <?php endif ?>
        </div>

        <div class="form-group">
            <label for="photo_url">Thay đổi ảnh:</label>
            <input type="file" name="photo_url" id="photo_url" class="form-control">
        </div>

        <button type="submit" class="btn btn-nut mt-2">Cập nhật Hướng dẫn viên</button>
        <a href="<?= BASE_URL ?>?action=list-guide" class="btn btn-secondary mt-2">Quay lại</a>
    </form>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>