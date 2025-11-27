<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Quản lý Tour</h2>
    <a href="<?= BASE_URL ?>?action=create-tour" class="btn btn-nut">+ Thêm Tour</a>

    <section class="mt-4">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên tour</th>
                    <th>Loại tour</th>
                    <th>Giá cơ bản</th>
                    <th>Danh mục</th>
                    <th>Điểm đến</th>
                    <th>Lịch khởi hành</th>
                    <th>Ảnh</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listTour as $tour): ?>
                    <tr>
                        <td><?= $tour['id'] ?></td>
                        <td><?= htmlspecialchars($tour['name']) ?></td>
                        <td><?= $tour['tour_type'] ?></td>
                        <td><?= number_format($tour['base_price'], 0, ',', '.') ?>₫</td>
                        <td><?= htmlspecialchars($tour['category_name']) ?></td>
                        <td>
                            <?php if (!empty($tour['destinations'])): ?>
                                <?php foreach ($tour['destinations'] as $dest): ?>
                                    <div><?= htmlspecialchars($dest['name']) ?></div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($tour['departures'])): ?>
                                <?php foreach ($tour['departures'] as $dep): ?>
                                    <div>
                                        <?= $dep['start_date'] ?> → <?= $dep['end_date'] ?> |
                                        Giá: <?= number_format($dep['current_price'],0,',','.') ?>₫ |
                                        Còn trống: <?= $dep['remaining_slots'] ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($tour['image'] != ""): ?>
                                <img src="<?= BASE_ASSETS_UPLOADS . $tour['image'] ?>" alt="avatar"  style="width:60px; height:60px; object-fit:cover; border-radius:50%; border:1px solid #000;">
                            <?php endif ?>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>?action=detail-tour&id=<?= $tour['id'] ?>" class="btn view">Xem</a> 
                            <a href="<?= BASE_URL ?>?action=update-tour&id=<?= $tour['id'] ?>" class="btn edit">Sửa</a>
                            <a href="<?= BASE_URL ?>?action=delete-tour&id=<?= $tour['id'] ?>" 
                               onclick="return confirm('Bạn có chắc chắn muốn xóa tour này không?')" 
                               class="btn delete">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </section>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
