<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Cập nhật Giao dịch Tài chính</h2>
    <div class="card mt-3">
        <form action="<?= BASE_URL ?>?action=update-transaction&id=<?= $data['id'] ?>" method="post">
            <div class="form-group mb-3">
                <label for="departure_id">Chuyến đi (Tùy chọn):</label>
                <select name="departure_id" id="departure_id" class="form-control">
                    <option value="">-- Không gắn với chuyến đi cụ thể --</option>
                    <?php if (!empty($listDepartures)): ?>
                        <?php foreach ($listDepartures as $dep): ?>
                            <option value="<?= $dep['id'] ?>" <?= ($data['departure_id'] == $dep['id']) ? 'selected' : '' ?>>
                                ID: <?= $dep['id'] ?> - <?= htmlspecialchars($dep['tour_name'] ?? '') ?> (<?= $dep['start_date'] ?? '' ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="transaction_type">Loại giao dịch <span class="text-danger">*</span></label>
                <select name="transaction_type" id="transaction_type" class="form-control" required>
                    <option value="Revenue" <?= ($data['transaction_type'] === 'Revenue') ? 'selected' : '' ?>>Thu nhập (Revenue)</option>
                    <option value="Expense" <?= ($data['transaction_type'] === 'Expense') ? 'selected' : '' ?>>Chi phí (Expense)</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="amount">Số tiền (VNĐ) <span class="text-danger">*</span></label>
                <input type="number" name="amount" id="amount" class="form-control" min="0" value="<?= $data['amount'] ?? 0 ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="transaction_date">Ngày giao dịch <span class="text-danger">*</span></label>
                <input type="date" name="transaction_date" id="transaction_date" class="form-control" value="<?= date('Y-m-d', strtotime($data['transaction_date'])) ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="description">Mô tả chi tiết:</label>
                <textarea name="description" id="description" class="form-control" rows="3"><?= htmlspecialchars($data['description'] ?? '') ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Lưu Cập nhật</button>
            <a href="<?= BASE_URL ?>?action=list-transaction" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
