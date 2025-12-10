<?php include PATH_VIEW . 'layout/header.php'; ?>
<div class="main">
    <div class="row mt-5">
        <div class="col-md-12">
            <h3 class="mb-4">Nhật ký Hoạt động Chuyến đi (Tour Logs)</h3>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-secondary text-white">Thêm Ghi chú/Hoạt động mới</div>
                <div class="card-body">
                    <form action="<?= BASE_URL ?>?action=add-departure-log" method="post">
                        <input type="hidden" name="departure_id" value="<?= $departure['id'] ?? '' ?>">

                        <div class="mb-3">
                            <label class="form-label">Loại Log:</label>
                            <select name="log_type" class="form-control">
                                <option value="note">Ghi chú (Note)</option>
                                <option value="check">Kiểm tra (Check)</option>
                                <option value="expense">Chi phí (Expense)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nội dung Ghi chú:</label>
                            <textarea name="log_content" class="form-control" rows="3" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Ghi Log</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">Lịch sử Log</div>
                <div class="card-body log-history" style="max-height: 400px; overflow-y: auto;">
                    <?php
                    // 🟢 TRUY CẬP BIẾN $departureLogs (được Controller truyền trực tiếp)
                    // Nếu $departureLogs chưa được định nghĩa ở đầu file, bạn cần thêm:
                    // $departureLogs = $data['departureLogs'] ?? []; 
                    ?>

                    <?php if (!empty($departureLogs)): ?>
                        <ul class="list-unstyled">
                            <?php foreach ($departureLogs as $log): ?>
                                <li class="mb-3 border-bottom pb-2">
                                    <span class="badge bg-<?= ($log['log_type'] == 'expense' ? 'danger' : ($log['log_type'] == 'check' ? 'success' : 'info')) ?>">
                                        <?= ucfirst($log['log_type']) ?>
                                    </span>

                                    <strong>[<?= date('H:i d/m/Y', strtotime($log['log_date'])) ?>]</strong> bởi
                                    <em><?= $log['staff_name'] ?? 'Admin' ?></em>:
                                    <p class="mb-0 text-dark"><?= $log['log_content'] ?></p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted">Chuyến đi này chưa có ghi chú hoạt động nào.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include PATH_VIEW . 'layout/footer.php'; ?>