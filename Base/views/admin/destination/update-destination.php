<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Cập nhật điểm đến :</h2>
    <div class="card">
        <div class="toph4">
            <h4><?= $data['name'] ?? '' ?></h4>
        </div>
        <form action="<?= BASE_URL ?>?action=update-destination&id=<?= $data['id'] ?? '' ?>" method="post">
            <div class="form-group">
                <label for="name" class="form-label">Tên điểm đến:</label>
                <input type="text" class="form-control" id="name" name="name"
                       value="<?= $data['name'] ?? '' ?>" required>
            </div>

            <div class="form-group">
                <label for="country" class="form-label">Quốc gia:</label>
                <input type="text" class="form-control" id="country" name="country"
                       value="<?= $data['country'] ?? '' ?>" required>
            </div>

            <div class="form-group">
                <label for="type" class="form-label">Loại:</label>
                <select name="type" id="type" class="form-control" required>
                    <?php foreach ($listType as $typeValue): ?>
                        <option value="<?= $typeValue ?>" <?= (isset($data['type']) && $data['type'] == $typeValue) ? 'selected' : '' ?>>
                            <?= $typeValue ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="<?= BASE_URL ?>?action=delete-destination&id=<?= $data['id'] ?? '' ?>" 
                   onclick="return confirm('Bạn có chắc chắn muốn xóa điểm đến này không?')" class="btn btn-danger">Xóa</a>
            </div>
        </form>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
