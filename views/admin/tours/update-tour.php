<?php include PATH_VIEW . 'layout/header.php'; ?>
<div class="main">
    <h2>Cập nhật Tour</h2>
    <form action="<?= BASE_URL ?>?action=update-tour&id=<?= $data['id'] ?>" method="post" enctype="multipart/form-data">

        <div class="mb-3">
            <label for="">Tên tour</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($data['name']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="">Loại tour</label>
            <select name="tour_type" class="form-control" required>
                <option value="Nội địa" <?= $data['tour_type'] == 'Nội địa' ? 'selected' : '' ?>>Nội địa</option>
                <option value="Quốc tế" <?= $data['tour_type'] == 'Quốc tế' ? 'selected' : '' ?>>Quốc tế</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="">Danh mục</label>
            <select name="category_id" class="form-control">
                <?php foreach ($listCategory as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= $data['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="">Giá cơ bản</label>
            <input type="number" step="0.01" name="base_price" class="form-control" value="<?= $data['base_price'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="">Mô tả</label>
            <textarea name="description" class="form-control"><?= htmlspecialchars($data['description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="">Chính sách hủy</label>
            <textarea name="cancellation_policy" class="form-control"><?= htmlspecialchars($data['cancellation_policy']) ?></textarea>
        </div>

        <?php if ($data['image'] != ''): ?>
            <img src="<?= BASE_ASSETS_UPLOADS . $data['image'] ?>" alt="" style="width:100px;">
        <?php endif; ?>
        <div class="mb-3">
            <label for="">Ảnh</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label for="">Nguồn tour</label>
            <select name="tour_origin" class="form-control">
                <option value="Catalog" <?= $data['tour_origin'] == 'Catalog' ? 'selected' : '' ?>>Catalog</option>
                <option value="Custom" <?= $data['tour_origin'] == 'Custom' ? 'selected' : '' ?>>Custom</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật Tour</button>
    </form>
</div>
<?php include PATH_VIEW . 'layout/footer.php'; ?>