<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Quản lý điểm đến</h2>
    <div class="card">
        <div class="toph4">
            <h4>Danh sách điểm đến</h4>
            <a href="<?= BASE_URL ?>?action=create-destination" class="btn btn-nut">+ Thêm điểm đến</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên điểm đến</th>
                    <th>Quốc gia</th>
                    <th>Loại</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listDestination as $dest): ?>
                    <tr>
                        <td><?= $dest['id'] ?></td>
                        <td><?= $dest['name'] ?></td>
                        <td><?= $dest['country'] ?></td>
                        <td><?= $dest['type'] ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>?action=update-destination&id=<?= $dest['id'] ?>" class="btn edit">Quản lý</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
