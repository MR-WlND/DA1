<?php include_once __DIR__ . '/../layout/header.php'; ?>

<h2>Danh sách Booking</h2>

<a href="/booking/create" class="btn">+ Tạo Booking</a>

<table border="1" width="100%" cellpadding="10">
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Room</th>
            <th>Ngày bắt đầu</th>
            <th>Ngày kết thúc</th>
            <th>Tổng tiền</th>
            <th>Hành động</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($bookings as $b): ?>
            <tr>
                <td><?= $b['id'] ?></td>
                <td><?= $b['user_name'] ?></td>
                <td><?= $b['room_name'] ?></td>
                <td><?= $b['start_date'] ?></td>
                <td><?= $b['end_date'] ?></td>
                <td><?= number_format($b['total_price']) ?> đ</td>

                <td>
                    <a href="/booking/edit/<?= $b['id'] ?>">Sửa</a> |
                    <a onclick="return confirm('Xóa booking này?')" href="/booking/delete/<?= $b['id'] ?>">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>
