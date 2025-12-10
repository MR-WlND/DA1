<?php include PATH_VIEW . 'layout/header.php'; 
// Biến $request chứa chi tiết yêu cầu và mảng $request['quotes']
$request = $request ?? []; 
$quotes = $request['quotes'] ?? [];
?>

<div class="main">
    <?php if (!empty($_SESSION['success'])) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['success'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error'])) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['error'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <h2>Yêu cầu Tùy chỉnh #<?= $request['id'] ?></h2>
    <p class="text-muted">Ngày nhận: <?= date('Y-m-d H:i', strtotime($request['request_date'])) ?></p>

    <div class="card p-4 mb-4">
        <div class="row">
            <div class="col-md-4">
                <h4>Thông tin Khách hàng</h4>
                <p><strong>Tên:</strong> <?= $request['customer_name'] ?></p>
                <p><strong>SĐT:</strong> <?= $request['customer_phone'] ?></p>
                <p><strong>Email:</strong> <?= $request['customer_email'] ?? '---' ?></p>
            </div>
            <div class="col-md-4">
                <h4>Chi tiết Yêu cầu</h4>
                <p><strong>Số người:</strong> <?= $request['num_people'] ?></p>
                <p><strong>Ngày dự kiến:</strong> <?= $request['desired_start_date'] ?? 'Không rõ' ?></p>
                <p><strong>Ngân sách:</strong> <?= number_format($request['budget_range'] ?? 0) ?> đ</p>
            </div>
            <div class="col-md-4">
                <h4>Trạng thái</h4>
                <p>
                    <span class="badge bg-<?= ($request['request_status'] == 'New') ? 'warning' : (($request['request_status'] == 'Quoting') ? 'primary' : 'success') ?>">
                        <?= $request['request_status'] ?>
                    </span>
                </p>
                <form action="<?= BASE_URL ?>?action=update-request-status" method="post" class="mt-2">
                    <input type="hidden" name="request_id" value="<?= $request['id'] ?>">
                    <select name="status" class="form-control form-control-sm mb-2">
                        <option value="New" <?= ($request['request_status'] == 'New') ? 'selected' : '' ?>>New</option>
                        <option value="Quoting" <?= ($request['request_status'] == 'Quoting') ? 'selected' : '' ?>>Quoting</option>
                        <option value="Accepted" <?= ($request['request_status'] == 'Accepted') ? 'selected' : '' ?>>Accepted</option>
                        <option value="Closed" <?= ($request['request_status'] == 'Closed') ? 'selected' : '' ?>>Closed</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-outline-secondary">Cập nhật Trạng thái</button>
                </form>
            </div>
        </div>
        <hr>
        <h4>Ghi chú Yêu cầu (Địa điểm & Sở thích)</h4>
        <div class="alert alert-light p-3">
            <?= nl2br($request['destination_notes']) ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <h3>Báo giá Đã tạo (<?= count($quotes) ?>)</h3>
            <?php if (empty($quotes)): ?>
                <div class="alert alert-warning">Chưa có báo giá nào được tạo cho yêu cầu này.</div>
            <?php else: ?>
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Ngày</th>
                            <th>Giá Cuối</th>
                            <th>Hiệu lực đến</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($quotes as $quote): ?>
                            <tr>
                                <td><?= date('Y-m-d', strtotime($quote['quote_date'])) ?></td>
                                <td><?= number_format($quote['final_price']) ?> đ</td>
                                <td><?= $quote['valid_until'] ?></td>
                                <td><span class="badge bg-primary"><?= $quote['quote_status'] ?></span></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-muted small">
                                    **Tóm tắt Lịch trình:** <?= $quote['itinerary_draft'] ?>
                                    <br>**(Người tạo: <?= $quote['staff_name'] ?? 'Admin' ?>)**
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        
        <div class="col-md-6">
            <h3>+ Tạo Báo giá Mới</h3>
            <div class="card p-3">
                <form action="<?= BASE_URL ?>?action=submit-quote" method="post">
                    <input type="hidden" name="request_id" value="<?= $request['id'] ?>">
                    <input type="hidden" name="staff_id" value="<?= $_SESSION['user']['id'] ?? '' ?>">
                    
                    <div class="mb-3">
                        <label for="final_price" class="form-label">Giá Cuối Cùng (VNĐ):</label>
                        <input type="number" name="final_price" id="final_price" class="form-control" min="0" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="valid_until" class="form-label">Báo giá có hiệu lực đến ngày:</label>
                        <input type="date" name="valid_until" id="valid_until" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="itinerary_draft" class="form-label">Tóm tắt Lịch trình Đề xuất:</label>
                        <textarea name="itinerary_draft" id="itinerary_draft" class="form-control" rows="3" required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-success">Gửi Báo giá (Quote)</button>
                </form>
            </div>
        </div>
    </div>
    
    <a href="<?= BASE_URL ?>?action=list-requests" class="btn btn-secondary mt-4">← Quay lại danh sách Yêu cầu</a>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>