<?php $booking = $data['booking']; ?>

<div class="container my-5">
    <h2>Thanh toán qua Chuyển khoản Ngân hàng</h2>
    <p class="lead">Vui lòng chuyển khoản số tiền **<?= number_format($booking['total_price']) ?> VNĐ**:</p>

    <div class="card p-4 bg-light">
        <h4>Thông tin Tài khoản</h4>
        <p><strong>Ngân hàng:</strong> ACB (Ngân hàng Á Châu)</p>
        <p><strong>Số tài khoản:</strong> 1234 5678 9012 345</p>
        <p><strong>Tên chủ tài khoản:</strong> CÔNG TY DU LỊCH ABC</p>
        <hr>
        <h4>Nội dung Chuyển khoản (BẮT BUỘC)</h4>
        <div class="alert alert-danger font-weight-bold">
            ND<?= $booking['id'] ?>-SDT<?= $data['customerPhone'] ?>
        </div>
        <small class="text-muted">Ghi chú: Vui lòng ghi chính xác nội dung này để chúng tôi xác nhận đơn hàng nhanh chóng.</small>
    </div>

    <div class="mt-4">
        <a href="<?= BASE_URL ?>?action=my-bookings" class="btn btn-primary">Tôi đã chuyển khoản (Quay về đơn hàng)</a>
    </div>
</div>