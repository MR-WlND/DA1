<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Thêm điểm đến mới</h2>

    <form action="<?= BASE_URL ?>?action=create-destination" method="post">
        <div class="mb-3">
            <label for="">Tên điểm đến</label>
            <input type="text" class="form-control" name="name" required>
        </div>

        <div class="mb-3">
            <label for="">Quốc gia</label>
            <input type="text" class="form-control" name="country" required>
        </div>

        <div class="mb-3">
            <label for="">Loại</label>
            <select name="type" class="form-control" required>
                <option value="City">City</option>
                <option value="Country">Country</option>
                <option value="Region">Region</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
