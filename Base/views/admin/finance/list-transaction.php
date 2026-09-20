<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Quản lý Giao dịch Tài chính</h2>
        <a href="<?= BASE_URL ?>?action=create-transaction" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm Giao dịch
        </a>
    </div>

    <div class="card">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Chuyến đi (ID)</th>
                    <th>Loại GD</th>
                    <th>Số tiền</th>
                    <th>Mô tả</th>
                    <th>Ngày GD</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($listTransactions)): ?>
                    <?php foreach ($listTransactions as $tx): ?>
                        <tr>
                            <td><?= $tx['id'] ?></td>
                            <td><?= htmlspecialchars($tx['departure_id'] ?? 'N/A') ?></td>
                            <td>
                                <?php if (($tx['transaction_type'] ?? '') === 'Revenue'): ?>
                                    <span class="badge bg-success">Thu nhập</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Chi phí</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end text-<?= (($tx['transaction_type'] ?? '') === 'Revenue') ? 'success' : 'danger' ?>">
                                <?= number_format($tx['amount'] ?? 0, 0, ',', '.') ?> VNĐ
                            </td>
                            <td><?= htmlspecialchars($tx['description'] ?? '') ?></td>
                            <td><?= date('d/m/Y', strtotime($tx['transaction_date'])) ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>?action=update-transaction&id=<?= $tx['id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= BASE_URL ?>?action=delete-transaction&id=<?= $tx['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa giao dịch này?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Chưa có giao dịch nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
