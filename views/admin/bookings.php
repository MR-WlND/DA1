<?php include 'views/layout/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Danh sách Booking</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tour</th>
                <th>Tên khách</th>
                <th>SĐT</th>
                <th>Số lượng</th>
                <th>Ngày đặt</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $b): ?>
                <tr>
                    <td><?= $b['id'] ?></td>
                    <td><?= $b['tour_name'] ?></td>
                    <td><?= $b['customer_name'] ?></td>
                    <td><?= $b['phone'] ?></td>
                    <td><?= $b['quantity'] ?></td>
                    <td><?= $b['created_at'] ?></td>
                    <td>
                        <?php
                        $statusClass = '';
                        if ($b['status'] == 'approved') $statusClass = 'text-success';
                        elseif ($b['status'] == 'canceled') $statusClass = 'text-danger';
                        else $statusClass = 'text-warning';
                        ?>
                        <b class="<?= $statusClass ?>"><?= strtoupper($b['status']) ?></b>
                    </td>
                    <td>
                        <a href="index.php?action=booking/update&id=<?= $b['id'] ?>&status=approved" class="btn btn-sm btn-success">
                            Duyệt
                        </a>
                        <a href="index.php?action=booking/update&id=<?= $b['id'] ?>&status=canceled"
                            class="btn btn-sm btn-danger"
                            onclick="return confirm('Bạn có chắc muốn hủy booking này?');">
                            Hủy
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'views/layout/footer.php'; ?>
