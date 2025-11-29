<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Quản lý Tour</h2>

    <div class="card">
        <div class="toph4">
            <h4>Danh sách Tour</h4>
            <a href="<?= BASE_URL ?>?action=create-tour" class="btn btn-nut">+ Thêm tour mới</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Hình ảnh</th>
                    <th>Tên tour</th>
                    <th>Loại tour</th>
                    <th>Loại hình Bán</th>
                    <th>Danh mục</th>
                    <th>Giá gốc</th>
                    <th>Số lịch khởi hành</th>
                    <th>Lộ trình</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($listTours as $tour): ?>
                    <tr>
                        <td><?= $tour['id'] ?></td>
                        <td>
                            <?php if (!empty($tour['main_image_path'])): ?>
                                <img src="<?= BASE_ASSETS_UPLOADS . $tour['main_image_path'] ?>"
                                    alt="img" style="width:100px; height:60px; object-fit:cover; border-radius:5px; border:none;">
                            <?php endif; ?>
                        </td>
                        <td><?= $tour['name'] ?></td>
                        <td><?= $tour['tour_type'] ?></td>
                        <td><?= $tour['tour_origin'] ?? '' ?></td>
                        <td><?= $tour['category_name'] ?? 'Không có' ?></td>
                        <td><?= number_format($tour['base_price']) ?> đ</td>
                        <td>
                            <?= $tour['total_departures_count'] ?>
                            <?php if ($tour['total_departures_count'] > 0): ?>
                                <a href="<?= BASE_URL ?>?action=list-departure&tour_id=<?= $tour['id'] ?>"
                                    class="btn badge bg-primary text-white"
                                    title="Quản lý tồn kho">
                                    Chi tiết
                                </a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($tour['destination_route_summary'])): ?>
                                <?= $tour['destination_route_summary'] ?>
                            <?php else: ?>
                                <i>Chưa có lộ trình</i>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>?action=update-tour&id=<?= $tour['id'] ?>" class="btn edit">Sửa</a>
                            <a href="<?= BASE_URL ?>?action=detail-tour&id=<?= $tour['id'] ?>" class="btn view">Xem</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>