<?php include "./views/main.php"; ?>

<div class="container mt-4">
    <h2 class="mb-3">Quản lý Booking</h2>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Tour</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $b): ?>
                <tr>
                    <td><?= $b['id']; ?></td>
                    <td><?= $b['user_name']; ?></td>
                    <td><?= $b['tour_title']; ?></td>
                    <td><?= $b['booking_date']; ?></td>
                    <td><?= number_format($b['total_price']); ?>₫</td>
                    <td>
                        <span class="badge bg-<?=
                            $b['status'] == 'confirmed' ? 'success' :
                            ($b['status'] == 'canceled' ? 'danger' :
                            'warning')
                        ?>">
                            <?= $b['status']; ?>
                        </span>
                    </td>
                    <td>
                        <form action="index.php?route=admin/bookings/update" method="POST" class="d-flex">
                            <input type="hidden" name="id" value="<?= $b['id']; ?>">
                            <select name="status" class="form-select form-select-sm me-2">
                                <option value="pending">Đang chờ</option>
                                <option value="confirmed">Đã xác nhận</option>
                                <option value="canceled">Đã hủy</option>
                            </select>
                            <button class="btn btn-sm btn-primary">OK</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
