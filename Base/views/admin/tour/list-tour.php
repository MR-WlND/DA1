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
                    <th>Hình ảnh</th>
                    <th>Điểm đến</th>
                    <th>Quốc gia</th>
                    <th>Loại Tour</th>
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
                        <td><?= number_format($tour['base_price'], 0, ',', '.') ?> ₫</td>
                        <td>
                            <?php if ($tour['image'] != ""): ?>
                                <img src="<?= BASE_ASSETS_UPLOADS . $tour['image'] ?>" alt="Tour Image" style="max-width: 100px;">
                            <?php endif ?>
                        </td>
                        <td><?= $tour['destination_name'] ?></td>
                        <td><?= $tour['destination_country'] ?></td>
                        <td><?= $tour['category_name'] ?></td>
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