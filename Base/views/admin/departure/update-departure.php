<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Cập nhật lịch khởi hành :</h2>
    <div class="card">
        <div class="toph4">
            <h4><?= $data['tour_name'] ?? '' ?></h4>
        </div>
        <form action="<?= BASE_URL ?>?action=update-departure&id=<?= $data['id'] ?? '' ?>" method="post">
            <div class="form-group mb-3">
                <label for="tour_id" class="form-label">Tour:</label>
                <select name="tour_id" id="tour_id" class="form-control" required>
                    <?php foreach ($listTour as $tour): ?>
                        <option value="<?= $tour['id'] ?>" <?= (isset($data['tour_id']) && $data['tour_id'] == $tour['id']) ? 'selected' : '' ?>>
                            <?= $tour['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="start_date" class="form-label">Ngày đi:</label>
                <input type="date" id="start_date" name="start_date" class="form-control" 
                       value="<?= $data['start_date'] ?? '' ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="end_date" class="form-label">Ngày về:</label>
                <input type="date" id="end_date" name="end_date" class="form-control" 
                       value="<?= $data['end_date'] ?? '' ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="current_price" class="form-label">Giá hiện tại:</label>
                <input type="number" id="current_price" name="current_price" class="form-control" 
                       value="<?= $data['current_price'] ?? '' ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="available_slots" class="form-label">Chỗ trống:</label>
                <input type="number" id="available_slots" name="available_slots" class="form-control" 
                       value="<?= $data['available_slots'] ?? '' ?>" required>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="<?= BASE_URL ?>?action=delete-departure&id=<?= $data['id'] ?? '' ?>" 
                   onclick="return confirm('Bạn có chắc chắn muốn xóa lịch khởi hành này không?')" 
                   class="btn btn-danger">Xóa</a>
            </div>
        </form>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
