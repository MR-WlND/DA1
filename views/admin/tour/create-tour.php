<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Thêm Tour mới</h2>
    <form action="<?= BASE_URL ?>?action=create-tour" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name" class="form-label">Tên Tour:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên tour" required>
        </div>
        <div class="form-group">
            <label for="tour_type" class="form-label">Loại Tour:</label>
            <select class="form-control form-select" id="tour_type" name="tour_type">
                <option value="Nội địa">Nội địa</option>
                <option value="Quốc tế">Quốc tế</option>
            </select>
        </div>
        <div class="form-group">
            <label for="base_price" class="form-label">Giá cơ bản:</label>
            <input type="number" class="form-control" id="base_price" name="base_price" placeholder="Nhập giá" required>
        </div>
        <div class="form-group">
            <label for="destination_id" class="form-label">ID Điểm đến:</label>
            <input type="number" class="form-control" id="destination_id" name="destination_id" placeholder="Nhập ID của điểm đến" required>
        </div>
        <div class="form-group">
            <label for="image" class="form-label">Ảnh đại diện:</label>
            <input type="text" class="form-control" id="image" name="image" placeholder="Nhập đường dẫn ảnh">
        </div>
        <div class="form-group">
            <label for="description" class="form-label">Mô tả:</label>
            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Nhập mô tả chi tiết cho tour"></textarea>
        </div>
        <div class="form-group">
            <label for="cancellation_policy" class="form-label">Chính sách hủy tour:</label>
            <textarea class="form-control" id="cancellation_policy" name="cancellation_policy" rows="3" placeholder="Nhập chính sách hủy tour"></textarea>
        </div>

        <button type="submit" class="btn btn-nut">Thêm mới</button>
        <a href="<?= BASE_URL ?>?action=list-tour" class="btn btn-danger">Quay lại</a>
    </form>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
