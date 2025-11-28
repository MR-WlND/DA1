<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Thêm Khách sạn mới :</h2>
    <div class="card">
        <div class="toph4">
            <h4>Thông tin Khách sạn</h4>
        </div>

        <form action="<?= BASE_URL ?>?action=create-hotel" method="post">
            <div class="form-group mb-3">
                <label for="name">Tên khách sạn:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group mb-3">
                <label for="address">Địa chỉ:</label>
                <input type="text" class="form-control" id="address" name="address">
            </div>

            <div class="form-group mb-3">
                <label for="destination_id">Điểm đến:</label>
                <select name="destination_id" id="destination_id" class="form-control" required>
                    <?php foreach($listDestination as $dest): ?>
                        <option value="<?= $dest['id'] ?>"><?= $dest['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Thêm Khách sạn</button>
                <a href="<?= BASE_URL ?>?action=list-hotel" class="btn btn-danger">Quay lại</a>
            </div>
        </form>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
