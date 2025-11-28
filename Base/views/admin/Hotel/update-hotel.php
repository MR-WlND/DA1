<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Cập nhật Khách sạn :</h2>
    <div class="card">
        <div class="toph4">
            <h4><?= htmlspecialchars($data['name'] ?? 'Khách sạn') ?></h4>
        </div>

        <form action="<?= BASE_URL ?>?action=update-hotel&id=<?= $data['id'] ?? '' ?>" method="post">
            <div class="form-group mb-3">
                <label for="name">Tên khách sạn:</label>
                <input type="text" class="form-control" id="name" name="name" 
                       value="<?= htmlspecialchars($data['name'] ?? '') ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="address">Địa chỉ:</label>
                <input type="text" class="form-control" id="address" name="address" 
                       value="<?= htmlspecialchars($data['address'] ?? '') ?>">
            </div>

            <div class="form-group mb-3">
                <label for="destination_id">Điểm đến:</label>
                <select name="destination_id" id="destination_id" class="form-control" required>
                    <?php foreach ($listDestination as $dest): ?>
                        <option value="<?= $dest['id'] ?>" 
                            <?= isset($data['destination_id']) && $data['destination_id'] == $dest['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($dest['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="<?= BASE_URL ?>?action=delete-hotel&id=<?= $data['id'] ?>" 
                   onclick="return confirm('Bạn có chắc chắn muốn xóa khách sạn này không?')" 
                   class="btn btn-danger">Xóa</a>
            </div>
        </form>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
