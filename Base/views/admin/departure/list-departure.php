<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Quản lý lịch khởi hành</h2>
    <div class="card">
        <div class="toph4">
            <h4>Danh sách lịch khởi hành</h4>
            <a href="<?= BASE_URL ?>?action=create-departure" class="btn btn-nut">+ Thêm lịch khởi hành</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tour</th>
                    <th>Ngày đi</th>
                    <th>Ngày về</th>
                    <th>Giá hiện tại</th>
                    <th>Chỗ trống</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listDeparture as $value): ?>
                <tr>
                    <td><?= $value['departure_id'] ?></td>
                    <td><?= $value['tour_name'] ?></td>
                    <td><?= $value['start_date'] ?></td>
                    <td><?= $value['end_date'] ?></td>
                    <td><?= number_format($value['current_price']) ?></td>
                    <td><?= $value['max_slots'] ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>?action=list-departure-by-tour&id=<?= $value['departure_id'] ?>" class="btn view">Xem</a>
                        <a href="<?= BASE_URL ?>?action=update-departure&id=<?= $value['departure_id'] ?>" class="btn edit">Quản lý</a>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
