<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Chi tiết Tour</h2>
    <a href="<?= BASE_URL ?>?action=list-tour" class="btn btn-nut">Quay lại</a>

    <table class="table mt-3">
        <tr>
            <th>ID</th>
            <td><?= $tour['id'] ?></td>
        </tr>
        <tr>
            <th>Tên tour</th>
            <td><?= htmlspecialchars($tour['name']) ?></td>
        </tr>
        <tr>
            <th>Loại tour</th>
            <td><?= $tour['tour_type'] ?></td>
        </tr>
        <tr>
            <th>Giá cơ bản</th>
            <td><?= number_format($tour['base_price'], 0, ',', '.') ?>₫</td>
        </tr>
        <tr>
            <th>Danh mục</th>
            <td><?= htmlspecialchars($tour['category_name']) ?></td>
        </tr>
        <tr>
            <th>Ảnh</th>
            <td>
                <?php if ($tour['image'] != ""): ?>
                    <img src="<?= BASE_ASSETS_UPLOADS . $tour['image'] ?>" alt="" style="width:200px;">
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th>Mô tả</th>
            <td><?= nl2br(htmlspecialchars($tour['description'])) ?></td>
        </tr>
        <tr>
            <th>Chính sách hủy</th>
            <td><?= nl2br(htmlspecialchars($tour['cancellation_policy'])) ?></td>
        </tr>
        <tr>
            <th>Loại xuất phát</th>
            <td><?= $tour['tour_origin'] ?></td>
        </tr>
        <tr>
            <th>Ngày tạo</th>
            <td><?= date('d/m/Y H:i', strtotime($tour['created_at'])) ?></td>
        </tr>
    </table>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
