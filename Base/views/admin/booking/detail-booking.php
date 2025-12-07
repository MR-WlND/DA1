<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2 class="mb-4">Chi tiết Đơn đặt Tour: #<?= $booking['id'] ?></h2>

    <?php if (isset($_GET['debug']) && $_GET['debug'] == 1): ?>
        <div class="card mb-4">
            <pre style="white-space:pre-wrap;word-break:break-word;">
<?= htmlspecialchars(print_r($booking, true)) ?>
            </pre>
        </div>
    <?php endif; ?>

    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="text-primary">Khách hàng: <?= $booking['customer_name'] ?? 'Khách lẻ' ?></h4>
            <span class="badge bg-<?= ($booking['status'] == 'Confirmed') ? 'success' : (($booking['status'] == 'Cancelled') ? 'danger' : 'warning') ?> fs-6">
                Trạng thái: <?= $booking['status'] ?>
            </span>
        </div>

        <fieldset class="mb-5 border p-3">
            <legend class="fs-5 text-secondary">Thông tin chuyến đi</legend>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Tên Tour:</strong> <?= $booking['tour_name'] ?? 'N/A' ?></p>
                    <p><strong>Ngày Đặt:</strong> <?= date('d/m/Y H:i', strtotime($booking['booking_date'])) ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Ngày Khởi Hành:</strong> <?= date('d/m/Y', strtotime($booking['start_date'] ?? 'N/A')) ?></p>
                    <p><strong>Ngày Kết Thúc:</strong> <?= date('d/m/Y', strtotime($booking['end_date'] ?? 'N/A')) ?></p>
                </div>
            </div>
            <hr>
            <h5 class="mt-3">Tổng Giá trị: <span class="text-success"><?= number_format($booking['total_price'] ?? 0, 0, ',', '.') ?> VNĐ</span></h5>
        </fieldset>

        <section class="customer-list mb-5">
            <h3 class="fs-4 mb-3">Danh sách Khách tham gia (<?= count($booking['customers'] ?? []) ?> người)</h3>

            <?php if (empty($booking['customers'])): ?>
                <div class="alert alert-info">Chưa có khách tham gia cho đơn này.</div>
            <?php else: ?>
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Họ tên</th>
                            <th>SĐT</th>
                            <th>Ghi chú</th>
                            <th>Check-in</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($booking['customers'] as $i => $customer): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= htmlspecialchars($customer['name'] ?? '') ?></td>
                                <td><?= htmlspecialchars($customer['phone'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($customer['special_note'] ?? '') ?></td>
                                <td>
                                    <span class="badge <?= ($customer['is_checked_in'] == 1) ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= ($customer['is_checked_in'] == 1) ? 'Đã Check-in' : 'Chờ Check-in' ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>

        <div class="mt-4 pt-3 border-top">
            <a href="<?= BASE_URL ?>?action=update-booking&id=<?= $booking['id'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Sửa Đơn hàng</a>
            <a href="<?= BASE_URL ?>?action=delete-booking&id=<?= $booking['id'] ?>" onclick="return confirm('Hủy đơn đặt này?')" class="btn btn-danger"><i class="fas fa-trash"></i> Hủy đơn</a>
            <a href="<?= BASE_URL ?>?action=list-booking" class="btn btn-secondary">Quay lại Danh sách</a>
        </div>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>