<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Thêm điểm đến mới :</h2>
    <div class="card">
        <div class="toph4">
            <h4>Thông tin điểm đến</h4>
        </div>

        <form action="<?= BASE_URL ?>?action=create-destination" method="post">
            <div class="form-group mb-3">
                <label for="name">Tên điểm đến:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group mb-3">
                <label for="country">Quốc gia:</label>
                <input type="text" class="form-control" id="country" name="country" required>
            </div>

            <div class="form-group mb-3">
                <label for="type">Loại:</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="City">City</option>
                    <option value="Country">Country</option>
                    <option value="Region">Region</option>
                </select>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-nut">Thêm mới</button>
                 <a href="<?= BASE_URL ?>?action=list-destination" class="btn btn-danger mt-2">Quay lại</a>
            </div>
        </form>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
