<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Quản lý Khách sạn</h2>
    <a href="<?= BASE_URL ?>?action=create-hotel" class="btn btn-nut">+ Thêm Khách sạn</a>

    <section class="mt-4">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên khách sạn</th>
                    <th>Địa chỉ</th>
                    <th>Điểm đến</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listHotel as $hotel): ?>
                    <tr>
                        <td><?= $hotel['id'] ?></td>
                        <td><?= htmlspecialchars($hotel['name']) ?></td>
                        <td><?= htmlspecialchars($hotel['address']) ?></td>
                        <td><?= htmlspecialchars($hotel['destination_name']) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>?action=update-hotel&id=<?= $hotel['id'] ?>" class="btn edit">Sửa</a>
                            <a href="<?= BASE_URL ?>?action=delete-hotel&id=<?= $hotel['id'] ?>" 
                               onclick="return confirm('Bạn có chắc chắn muốn xóa khách sạn này không?')" 
                               class="btn view">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </section>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
