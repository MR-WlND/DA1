<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Cập nhật thông tin người dùng: <?= $user['name'] ?></h2>

    <form action="<?= BASE_URL ?>?action=update-user&id=<?= $user['id'] ?>" method="post">
        <div class="form-group">
            <label for="name" class="form-label">Họ và tên:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $user['name'] ?>" required>
        </div>
        <div class="form-group">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?>" required>
        </div>
        <div class="form-group">
            <label for="password" class="form-label">Mật khẩu mới (để trống nếu không đổi):</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu mới">
        </div>
        <div class="form-group">
            <label for="phone" class="form-label">Số điện thoại:</label>
            <input type="tel" class="form-control" id="phone" name="phone" value="<?= $user['phone'] ?>" required>
        </div>
        <div class="form-group">
            <label for="role" class="form-label">Vai trò:</label>
            <select class="form-control form-select" id="role" name="role">
                <option value="customer" <?= $user['role'] == 'customer' ? 'selected' : '' ?>>Customer</option>
                <option value="guide" <?= $user['role'] == 'guide' ? 'selected' : '' ?>>Guide</option>
                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>

        <!-- Các trường dành riêng cho Hướng dẫn viên -->
        <div class="form-group">
            <label for="hdv_experience" class="form-label">Kinh nghiệm (năm):</label>
            <input type="number" class="form-control" id="hdv_experience" name="hdv_experience" value="<?= $user['hdv_experience'] ?? '' ?>">
        </div>
        <div class="form-group">
            <label for="hdv_languages" class="form-label">Ngôn ngữ:</label>
            <input type="text" class="form-control" id="hdv_languages" name="hdv_languages" value="<?= $user['hdv_languages'] ?? '' ?>">
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="<?= BASE_URL ?>?action=list-user" class="btn btn-danger">Quay lại</a>
    </form>
</div>
<?php include PATH_VIEW . 'layout/footer.php'; ?>