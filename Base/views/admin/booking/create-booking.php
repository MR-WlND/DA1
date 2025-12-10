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
            <button type="submit" class="btn btn-success ">Lưu Đơn Đặt Tour</button>
            <a href="<?= BASE_URL ?>?action=list-booking" class="btn btn-secondary">Quay lại Danh sách</a>

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

            <input type="text" name="customer_details[${index}][name]" class="form-control" placeholder="Họ và Tên" required>
            
            <input type="tel" name="customer_details[${index}][phone]" class="form-control" placeholder="SĐT liên hệ" required>

            <input type="date" name="customer_details[${index}][date_of_birth]" class="form-control" title="Ngày sinh">

            <input type="text" name="customer_details[${index}][special_note]" class="form-control" placeholder="Ghi chú đặc biệt (Tùy chọn)">

            <button type="button" 
                    onclick="this.closest('.customer-row').remove(); updatePrice();" 
                    class="btn btn-danger btn-sm">X</button>
        </div>
    `;
        wrapper.insertAdjacentHTML('beforeend', html);
        
        updatePrice(); 
    }

    // Hàm tính toán giá được giữ nguyên
    function updatePrice() {
        const departureSelect = document.getElementById('departure_id');
        const totalInput = document.getElementById('total_price');
        const customerRows = document.querySelectorAll('.customer-row');

        const selectedOption = departureSelect.options[departureSelect.selectedIndex];
        const unitPrice = parseFloat(selectedOption.getAttribute('data-price')) || 0;
        const remainingSlots = parseInt(selectedOption.getAttribute('data-slots')) || 0;

        const numCustomers = customerRows.length;

        const newTotalPrice = unitPrice * numCustomers;

        totalInput.value = newTotalPrice.toFixed(0);

        // UX Check
        if (numCustomers > remainingSlots && remainingSlots !== 0) {
            totalInput.style.border = '2px solid red';
            console.warn(`Cảnh báo: Số lượng khách (${numCustomers}) vượt quá số chỗ còn lại (${remainingSlots}).`);
        } else {
            totalInput.style.border = '';
        }
    }

    // KHỞI TẠO CUỐI CÙNG: 
    document.addEventListener('DOMContentLoaded', function() {
        addCustomer();
        // 🟢 Thêm Event Listener cho sự kiện thay đổi chuyến đi để tính lại giá
        document.getElementById('departure_id').addEventListener('change', updatePrice);
        updatePrice(); 
    });
</script>