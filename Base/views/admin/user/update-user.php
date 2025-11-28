<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Cập nhật thông tin người dùng :</h2>
    <div class="card">
        <div class="toph4">
            <h4><?= htmlspecialchars($user['name']) ?></h4>
        </div>

        <form action="<?= BASE_URL ?>?action=update-user&id=<?= $user['id'] ?>" method="post">
            <div class="form-group mb-3">
                <label for="name" class="form-label">Họ và tên:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="password" class="form-label">Mật khẩu mới (để trống nếu không đổi):</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu mới">
            </div>

            <div class="form-group mb-3">
                <label for="phone" class="form-label">Số điện thoại:</label>
                <input type="tel" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="role" class="form-label">Vai trò:</label>
                <select class="form-control form-select" id="role" name="role">
                    <option value="customer" <?= $user['role'] == 'customer' ? 'selected' : '' ?>>Customer</option>
                    <option value="guide" <?= $user['role'] == 'guide' ? 'selected' : '' ?>>Guide</option>
                    <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="<?= BASE_URL ?>?action=delete-user&id=<?= $user['id'] ?>" 
                   onclick="return confirm('Xóa người dùng này?')" 
                   class="btn btn-danger">Xóa</a>
            </div>
        </form>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
