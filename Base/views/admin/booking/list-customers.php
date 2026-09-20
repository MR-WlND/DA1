<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Danh sách Khách tham gia (Manifest)</h2>
        <?php if (isset($_GET['booking_id'])): ?>
            <a href="<?= BASE_URL ?>?action=detail-booking&id=<?= $_GET['booking_id'] ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại Booking
            </a>
        <?php endif; ?>
    </div>

    <div class="card">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên khách</th>
                    <th>Điện thoại</th>
                    <th>Ngày sinh</th>
                    <th>Ghi chú</th>
                    <th>Trạng thái Check-in</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($listCustomers)): ?>
                    <?php $i = 1; foreach ($listCustomers as $customer): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= htmlspecialchars($customer['name'] ?? '') ?></td>
                            <td><?= htmlspecialchars($customer['phone'] ?? 'N/A') ?></td>
                            <td><?= !empty($customer['date_of_birth']) ? date('d/m/Y', strtotime($customer['date_of_birth'])) : 'N/A' ?></td>
                            <td><?= htmlspecialchars($customer['special_note'] ?? '') ?></td>
                            <td>
                                <?php if ($customer['is_checked_in']): ?>
                                    <span class="badge bg-success">Đã Check-in</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Chưa Check-in</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($customer['is_checked_in']): ?>
                                    <a href="<?= BASE_URL ?>?action=update-checkin-status&customer_id=<?= $customer['id'] ?>&status=0&booking_id=<?= $_GET['booking_id'] ?? '' ?>" class="btn btn-sm btn-danger">Hủy Check-in</a>
                                <?php else: ?>
                                    <a href="<?= BASE_URL ?>?action=update-checkin-status&customer_id=<?= $customer['id'] ?>&status=1&booking_id=<?= $_GET['booking_id'] ?? '' ?>" class="btn btn-sm btn-success">Check-in</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Chưa có thông tin khách hàng nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
