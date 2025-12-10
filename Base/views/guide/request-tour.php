<?php 
$data = $data ?? []; // Dữ liệu POST cũ (sticky data)
?>

<div class="container my-5">
    <h2><?= $title ?? 'Yêu Cầu Tour Tùy Chỉnh' ?></h2>
    
    <?php if (isset($message)): ?>
        <div class="alert alert-info">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <div class="card p-4">
        <form action="<?= BASE_URL ?>?action=request-tour" method="post">
            <p class="text-muted mb-4">Vui lòng điền thông tin chi tiết về chuyến đi mơ ước của bạn. Chúng tôi sẽ thiết kế và gửi báo giá trong vòng 48 giờ.</p>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="customer_name" class="form-label">Họ và Tên (*):</label>
                    <input type="text" name="customer_name" id="customer_name" class="form-control" 
                           value="<?= $data['customer_name'] ?? '' ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="customer_phone" class="form-label">Số điện thoại (*):</label>
                    <input type="tel" name="customer_phone" id="customer_phone" class="form-control" 
                           value="<?= $data['customer_phone'] ?? '' ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="customer_email" class="form-label">Email (Tùy chọn):</label>
                <input type="email" name="customer_email" id="customer_email" class="form-control" 
                       value="<?= $data['customer_email'] ?? '' ?>">
            </div>

            <hr class="my-4">

            <div class="mb-3">
                <label for="destination_notes" class="form-label">Địa điểm/Sở thích mong muốn:</label>
                <textarea name="destination_notes" id="destination_notes" class="form-control" rows="3" required
                       placeholder="Ví dụ: Châu Âu (Pháp, Ý), nghỉ dưỡng biển Phú Quốc, trekking Tây Bắc...">
                       <?= $data['destination_notes'] ?? '' ?>
                </textarea>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="desired_start_date" class="form-label">Ngày khởi hành dự kiến:</label>
                    <input type="date" name="desired_start_date" id="desired_start_date" class="form-control" 
                           value="<?= $data['desired_start_date'] ?? '' ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="num_people" class="form-label">Số lượng người lớn (*):</label>
                    <input type="number" name="num_people" id="num_people" class="form-control" min="1" 
                           value="<?= $data['num_people'] ?? 1 ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="budget_range" class="form-label">Ngân sách dự kiến (cho toàn bộ chuyến đi hoặc mỗi người):</label>
                    <input type="text" name="budget_range" id="budget_range" class="form-control" 
                           value="<?= $data['budget_range'] ?? '' ?>" placeholder="Ví dụ: 20 triệu/người hoặc 100 triệu/tổng cộng">
                </div>
            </div>
            
            <div class="mb-3">
                <label for="special_requests" class="form-label">Yêu cầu đặc biệt (Thức ăn, Khách sạn 5*, Hướng dẫn viên riêng...):</label>
                <textarea name="special_requests" id="special_requests" class="form-control" rows="3">
                    <?= $data['special_requests'] ?? '' ?>
                </textarea>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Gửi Yêu Cầu Thiết Kế Tour</button>
        </form>
        
    </div>
</div>


<a href="<?= BASE_URL ?>?action=my-quotes">
    Xem Báo Giá Tour Tùy Chỉnh Của Tôi
</a>
