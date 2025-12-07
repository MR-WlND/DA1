<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <div class="header-wrapper">
        <div class="header-content">
            <div class="breadcrumb">Quản Lý Khác Sạn & NCC / Quản Lý Khác Sạn</div>
            <h2 class="page-title">Quản Lý Khác Sạn</h2>
            <p class="page-sub">Quản lý toàn bộ khách sạn trong hệ thống admin</p>
        </div>
    </div>
    <div class="card">
        <div class="toph4">
            <h4>Danh sách Khách sạn</h4>
            <a href="<?= BASE_URL ?>?action=create-hotel" class="btn btn-nut">+ Thêm Khách sạn</a>
        </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên khách sạn</th>
                        <th>Địa chỉ</th>
                        <th>Điểm đến</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($listHotel)): ?>
                        <?php foreach ($listHotel as $hotel): ?>
                            <tr>
                                <td><?= $hotel['id'] ?></td>
                                <td><?= $hotel['name'] ?></td>
                                <td><?= $hotel['address'] ?></td>
                                <td><?= $hotel['destination_name'] ?></td>
                                <td>
                                    <a href="<?= BASE_URL ?>?action=update-hotel&id=<?= $hotel['id'] ?>" class="btn edit"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align:center;">Chưa có khách sạn nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
