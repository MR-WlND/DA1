<?php include 'views/layout/header.php'; ?>

<?php $action = $_GET['action'] ?? 'dashboard'; ?>


<div class="main">
    <h2>Quản lý User</h2>
    <a href="<?= BASE_URL ?>?action=create-user" class="btn btn-nut">+ Add New User</a>

    <section class="role-section admin-list">
        <h3>Danh sách Quản trị viên </h3>
        <table class="table">
            <thead class="table">
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
                <?php
                // Lọc Admin trực tiếp trong View (Cách 2)
                foreach ($listUser as $user):
                    if ($user['role'] == 'admin'):
                ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= $user['name'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['phone'] ?></td>
                            <td><span style="color: red; font-weight: bold;"><?= $user['role'] ?></span></td>
                            <td>
                                <a href="<?= BASE_URL ?>?action=update-user&id=<?= $user['id'] ?>" class="btn view">Sửa</a>
                                <a href="<?= BASE_URL ?>?action=delete-user&id=<?= $user['id'] ?>" onclick="return confirm('Xóa Admin?')" class="btn delete">Xóa</a>
                                <a href="<?= BASE_URL ?>?action=detail-user&id=<?= $user['id'] ?>" class="btn edit">Xem</a>
                            </td>
                        </tr>
                <?php
                    endif;
                endforeach;
                ?>
            </tbody>
        </table>
    </section>

    <hr>

    <section class="role-section guide-list">
        <h3>Danh sách Hướng dẫn viên </h3>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Kinh nghiệm (Năm)</th>
                    <th>Ngôn ngữ</th>
                    <th>Vai trò</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($listUser as $user):
                    if ($user['role'] == 'guide'):
                ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= $user['name'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['hdv_experience'] ?? 'N/A' ?></td>
                            <td><?= $user['hdv_languages'] ?? 'Không rõ' ?></td>
                            <td><span style="color: blue;"><?= $user['role'] ?></span></td>
                            <td>
                                <a href="<?= BASE_URL ?>?action=update-user&id=<?= $user['id'] ?>" class="btn view">Sửa</a>
                                <a href="<?= BASE_URL ?>?action=delete-user&id=<?= $user['id'] ?>" onclick="return confirm('Xóa Admin?')" class="btn delete">Xóa</a>
                                <a href="<?= BASE_URL ?>?action=detail-user&id=<?= $user['id'] ?>" class="btn edit">Xem</a>
                            </td>
                        </tr>
                <?php
                    endif;
                endforeach;
                ?>
            </tbody>
        </table>
    </section>

    <hr>

    <section class="role-section customer-list">
        <h3>Danh sách Khách hàng </h3>
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
                <?php
                foreach ($listUser as $user):
                    if ($user['role'] == 'customer'):
                ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= $user['name'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['phone'] ?></td>
                            <td><?= $user['role'] ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>?action=update-user&id=<?= $user['id'] ?>" class="btn view">Sửa</a>
                                <a href="<?= BASE_URL ?>?action=delete-user&id=<?= $user['id'] ?>" onclick="return confirm('Xóa Admin?')" class="btn delete">Xóa</a>
                                <a href="<?= BASE_URL ?>?action=detail-user&id=<?= $user['id'] ?>" class="btn edit">Xem</a>
                            </td>
                        </tr>
                <?php
                    endif;
                endforeach;
                ?>
            </tbody>
        </table>
    </section>
</div>

<?php include 'views/layout/footer.php'; ?>