<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Thêm danh mục mới :</h2>
    <div class="card">
        <div class="toph4">
            <h4>Thông tin danh mục</h4>
        </div>

        <form action="<?= BASE_URL ?>?action=create-category" method="post" enctype="multipart/form-data">
            <div class="form-group mb-3">
                <label for="name" class="form-label">Tên danh mục:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên danh mục" required>
            </div>

            <div class="form-group mb-3">
                <label for="description" class="form-label">Mô tả:</label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Nhập mô tả cho danh mục"></textarea>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-nut">Thêm mới</button>
                <a href="<?= BASE_URL ?>?action=list-category" class="btn btn-danger">Quay lại</a>
            </div>
        </form>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
