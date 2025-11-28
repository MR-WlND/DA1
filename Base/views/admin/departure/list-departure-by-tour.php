<h2>Lịch khởi hành của Tour</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
            <th>Ngày bắt đầu</th>
            <th>Ngày kết thúc</th>
            <th>Giá hiện tại</th>
            <th>Số chỗ còn trống</th>
            <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($listDepartures as $dep): ?>
            <tr>
            <td><?= $dep['id'] ?></td>
            <td><?= $dep['start_date'] ?></td>
            <td><?= $dep['end_date'] ?></td>
            <td><?= number_format($dep['current_price'],0,',','.') ?>₫</td>
            <td><?= $dep['available_slots'] ?></td>
            <td>
                <a href="<?= BASE_URL ?>?action=update-departure&id=<?= $dep['id'] ?>" class="btn edit">Sửa</a>
                <a href="<?= BASE_URL ?>?action=delete-departure&id=<?= $dep['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?')" class="btn view">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
