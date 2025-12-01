<?php 
// File: views/admin/booking/update-booking.php
include PATH_VIEW . 'layout/header.php'; 
// Giả định $listDepartures, $listUsers, $data đều có sẵn
?>

<div class="main">
    <h2>Cập nhật Đơn đặt: #<?= $data['id'] ?></h2>
    <div class="card p-4">
        <form action="<?= BASE_URL ?>?action=update-booking&id=<?= $data['id'] ?>" method="post">
            
            <p class="mb-3">
                <strong>Tour:</strong> <?= htmlspecialchars($data['tour_name'] ?? 'N/A') ?> 
                (Ngày đi: <?= htmlspecialchars($data['start_date'] ?? 'N/A') ?>)
            </p>

            <div class="form-group mb-3">
                <label for="status" class="form-label">Trạng thái Đơn hàng:</label>
                <select name="status" id="status" class="form-control">
                    <option value="Pending" <?= ($data['status'] == 'Pending') ? 'selected' : '' ?>>Pending (Chờ xác nhận)</option>
                    <option value="Confirmed" <?= ($data['status'] == 'Confirmed') ? 'selected' : '' ?>>Confirmed (Đã xác nhận)</option>
                    <option value="Cancelled" <?= ($data['status'] == 'Cancelled') ? 'selected' : '' ?>>Cancelled (Đã hủy)</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="total_price" class="form-label">Tổng Giá trị Đơn hàng (VNĐ):</label>
                <input type="number" name="total_price" id="total_price" class="form-control" 
                       value="<?= $data['total_price'] ?>" required min="0">
            </div>

            <button type="submit" class="btn btn-primary mt-3">Lưu Cập Nhật</button>
            <a href="<?= BASE_URL ?>?action=list-booking" class="btn btn-danger mt-3">Hủy</a>
        </form>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>