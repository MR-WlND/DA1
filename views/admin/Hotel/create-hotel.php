<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Thêm Khách sạn mới</h2>

    <form action="<?= BASE_URL ?>?action=create-hotel" method="post">
        <div class="mb-3">
            <label for="">Tên khách sạn</label>
            <input type="text" class="form-control" name="name" required>
        </div>

        <div class="mb-3">
            <label for="">Địa chỉ</label>
            <input type="text" class="form-control" name="address">
        </div>

        <div class="mb-3">
            <label for="">Điểm đến</label>
            <select name="destination_id" class="form-control" required>
                <?php foreach($listDestination as $dest): ?>
                    <option value="<?= $dest['id'] ?>"><?= htmlspecialchars($dest['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Thêm Khách sạn</button>
    </form>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
