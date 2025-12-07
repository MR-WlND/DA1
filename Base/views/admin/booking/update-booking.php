<?php 
// File: views/admin/booking/update-booking.php
include PATH_VIEW . 'layout/header.php'; 

// Lấy dữ liệu chính
$booking = $data ?? []; 
$currentDepartureId = $booking['departure_id'] ?? null;
?>

<div class="main">
    <h2>Cập nhật Đơn đặt: #<?= $booking['id'] ?></h2>
    <div class="card p-4">
        
        <form action="<?= BASE_URL ?>?action=update-booking&id=<?= $booking['id'] ?>" method="post">
            
            <fieldset class="mb-4 border p-3">
                <legend class="fs-5 fw-bold text-primary">1. Thông tin Đặt Tour</legend>

                <div class="form-group mb-3">
                    <label for="departure_id" class="form-label">Chọn Chuyến Khởi Hành:</label>
                    <select name="departure_id" id="departure_id" class="form-control" required>
                        <option value="">-- Chọn chuyến đi --</option>
                        <?php foreach ($listDepartures as $dep): ?>
                            <option 
                                value="<?= $dep['departure_id'] ?>" 
                                <?= ($dep['departure_id'] == $currentDepartureId) ? 'selected' : '' ?>>
                                
                                <?= htmlspecialchars($dep['tour_name'] ?? 'N/A') ?> 
                                (<?= date('d/m/Y', strtotime($dep['start_date'])) ?>) [Còn: <?= $dep['remaining_slots'] ?> chỗ]
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group mb-3">
                    <label for="user_id" class="form-label">Khách hàng Đặt (User ID):</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <?php foreach ($listUsers as $user): ?>
                            <option value="<?= $user['id'] ?>" <?= ($user['id'] == ($booking['user_id'] ?? null)) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['email']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="status" class="form-label">Trạng thái Đơn hàng:</label>
                    <select name="status" id="status" class="form-control">
                        <option value="Pending" <?= ($booking['status'] == 'Pending') ? 'selected' : '' ?>>Pending (Chờ xác nhận)</option>
                        <option value="Confirmed" <?= ($booking['status'] == 'Confirmed') ? 'selected' : '' ?>>Confirmed (Đã xác nhận)</option>
                        <option value="Cancelled" <?= ($booking['status'] == 'Cancelled') ? 'selected' : '' ?>>Cancelled (Đã hủy)</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="total_price" class="form-label">Tổng Giá trị Đơn hàng (VNĐ):</label>
                    <input type="number" name="total_price" id="total_price" class="form-control" required min="0" 
                           value="<?= $booking['total_price'] ?? 0 ?>">
                </div>
            </fieldset>

            <fieldset class="mb-4 border p-3">
                <legend class="fs-5 fw-bold text-primary">2. Chi tiết Khách tham gia</legend>
                
                <?php $customerCount = count($booking['customers'] ?? []); ?>
                <p class="mb-3 text-muted">Đơn hàng này có **<?= $customerCount ?>** khách tham gia. Để thay đổi danh sách khách, vui lòng sử dụng chức năng Quản lý Manifest.</p>

                <table class="table table-sm table-striped">
                    <thead>
                        <tr><th>#</th><th>Họ tên</th><th>SĐT</th><th>Check-in</th></tr>
                    </thead>
                    <tbody>
                        <?php if ($customerCount > 0): ?>
                            <?php foreach ($booking['customers'] as $i => $customer): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= htmlspecialchars($customer['name']) ?></td>
                                    <td><?= htmlspecialchars($customer['phone'] ?? '-') ?></td>
                                    <td>
                                        <span class="badge <?= ($customer['is_checked_in'] == 1) ? 'bg-success' : 'bg-secondary' ?>">
                                            <?= ($customer['is_checked_in'] == 1) ? 'Đã Check-in' : 'Chờ Check-in' ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="text-center">Chưa có khách tham gia nào được ghi nhận.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </fieldset>

            <button type="submit" class="btn btn-primary w-100">Lưu Cập Nhật Đơn Hàng</button>
        </form>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>