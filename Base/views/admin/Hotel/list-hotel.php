<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Quản lý Khách sạn</h2>
    <div class="card">
        <div class="toph4">
            <h4>Danh sách Khách sạn</h4>
            <a href="<?= BASE_URL ?>?action=create-hotel" class="btn btn-nut">+ Thêm Khách sạn</a>
        </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên khách sạn</th>
                        <th>Địa chỉ</th>
                        <th>Điểm đến</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($listHotel)): ?>
                        <?php foreach ($listHotel as $hotel): ?>
                            <tr>
                                <td><?= $hotel['id'] ?></td>
                                <td><?= htmlspecialchars($hotel['name']) ?></td>
                                <td><?= htmlspecialchars($hotel['address']) ?></td>
                                <td><?= htmlspecialchars($hotel['destination_name']) ?></td>
                                <td>
                                    <a href="<?= BASE_URL ?>?action=update-hotel&id=<?= $hotel['id'] ?>" class="btn-quanly">Quản lý</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align:center;">Chưa có khách sạn nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
