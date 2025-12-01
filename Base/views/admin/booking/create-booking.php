<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Tạo Đơn đặt Tour mới</h2>
    <div class="card p-4">
        <form action="<?= BASE_URL ?>?action=create-booking" method="post">
            
            <fieldset class="mb-4 border p-3">
                <legend class="fs-5 fw-bold text-primary">1. Thông tin Đặt Tour</legend>

                <div class="form-group mb-3">
                    <label for="departure_id" class="form-label">Chọn Chuyến Khởi Hành:</label>
                    <select name="departure_id" id="departure_id" class="form-control" required 
                            onchange="updatePrice(this.value)">
                        <option value="">-- Chọn chuyến đi --</option>
                        <?php foreach ($listDepartures as $dep): ?>
                            <option 
                                value="<?= $dep['departure_id'] ?>" 
                                data-price="<?= $dep['current_price'] ?>"
                                data-slots="<?= $dep['remaining_slots'] ?>">
                                
                                <?= $dep['tour_name'] ?? 'N/A' ?> 
                                (<?= date('d/m/Y', strtotime($dep['start_date'])) ?>) - Giá: <?= number_format($dep['current_price']) ?> VNĐ
                                [Còn: <?= $dep['remaining_slots'] ?> chỗ]
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="user_id" class="form-label">Khách hàng Đặt (User ID):</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <?php foreach ($listUsers as $user): ?>
                            <option value="<?= $user['id'] ?>">
                                <?= $user['name'] ?> (<?= $user['email'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="total_price" class="form-label">Tổng Giá trị Đơn hàng (VNĐ):</label>
                    <input type="number" name="total_price" id="total_price" class="form-control" required min="0" placeholder="Tổng tiền đã tính cho tất cả khách">
                </div>
                
                <div class="form-group mb-3">
                    <label for="status" class="form-label">Trạng thái Ban đầu:</label>
                    <select name="status" id="status" class="form-control">
                        <option value="Pending" selected>Pending (Chờ xác nhận)</option>
                        <option value="Confirmed">Confirmed (Đã xác nhận)</option>
                        <option value="Cancelled">Cancelled (Đã hủy)</option>
                    </select>
                </div>
            </fieldset>

            <fieldset class="mb-4 border p-3">
                <legend class="fs-5 fw-bold text-primary">2. Chi tiết Khách tham gia</legend>
                
                <div id="customers-wrapper">
                    </div>

                <button type="button" onclick="addCustomer()" class="btn btn-secondary btn-sm mt-3">
                    + Thêm Khách hàng
                </button>
            </fieldset>

            <button type="submit" class="btn btn-success w-100">Lưu Đơn Đặt Tour</button>
        </form>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>

<script>
let customerIndex = 0;

// Hàm tạo form input động cho khách tham gia
function addCustomer() {
    const wrapper = document.getElementById('customers-wrapper');
    const index = customerIndex++; // Tăng index sau khi sử dụng

    const html = `
        <div class="customer-row d-flex gap-2 mb-2 p-2 border-bottom align-items-center">
            
            <span class="fw-bold">Khách ${index + 1}:</span>

            <input type="text" name="customers[${index}][name]" class="form-control" placeholder="Họ và Tên" required>
            
            <input type="tel" name="customers[${index}][phone]" class="form-control" placeholder="SĐT liên hệ" required>

            <input type="text" name="customers[${index}][special_note]" class="form-control" placeholder="Ghi chú đặc biệt (Tùy chọn)">

            <button type="button" onclick="this.closest('.customer-row').remove()" class="btn btn-danger btn-sm">X</button>
        </div>
    `;
    wrapper.insertAdjacentHTML('beforeend', html);
}

// Khởi tạo form với ít nhất 1 dòng khách hàng khi tải trang
document.addEventListener('DOMContentLoaded', function() {
    addCustomer(); 
});

// Bạn có thể thêm hàm updatePrice() ở đây nếu muốn tự động tính giá dựa trên số lượng khách
/*
function updatePrice(departureId) {
    // Logic để tính total_price
}
*/
</script>