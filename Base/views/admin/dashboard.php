<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main container mt-4">
    <div class="header-wrapper">
        <div class="header-content">
            <div class="breadcrumb">Trang chủ / Dashboard</div>
            <h2 class="page-title">Dashboard</h2>
            <p class="page-sub">Tour nổi bật</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="row g-4 justify-content-center">
    <?php
        $infoCards = [
            ["title" => "Tổng doanh thu", "value" => number_format($stats['total_revenue'] ?? 0, 0, ',', '.') . " VNĐ", "bg" => "bg-light"],
            ["title" => "Tổng đơn hàng", "value" => number_format($stats['total_bookings_count'] ?? 0), "bg" => "bg-light"],
            ["title" => "Đơn đã thanh toán", "value" => number_format($stats['paid_bookings_count'] ?? 0), "bg" => "bg-light"],
            ["title" => "Người dùng", "value" => number_format($stats['total_users'] ?? 0), "bg" => "bg-light"]
        ];
    ?>

    <?php foreach ($infoCards as $card): ?>
    <div class="col-md-3 col-sm-6">
        <div class="card <?= $card['bg'] ?> border-0 shadow-sm rounded-3 h-100">
            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                <div class="text-secondary small mb-2"><?= $card["title"] ?></div>
                <div class="h4 fw-bold text-dark"><?= $card["value"] ?></div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

    <!-- Recent Orders -->
    <div class="card shadow-sm border-0 rounded-3 mt-5">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="fw-semibold mb-0 text-dark">Đơn hàng gần đây</h5>
            <span class="text-secondary small">Top 5 đơn hàng mới nhất</span>
        </div>

        <div class="card-body p-0">
            <?php if (!empty($recentBookings)): ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Tour</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th class="pe-4 text-end">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentBookings as $booking): ?>
                        <tr>
                            <td class="ps-4 fw-semibold text-dark"><?= $booking['id'] ?></td>
                            <td class="text-dark"><?= $booking['tour_name'] ?? '—' ?></td>
                            <td class="text-secondary"><?= date('d/m/Y', strtotime($booking['booking_date'])) ?></td>
                            <td class="text-dark"><?= number_format($booking['total_price']) ?> VNĐ</td>
                            <td class="pe-4 text-end">
                                <?php if ($booking['payment_status'] === 'Paid'): ?>
                                    <span class="badge rounded-pill bg-success px-3 py-2">Paid</span>
                                <?php else: ?>
                                    <span class="badge rounded-pill bg-warning text-dark px-3 py-2">Pending</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <div class="p-4 text-secondary">Không có đơn hàng nào gần đây.</div>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
