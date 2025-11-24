<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Danh sách Booking</h2>

    <a href="?action=booking-create" class="btn btn-primary mb-3">+ Thêm Booking</a>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Tour</th>
                <th>Số lượng</th>
                <th>Tổng tiền</th>
                <th>Ngày đặt</th>
                <th>Trạng thái</th>
                <th width="140">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $item): ?>
                <tr>
                    <td><?= $item['id'] ?></td>
                    <td><?= $item['customer_name'] ?></td>
                    <td><?= $item['tour_name'] ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= number_format($item['total_price']) ?>đ</td>
                    <td><?= $item['created_at'] ?></td>
                    <td>
                        <?php if ($item['status'] == 1): ?>
                            <span class="badge bg-success">Đã duyệt</span>
                        <?php else: ?>
                            <span class="badge bg-warning">Chờ duyệt</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="?action=booking-edit&id=<?= $item['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                        <a onclick="return confirm('Xóa booking này?')"
                            href="?action=booking-delete&id=<?= $item['id'] ?>"
                            class="btn btn-sm btn-danger">
                            Xóa
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>