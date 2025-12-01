<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Cập nhật NCC Vận tải :</h2>
    <div class="card">
        <div class="toph4">
            <h4><?= $supplier['supplier_name'] ?? 'Nhà cung cấp' ?></h4>
        </div>

        <form action="<?= BASE_URL ?>?action=update-supplier&id=<?= $supplier['id'] ?? '' ?>" method="post">
            
            <div class="form-group mb-3">
                <label for="supplier_name" class="form-label">Tên Công ty (NCC):</label>
                <input type="text" id="supplier_name" name="supplier_name" class="form-control" 
                       value="<?= $supplier['supplier_name'] ?? '' ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="contact_person" class="form-label">Người liên hệ:</label>
                <input type="text" class="form-control" id="contact_person" name="contact_person" 
                       value="<?= $supplier['contact_person'] ?? '' ?>">
            </div>

            <div class="form-group mb-3">
                <label for="phone" class="form-label">Số điện thoại:</label>
                <input type="tel" class="form-control" id="phone" name="phone" 
                       value="<?= $supplier['phone'] ?? '' ?>">
            </div>

            <div class="form-group mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" 
                       value="<?= $supplier['email'] ?? '' ?>">
            </div>
            
            <div class="form-group mb-3">
                <label for="details" class="form-label">Chi tiết/Ghi chú hợp đồng:</label>
                <textarea id="details" name="details" class="form-control" rows="4"><?= $supplier['details'] ?? '' ?></textarea>
            </div>


            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="<?= BASE_URL ?>?action=delete-supplier&id=<?= $supplier['id'] ?? '' ?>" 
                   onclick="return confirm('Bạn có chắc chắn muốn xóa NCC này không?')" 
                   class="btn btn-danger">Xóa</a>
            </div>
        </form>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>