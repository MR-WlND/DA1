<?php
// Giả định $booking là biến chứa dữ liệu được truyền từ Controller.
// Nếu $data được truyền, hãy sử dụng $booking = $data['booking'] ?? [];

include PATH_VIEW . 'layout/header.php';
?>

<div class="main container mt-4">

    <h2 class="mb-4 text-primary">Chi tiết Đơn đặt Tour #<?= $booking['id'] ?? '—' ?></h2>

    <div class="card p-4 shadow-sm">

        <h4 class="mb-3 text-secondary">Thông tin Booking</h4>

        <table class="table table-bordered">
            <tr>
                <th>ID Booking</th>
                <td><?= $booking['id'] ?? '—' ?></td>
            </tr>

            <tr>
                <th>Khách hàng</th>
                <td><?= $booking['customer_name'] ?? '—' ?></td>
            </tr>

            <tr>
                <th>Email</th>
                <td><?= $booking['customer_email'] ?? '—' ?></td>
            </tr>

            <tr>
                <th>Số điện thoại</th>
                <td><?= $booking['customer_phone'] ?? '—' ?></td>
            </tr>

            <tr>
                <th>Tour</th>
                <td><?= $booking['tour_name'] ?? '—' ?></td>
            </tr>

            <tr>
                <th>Số lượng Khách hàng</th>
                <td>
                    <strong><?= $booking['customer_count'] ?? 0 ?></strong> người
                </td>
            </tr>

            <tr>
                <th>Ngày khởi hành</th>
                <td>
                    <?php
                    $date = $booking['departure_date'] ?? null;
                    echo $date ? date('d/m/Y', strtotime($date)) : '—';
                    ?>
                </td>
            </tr>

            <tr>
                <th>Tổng tiền</th>
                <td><?= number_format($booking['total_price'] ?? 0) ?> đ</td>
            </tr>

            <tr>
                <th>Trạng thái thanh toán</th>
                <td>
                    <?php
                    $status = strtolower($booking['payment_status'] ?? 'pending');
                    $badge = match ($status) {
                        'paid'   => 'bg-success',
                        'pending' => 'bg-info text-light', // Trạng thái mặc định sau khi tạo đơn
                        'confirmed' => 'bg-warning text-dark', // Trạng thái đã xác nhận chờ thanh toán
                        'failed' => 'bg-danger',
                        default  => 'bg-secondary'
                    };
                    ?>
                    <span class="badge <?= $badge ?> p-2">
                        <?= ucfirst($status) ?>
                    </span>
                </td>
            </tr>

            <tr>
                <th>Mã giao dịch Ngân hàng</th>
                <td>
                    <?php
                    $txn_id = $booking['transaction_id'] ?? null;
                    if (!empty($txn_id)):
                    ?>
                        <strong><?= $txn_id ?></strong>
                        <br><small class="text-muted">(Ngày nhận: <?= date('d/m/Y H:i', strtotime($booking['payment_date'] ?? 'now')) ?>)</small>
                    <?php else: ?>
                        <span class="text-muted">Chưa có — đang chờ chuyển khoản</span>
                    <?php endif; ?>
                </td>
            </tr>
        </table>

        <?php if (($booking['payment_status'] ?? 'pending') !== 'Paid'): ?>
            <div class="card p-3 border-success mt-4">
                <h4 class="text-success">Xác nhận Thanh toán Thủ công</h4>
                <form action="<?= BASE_URL ?>?action=mark-booking-paid" method="POST">

                    <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">

                    <div class="form-group mb-3">
                        <label for="transaction_id">Mã Giao dịch Ngân hàng (Để đối chiếu):</label>
                        <input type="text" name="transaction_id" id="transaction_id"
                            class="form-control" placeholder="Nhập mã tham chiếu từ Sao kê" required>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check-circle"></i> XÁC NHẬN ĐÃ THANH TOÁN
                    </button>
                </form>
            </div>
        <?php endif; ?>
        <a href="<?= BASE_URL ?>?action=list-booking" class="btn btn-secondary mt-3">Quay lại danh sách</a>

    </div>

</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>