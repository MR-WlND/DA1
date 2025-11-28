<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Tạo Tour Mới</h2>

    <form action="<?= BASE_URL ?>?action=create-tour" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="">Tên tour</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="">Loại tour</label>
            <select name="tour_type" class="form-control" required>
                <option value="Nội địa">Nội địa</option>
                <option value="Quốc tế">Quốc tế</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="">Giá cơ bản</label>
            <input type="number" name="base_price" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="">Danh mục</label>
            <select name="category_id" class="form-control">
                <?php foreach($listCategories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="">Mô tả</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="">Chính sách hủy</label>
            <textarea name="cancellation_policy" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="">Ảnh đại diện</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label>Chọn điểm đến</label>
            <?php foreach($listDestinations as $dest): ?>
                <div>
                    <input type="checkbox" name="destinations[]" value="<?= $dest['id'] ?>">
                    <?= htmlspecialchars($dest['name']) ?>
                </div>
            <?php endforeach; ?>
        </div>

        <hr>
        <h4>Thêm Lịch khởi hành</h4>
        <div class="departure-block">
        <div class="mb-3">
                <label>Ngày bắt đầu</label>
                <input type="date" name="departures[0][start_date]" class="form-control">
            </div>
            <div class="mb-3">
                <label>Ngày kết thúc</label>
                <input type="date" name="departures[0][end_date]" class="form-control">
            </div>
            <div class="mb-3">
                <label>Giá hiện tại</label>
                <input type="number" name="departures[0][current_price]" class="form-control" step="0.01">
            </div>
            <div class="mb-3">
                <label>Số chỗ tối đa</label>
                <input type="number" name="departures[0][available_slots]" class="form-control">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Tạo Tour</button>
    </form>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
