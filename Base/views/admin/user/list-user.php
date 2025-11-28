<?php include 'views/layout/header.php'; ?>

<div class="main">
    <h2>Quản lý User</h2>
    <div class="card">
        <div class="toph4">
            <h4>Danh sách User</h4>
            <a href="<?= BASE_URL ?>?action=create-user" class="btn btn-nut">+ Thêm User</a>
        </div>

        <!-- Quản trị viên -->
        <h5 class="mt-3">Danh sách Quản trị viên</h5>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Vai trò</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php $index = 1; foreach ($listUser as $user): if ($user['role'] == 'admin'): ?>
                    <tr>
                        <td><?= $index++ ?></td>
                        <td><?= $user['name'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['phone'] ?></td>
                        <td><span class="text-danger fw-bold"><?= $user['role'] ?></span></td>
                        <td>
                            <a href="<?= BASE_URL ?>?action=detail-user&id=<?= $user['id'] ?>" class="btn-quanly">Quản lý</a>
                    </tr>
                <?php endif; endforeach; ?>
            </tbody>
        </table>

        <hr>

        <!-- Khách hàng -->
        <h5 class="mt-3">Danh sách Khách hàng</h5>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Vai trò</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php $index = 1; foreach ($listUser as $user): if ($user['role'] == 'customer'): ?>
                    <tr>
                        <td><?= $index++ ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['phone']) ?></td>
                        <td><?= $user['role'] ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>?action=update-user&id=<?= $user['id'] ?>" class="btn-quanly">Quản lý</a>
                        </td>
                    </tr>
                <?php endif; endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>
