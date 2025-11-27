<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Cập nhật điểm đến</h2>

    <form action="<?= BASE_URL ?>?action=update-destination&id=<?= isset($data['id']) ? $data['id'] : '' ?>" method="post">
        <div class="mb-3">
            <label for="">Tên điểm đến</label>
            <input type="text" class="form-control" name="name" 
                   value="<?= isset($data['name']) ? htmlspecialchars($data['name']) : '' ?>" required>
        </div>

        <div class="mb-3">
            <label for="">Quốc gia</label>
            <input type="text" class="form-control" name="country" 
                   value="<?= isset($data['country']) ? htmlspecialchars($data['country']) : '' ?>" required>
        </div>

        <div class="mb-3">
            <label for="">Loại</label>
            <select name="type" class="form-control" required>
                <?php foreach ($listType as $typeValue): ?>
                    <option value="<?= $typeValue ?>" <?= isset($data['type']) && $data['type'] == $typeValue ? 'selected' : '' ?>>
                        <?= $typeValue ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
