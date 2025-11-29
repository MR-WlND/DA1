<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Quản lý Hướng dẫn viên</h2>
    <div class="card">
        <div class="toph4">
            <h4>Danh sách Hướng dẫn viên</h4>
            <a href="<?= BASE_URL ?>?action=create-guide" class="btn btn-nut">+ Thêm Hướng dẫn viên</a>
        </div>
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
                    <?php if (!empty($listGuides)): ?>
                        <?php foreach ($listGuides as $g): ?>
                            <tr>
                                <td><?= $g['id'] ?></td>
                                <td>
                                    <?php if (!empty($g['photo_url'])): ?>
                                        <img src="<?= BASE_ASSETS_UPLOADS . $g['photo_url'] ?>" 
                                             alt="avatar" style="width:60px; height:60px; object-fit:cover; border-radius:50%; border:1px solid #000;">
                                    <?php endif; ?>
                                </td>
                                <td><?= $g['name'] ?></td>
                                <td><?= $g['email'] ?></td>
                                <td><?= $g['phone'] ?></td>
                                <td><?= ucfirst($g['category']) ?></td>
                                <td><?= $g['certification'] ?></td>
                                <td><?= $g['experience_years'] ?></td>
                                <td><?= !empty($g['languages']) ? $g['languages'] : 'Không có' ?></td>
                                <td>
                                    <a href="<?= BASE_URL ?>?action=detail-guide&id=<?= $g['id'] ?>" class="btn view">Xem</a>
                                    <a href="<?= BASE_URL ?>?action=update-guide&id=<?= $g['id'] ?>" class="btn edit">Quản lý</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" style="text-align:center;">Chưa có hướng dẫn viên nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
