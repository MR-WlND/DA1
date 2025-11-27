<form action="<?= BASE_URL ?>?action=create-departure" method="post">
    <div class="mb-3">
        <label for="">Chọn tour</label>
        <select name="tour_id" class="form-control">
            <?php foreach($listTours as $tour): ?>
                <option value="<?= $tour['id'] ?>"><?= htmlspecialchars($tour['name']) ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="">Ngày khởi hành</label>
        <input type="date" name="start_date" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">Ngày kết thúc</label>
        <input type="date" name="end_date" class="form-control">
    </div>
    <div class="mb-3">
        <label for="">Giá hiện tại</label>
        <input type="number" name="current_price" class="form-control" step="0.01">
    </div>
    <div class="mb-3">
        <label for="">Số chỗ còn trống</label>
        <input type="number" name="available_slots" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Tạo lịch khởi hành</button>
</form>
