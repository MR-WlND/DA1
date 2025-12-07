<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <div class="header-wrapper">
        <div class="header-content">
            <div class="breadcrumb">Báo Cáo</div>
            <h2 class="page-title">Báo cáo Lãi/Lỗ Theo Chuyến Đi</h2>
            <p class="page-sub">Báo cáo Lãi/Lỗ trong hệ thống admin</p>
        </div>
    </div>
    <div class="card p-4">
        <p class="text-muted">Báo cáo tổng hợp doanh thu và chi phí gán cho từng lịch khởi hành.</p>
        
        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th>ID Chuyến</th>
                    <th>Tên Tour</th>
                    <th>Ngày Khởi hành</th>
                    <th>Tổng Thu (Revenue)</th>
                    <th>Tổng Chi (Expense)</th>
                    <th>Lãi Gộp (Net Profit)</th>
                    <th>Hiệu suất</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($profitLossReport)): ?>
                    <?php 
                    $total_net_profit = 0; // Biến tổng lợi nhuận toàn công ty
                    foreach ($profitLossReport as $report):
                        // Tính Lãi gộp
                        $netProfit = $report['total_revenue'] - $report['total_expense'];
                        $total_net_profit += $netProfit;
                        
                        // Xác định màu sắc hiệu suất
                        $profitClass = ($netProfit >= 0) ? 'text-success fw-bold' : 'text-danger fw-bold';
                        $statusText = ($netProfit >= 0) ? 'Lãi' : 'Lỗ';
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($report['departure_id']) ?></td>
                            <td><?= htmlspecialchars($report['tour_name'] ?? 'N/A') ?></td>
                            <td><?= date('d/m/Y', strtotime($report['start_date'])) ?></td>
                            
                            <td><?= number_format($report['total_revenue'] ?? 0, 0, ',', '.') ?> đ</td>
                            
                            <td><?= number_format($report['total_expense'] ?? 0, 0, ',', '.') ?> đ</td>
                            
                            <td class="<?= $profitClass ?>">
                                <?= number_format($netProfit, 0, ',', '.') ?> đ
                            </td>
                            
                            <td>
                                <span class="badge bg-<?= ($netProfit >= 0) ? 'success' : 'danger' ?>"><?= $statusText ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align:center;">Chưa có giao dịch tài chính nào để báo cáo.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-end fw-bold">Tổng Lãi/Lỗ Toàn Hệ Thống:</td>
                    <td colspan="2" class="<?= ($total_net_profit >= 0) ? 'text-success fw-bold' : 'text-danger fw-bold' ?>">
                        <?= number_format($total_net_profit, 0, ',', '.') ?> đ
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>