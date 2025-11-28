<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Cập nhật Tour: <?= $tour['name'] ?></h2>

    <form action="<?= BASE_URL ?>?action=update-tour&id=<?= $tour['id'] ?>" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="name" class="form-label">Tên Tour:</label>
            <input type="text" class="form-control" id="name" name="name"
                value="<?= $tour['name'] ?>" required>
        </div>

        <div class="form-group">
            <label for="tour_type" class="form-label">Loại Tour:</label>
            <select class="form-control form-select" id="tour_type" name="tour_type">
                <option value="Nội địa" <?= ($tour['tour_type'] == 'Nội địa') ? 'selected' : '' ?>>Nội địa</option>
                <option value="Quốc tế" <?= ($tour['tour_type'] == 'Quốc tế') ? 'selected' : '' ?>>Quốc tế</option>
            </select>
        </div>

        <div class="form-group">
            <label for="base_price" class="form-label">Giá cơ bản:</label>
            <input type="number" class="form-control" id="base_price" name="base_price"
                value="<?= $tour['base_price'] ?>" required>
        </div>

        <div class="form-group">
            <label for="destination_id" class="form-label">Điểm đến:</label>
            <select class="form-control form-select" id="destination_id" name="destination_id" required>
                <?php foreach ($listDestinations as $des): ?>
                    <option value="<?= $des['id'] ?>"
                        <?= ($tour['destination_id'] == $des['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($des['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="category_id" class="form-label">Danh mục tour:</label>
            <select class="form-control form-select" id="category_id" name="category_id" required>
                <option value="">-- Chọn danh mục --</option>
                <?php foreach ($listCategories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"
                        <?= ($tour['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                        <?= $cat['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <!-- Ảnh cũ -->
        <div class="form-group">
            <label>Ảnh hiện tại:</label><br>
            <?php if (!empty($tour['image'])): ?>
                <img src="<?= BASE_ASSETS_UPLOADS . $tour['image'] ?>" width="180" style="border-radius:5px; margin-bottom:10px;">
            <?php else: ?>
                <p><i>Chưa có ảnh</i></p>
            <?php endif; ?>
        </div>

        <!-- Upload ảnh mới -->
        <div class="form-group">
            <label for="image" class="form-label">Ảnh mới (nếu muốn thay):</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Mô tả:</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?= $tour['description'] ?? '' ?></textarea>
        </div>

        <div class="form-group">
            <label for="cancellation_policy" class="form-label">Chính sách hủy tour:</label>
            <textarea class="form-control" id="cancellation_policy" name="cancellation_policy" rows="3"><?= $tour['cancellation_policy'] ?? '' ?></textarea>
        </div>

        <button type="submit" class="btn btn-nut">Cập nhật</button>
        <a href="<?= BASE_URL ?>?action=list-tour" class="btn btn-danger">Quay lại</a>
    </form>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>