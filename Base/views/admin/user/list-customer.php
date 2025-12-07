<?php include 'views/layout/header.php'; ?>

<div class="main">
    <div class="header-wrapper">
        <div class="header-content">
            <div class="breadcrumb">Quản Lý User / Quản Lý Customer</div>
            <h2 class="page-title">Quản Lý Customer</h2>
            <p class="page-sub">Quản lý toàn bộ Customer trong hệ thống admin</p>
        </div>
    </div>
    <div class="card">
        <div class="toph4">
            <h4>Danh sách Customer</h4>
            <a href="<?= BASE_URL ?>?action=create-user" class="btn btn-nut">+ Thêm User</a>
        </div>

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
                            <a href="<?= BASE_URL ?>?action=update-user&id=<?= $user['id'] ?>" class="btn edit"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                <?php endif; endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>
