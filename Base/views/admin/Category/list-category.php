<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Quản lý danh mục</h2>
    <div class="card">
        <div class="toph4">
            <h4>Danh sách danh mục tour<h4>
            <a href="<?= BASE_URL ?>?action=create-category" class="btn btn-nut">+ Thêm danh mục</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Mô tả</th>
                    <th>Ngày tạo</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listCategory as $category): ?>
                    <tr>
                        <td><?= $category['id'] ?></td>
                        <td><?= $category['name'] ?></td>
                        <td><?= $category['description'] ?></td>
                        <td><?= date('d/m/Y', strtotime($category['created_at'])) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>?action=update-category&id=<?= $category['id'] ?>" class="btn edit">Quản lý</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>