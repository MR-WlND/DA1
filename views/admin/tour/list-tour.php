<?php include 'views/layout/header.php'; ?>

<div class="main">
    <h2>Quản lý Tours</h2>
    <a href="<?= BASE_URL ?>?action=create-tour" class="btn btn-nut">+ Add New Tour</a>

    <section class="tour-list mt-4">
        <table class="table ">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Tour</th>
                    <th>Loại Tour</th>
                    <th>Giá cơ bản</th>
                    <th>Điểm đến ID</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                    <?php foreach ($listTour as $tour): ?>
                        <tr>
                            <td><?= $tour['id'] ?></td>
                            <td><?= $tour['name'] ?></td>
                            <td><?= $tour['tour_type'] ?></td>
                            <td><?= $tour['base_price'], 0, ',', '.' ?> ₫</td>
                            <td><?= $tour['destination_id'] ?></td>
                            <td><?= date('d/m/Y', strtotime($tour['created_at'])) ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>?action=update-tour&id=<?= $tour['id'] ?>" class="btn view">Sửa</a>
                                <a href="<?= BASE_URL ?>?action=detail-tour&id=<?= $tour['id'] ?>" class="btn edit">Xem</a>
                                <a href="<?= BASE_URL ?>?action=delete-tour&id=<?= $tour['id'] ?>" onclick="return confirm('Bạn chắc chắn muốn xóa tour này?')" class="btn delete">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>

<?php include 'views/layout/footer.php'; ?>