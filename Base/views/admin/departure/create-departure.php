<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Tạo lịch khởi hành mới :</h2>
    <div class="card">
        <div class="toph4">
            <h4>Thông tin lịch khởi hành</h4>
        </div>

        <form action="<?= BASE_URL ?>?action=create-departure" method="post">
            <div class="form-group mb-3">
                <label for="tour_id">Chọn tour:</label>
                <select name="tour_id" id="tour_id" class="form-control">
                    <?php foreach($listTours as $tour): ?>
                        <option value="<?= $tour['id'] ?>"><?= $tour['name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="start_date">Ngày khởi hành:</label>
                <input type="date" name="start_date" id="start_date" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="end_date">Ngày kết thúc:</label>
                <input type="date" name="end_date" id="end_date" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="current_price">Giá hiện tại:</label>
                <input type="number" name="current_price" id="current_price" class="form-control" step="0.01">
            </div>

            <div class="form-group mb-3">
                <label for="available_slots">Số chỗ còn trống:</label>
                <input type="number" name="available_slots" id="available_slots" class="form-control">
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-nut">Tạo lịch khởi hành</button>
                <a href="<?= BASE_URL ?>?action=list-departure" class="btn btn-secondary mt-2">Quay lại</a>
            </div>
        </form>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
