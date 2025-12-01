<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Quản lý Đơn đặt Tour</h2>
    <div class="card">
        <div class="toph4">
            <h4>Danh sách Đơn đặt</h4>
            <a href="<?= BASE_URL ?>?action=create-booking" class="btn btn-nut">+ Thêm Đơn đặt</a>
        </div>
        
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Tour</th>
                    <th>Ngày Khởi hành</th>
                    <th>Người đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th> <th>Ngày đặt</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($listBookings)): ?>
                    <?php foreach ($listBookings as $booking): 
                        // Định dạng ngày và tiền tệ
                        $bookingDate = date('d/m/Y', strtotime($booking['booking_date']));
                        $startDate = date('d/m/Y', strtotime($booking['start_date']));
                        $totalPrice = number_format($booking['total_price'], 0, ',', '.') . ' VNĐ';
                    ?>
                        <tr>
                            <td><?= $booking['id'] ?></td>
                            <td><?= htmlspecialchars($booking['tour_name'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($startDate) ?></td>
                            <td><?= htmlspecialchars($booking['customer_name'] ?? 'Khách lẻ') ?></td>
                            <td><?= htmlspecialchars($totalPrice) ?></td>
                            
                            <td>
                                <span class="badge 
                                    <?php 
                                        $status = strtolower($booking['status']);
                                        if ($status == 'confirmed') {
                                            echo 'bg-success'; // Màu xanh lá cây
                                        } elseif ($status == 'cancelled') {
                                            echo 'bg-danger'; // Màu đỏ
                                        } else {
                                            echo 'bg-warning text-dark'; // Màu vàng cho Pending
                                        }
                                    ?>
                                ">
                                    <?= htmlspecialchars($booking['status']) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($bookingDate) ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>?action=detail-booking&id=<?= $booking['id'] ?>" class="btn view"><i class="fas fa-eye"></i></a>
                                
                                <a href="<?= BASE_URL ?>?action=update-booking&id=<?= $booking['id'] ?>" class="btn edit"><i class="fas fa-edit"></i></a>
                                
                                <a href="<?= BASE_URL ?>?action=delete-booking&id=<?= $booking['id'] ?>" 
                                   onclick="return confirm('Xác nhận HỦY đơn đặt tour ID: <?= $booking['id'] ?>?')" 
                                   class="btn delete"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align:center;">Chưa có đơn đặt tour nào được ghi nhận.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>