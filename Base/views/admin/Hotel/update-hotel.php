<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Cập nhật Khách sạn</h2>

    <form action="<?= BASE_URL ?>?action=update-hotel&id=<?= isset($data['id']) ? $data['id'] : '' ?>" method="post">
        <div class="mb-3">
            <label for="">Tên khách sạn</label>
            <input type="text" class="form-control" name="name" 
                   value="<?= isset($data['name']) ? htmlspecialchars($data['name']) : '' ?>" required>
        </div>

        <div class="mb-3">
            <label for="">Địa chỉ</label>
            <input type="text" class="form-control" name="address" 
                   value="<?= isset($data['address']) ? htmlspecialchars($data['address']) : '' ?>">
        </div>

        <div class="mb-3">
            <label for="">Điểm đến</label>
            <select name="destination_id" class="form-control" required>
                <?php foreach($listDestination as $dest): ?>
                    <option value="<?= $dest['id'] ?>" 
                        <?= isset($data['destination_id']) && $data['destination_id'] == $dest['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($dest['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
