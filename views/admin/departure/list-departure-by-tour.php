<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Danh sách hướng dẫn viên</h2>
    <a href="?action=create-guide" class="btn btn-nut">+ Thêm hướng dẫn viên</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ảnh</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Điện thoại</th>
                <th>Loại</th>
                <th>Chứng chỉ</th>
                <th>Năm KN</th>
                <th>Ngôn ngữ</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($guides as $g): ?>
            <tr>
                <td><?= $g['id'] ?></td>
                <td>
                    <?php 
                    $avatarPath = PATH_ASSETS_UPLOADS . '/avatar/' . ($g['photo_url'] ?? '');
                    if (!empty($g['photo_url']) && file_exists($avatarPath)): ?>
                        <img src="<?= BASE_URL . 'assets/uploads/avatar/' . $g['photo_url'] ?>" width="60" style="border-radius:6px;">
                    <?php else: ?>
                        <img src="<?= BASE_URL . 'assets/uploads/avatar/default.png' ?>" width="60" style="border-radius:6px;">
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($g['name']) ?></td>
                <td><?= htmlspecialchars($g['email']) ?></td>
                <td><?= htmlspecialchars($g['phone']) ?></td>
                <td><?= htmlspecialchars(ucfirst($g['category'])) ?></td>
                <td><?= htmlspecialchars($g['certification']) ?></td>
                <td><?= htmlspecialchars($g['experience_years']) ?></td>
                <td><?= !empty($g['languages']) ? htmlspecialchars($g['languages']) : 'Không có' ?></td>
                <td>
                    <a class="btn edit" href="?action=update-guide&id=<?= $g['id'] ?>">Sửa</a>
                    <a class="btn delete" onclick="return confirm('Chắc chắn xóa?')" href="?action=delete-guide&id=<?= $g['id'] ?>">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
