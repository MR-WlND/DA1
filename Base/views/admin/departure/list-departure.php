<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <div class="header-wrapper">
        <div class="header-content">
            <div class="breadcrumb">Quản Lý Tour / Lịch Khởi Hành</div>
            <h2 class="page-title">Quản lý lịch khởi hành</h2>
            <p class="page-sub">Quản lý toàn bộ lịch khởi hành trong hệ thống admin</p>
        </div>
    </div>
    <div class="card">
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger" role="alert">
                <?= $_GET['error'] ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success" role="alert">
                Hành động được thực hiện thành công!
            </div>
        <?php endif; ?>
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
                            <a href="<?= BASE_URL ?>?action=departure-detail&id=<?= $value['departure_id'] ?>" class="btn view">
                                <i class="fas fa-eye"></i></a>
                            <a href="<?= BASE_URL ?>?action=update-departure&id=<?= $value['departure_id'] ?>" class="btn edit"><i class="fas fa-edit"></i></a>
                            <a href="<?= BASE_URL ?>?action=delete-departure&id=<?= $value['departure_id'] ?>"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa lịch khởi hành này không?')"
                                class="btn delete"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>