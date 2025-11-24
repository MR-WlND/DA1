<?php include PATH_VIEW . 'layout/header.php'; ?>
<div class="main">
    <h2>Quản lý danh mục</h2>
    <a href="<?= BASE_URL ?>?action=create-category" class="btn btn-nut">+ Add New Category</a>

    <section class="category-list mt-4">
        <table class="table ">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Mô tả</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
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
                            <a href="<?= BASE_URL ?>?action=update-category&id=<?= $category['id'] ?>" class="btn view">Sửa</a>
                            <a href="<?= BASE_URL ?>?action=delete-category&id=<?= $category['id'] ?>" onclick="return confirm('Bạn chắc chắn muốn xóa danh mục này?')" class="btn delete">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>
<?php include PATH_VIEW . 'layout/footer.php'; ?>