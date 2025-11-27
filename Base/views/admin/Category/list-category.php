<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Quản lý danh mục</h2>
    <a href="<?= BASE_URL ?>?action=create-category" class="btn btn-nut">+ Thêm danh mục</a>
<section class="mt-4">
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
                        <a href="<?= BASE_URL ?>?action=update-category&id=<?= $category['id'] ?>" class="btn edit">Sửa</a>
                        <a href="<?= BASE_URL ?>?action=delete-category&id=<?= $category['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?')" class="btn view">Xóa</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    </section>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
