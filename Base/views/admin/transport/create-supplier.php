<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2><?= $title ?></h2>
    <div class="card">
        <form action="<?= BASE_URL ?>?action=create-supplier" method="post">
            
            <div class="form-group mb-3">
                <label for="supplier_name" class="form-label">Tên Công ty (NCC):</label>
                <input type="text" id="supplier_name" name="supplier_name" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="contact_person" class="form-label">Người liên hệ:</label>
                <input type="text" id="contact_person" name="contact_person" class="form-control">
            </div>
            
            <div class="form-group mb-3">
                <label for="phone" class="form-label">Số điện thoại:</label>
                <input type="tel" id="phone" name="phone" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control">
            </div>
            
            <div class="form-group mb-3">
                <label for="details" class="form-label">Chi tiết/Ghi chú hợp đồng:</label>
                <textarea id="details" name="details" class="form-control" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Lưu Nhà Cung Cấp</button>
            <a href="<?= BASE_URL ?>?action=list-supplier" class="btn btn-danger">Hủy</a>
        </form>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>