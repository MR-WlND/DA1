<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Thêm chính sách hủy mới :</h2>

    <div class="card">
        <div class="toph4">
            <h4>Thông tin chính sách hủy</h4>
        </div>

        <form action="<?= BASE_URL ?>?action=create-policy" method="post">
            
            <div class="form-group mb-3">
                <label for="policy_name" class="form-label">Tên chính sách:</label>
                <input type="text" class="form-control" id="policy_name" name="policy_name" 
                       placeholder="Nhập tên chính sách (VD: Chính sách lễ Tết)" required>
            </div>

            <div class="form-group mb-3">
                <label for="details" class="form-label">Nội dung chi tiết:</label>
                <textarea class="form-control" id="details" name="details" rows="4" 
                          placeholder="Nhập nội dung chi tiết của chính sách" required></textarea>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-nut">Thêm mới</button>
                <a href="<?= BASE_URL ?>?action=list-policies" class="btn btn-danger">Quay lại</a>
            </div>

        </form>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
