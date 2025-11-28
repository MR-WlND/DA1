<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Quản lý điểm đến</h2>
    <a href="<?= BASE_URL ?>?action=create-destination" class="btn btn-nut">+ Thêm điểm đến</a>

    <section class="mt-4">
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
                            <a href="<?= BASE_URL ?>?action=update-destination&id=<?= $dest['id'] ?>" class="btn edit">Sửa</a>
                            <a href="<?= BASE_URL ?>?action=delete-destination&id=<?= $dest['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa điểm đến này không?')" class="btn view">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </section>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
