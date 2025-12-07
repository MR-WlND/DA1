<?php include 'views/layout/header.php'; ?>

<div class="main">
    <div class="header-wrapper">
        <div class="header-content">
            <div class="breadcrumb">Quản Lý User / Quản Lý Admin</div>
            <h2 class="page-title">Quản Lý Admin</h2>
            <p class="page-sub">Quản lý toàn bộ admin trong hệ thống admin</p>
        </div>
    </div>
    <div class="card">
        <div class="toph4">
            <h4>Danh sách Admin</h4>
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
                            <a href="<?= BASE_URL ?>?action=detail-user&id=<?= $user['id'] ?>" class="btn edit"><i class="fas fa-edit"></i></a>
                    </tr>
                <?php endif; endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>
