<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Cập nhật danh mục :</h2>
    <div class="card">
        <div class="toph4">
            <h4><?= $category['name'] ?? 'Danh mục' ?></h4>
        </div>

        <form action="<?= BASE_URL ?>?action=update-category&id=<?= $category['id'] ?>" method="post" enctype="multipart/form-data">
            <div class="form-group mb-3">
                <label for="name" class="form-label">Tên danh mục:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $category['name'] ?? '' ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="description" class="form-label">Mô tả:</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?= $category['description'] ?? '' ?></textarea>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="<?= BASE_URL ?>?action=delete-category&id=<?= $category['id'] ?>" 
                   onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?')" 
                   class="btn btn-danger">Xóa</a>
            </div>
        </form>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
