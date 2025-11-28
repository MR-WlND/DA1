<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Quản lý Hướng dẫn viên</h2>
    <a href="<?= BASE_URL ?>?action=create-guide" class="btn btn-nut">+ Thêm Hướng dẫn viên</a>

    <section class="mt-4">
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
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listGuides as $g): ?>
                    <tr>
                        <td><?= $g['id'] ?></td>
                        <td>
                            <?php if ($g['photo_url'] != ""): ?>
                                <img src="<?= BASE_ASSETS_UPLOADS . $g['photo_url'] ?>" alt="avatar"  style="width:60px; height:60px; object-fit:cover; border-radius:50%; border:1px solid #000;">
                            <?php endif ?>
                        </td>
                        <td><?= htmlspecialchars($g['name']) ?></td>
                        <td><?= htmlspecialchars($g['email']) ?></td>
                        <td><?= htmlspecialchars($g['phone']) ?></td>
                        <td><?= htmlspecialchars(ucfirst($g['category'])) ?></td>
                        <td><?= htmlspecialchars($g['certification']) ?></td>
                        <td><?= htmlspecialchars($g['experience_years']) ?></td>
                        <td><?= !empty($g['languages']) ? htmlspecialchars($g['languages']) : 'Không có' ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>?action=detail-guide&id=<?= $g['id'] ?>" class="btn view">Xem</a>
                            <a href="<?= BASE_URL ?>?action=update-guide&id=<?= $g['id'] ?>" class="btn edit">Sửa</a>
                            <a href="<?= BASE_URL ?>?action=delete-guide&id=<?= $g['id'] ?>"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa hướng dẫn viên này không?')"
                                class="btn delete">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($listGuides)): ?>
                    <tr>
                        <td colspan="10" style="text-align:center;">Chưa có hướng dẫn viên nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</div>
<?php include PATH_VIEW . 'layout/footer.php'; ?>