<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Đơn hàng của tôi</h2>
        <a href="<?= BASE_URL ?>?action=public-tours" class="btn btn-outline-primary">
            <i class="fas fa-search"></i> Đặt tour mới
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Mã Đơn</th>
                        <th>Tour</th>
                        <th>Ngày Đặt</th>
                        <th>Ngày Khởi Hành</th>
                        <th>Tổng Tiền</th>
                        <th>Trạng Thái</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($listBookings)): ?>
                        <?php foreach ($listBookings as $b): ?>
                            <tr>
                                <td>#<?= $b['id'] ?></td>
                                <td class="fw-bold text-primary">
                                    <a href="<?= BASE_URL ?>?action=public-detail-tour&id=<?= $b['tour_id'] ?? '' ?>" class="text-decoration-none">
                                        <?= htmlspecialchars($b['tour_name'] ?? '') ?>
                                    </a>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($b['booking_date'])) ?></td>
                                <td><?= date('d/m/Y', strtotime($b['start_date'])) ?></td>
                                <td class="text-danger fw-bold"><?= number_format($b['total_price'] ?? 0, 0, ',', '.') ?>đ</td>
                                <td>
                                    <?php if ($b['payment_status'] === 'Paid'): ?>
                                        <span class="badge bg-success">Đã Thanh Toán</span>
                                    <?php elseif ($b['payment_status'] === 'Pending'): ?>
                                        <span class="badge bg-warning text-dark">Chờ Thanh Toán</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Thất Bại / Hủy</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($b['payment_status'] === 'Pending'): ?>
                                        <a href="<?= BASE_URL ?>?action=checkout-simple&id=<?= $b['id'] ?>" class="btn btn-sm btn-primary">Thanh Toán</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4">Bạn chưa có đơn đặt tour nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
