<?php include 'views/layout/header.php'; ?>

<div class="main">
    <h2>Thêm người dùng mới :</h2>
    <div class="card">
        <div class="toph4">
            <h4>Thông tin người dùng</h4>
        </div>

        <form action="<?= BASE_URL ?>?action=create-user" method="post">
            <div class="form-group mb-3">
                <label for="name" class="form-label">Họ và tên:</label>
                <input type="text" class="form-control" id="name" placeholder="Nhập họ tên" name="name" required>
            </div>

            <div class="form-group mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Nhập email" name="email" required>
            </div>

            <div class="form-group mb-3">
                <label for="password" class="form-label">Mật khẩu:</label>
                <input type="password" class="form-control" id="password" placeholder="Nhập mật khẩu" name="password" required>
            </div>

            <div class="form-group mb-3">
                <label for="phone" class="form-label">Số điện thoại:</label>
                <input type="tel" class="form-control" id="phone" placeholder="Nhập số điện thoại" name="phone" required>
            </div>

            <div class="form-group mb-3">
                <label for="role" class="form-label">Vai trò:</label>
                <select class="form-control form-select" id="role" name="role">
                    <option class="enable-rounded" value="customer">Customer</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Thêm mới</button>
                <a href="<?= BASE_URL ?>?action=list-user" class="btn btn-danger">Quay lại</a>
            </div>
        </form>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>
