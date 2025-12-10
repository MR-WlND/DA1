<?php 
// File: views/admin/reports/list-profit-loss.php
include PATH_VIEW . 'layout/header.php'; 

$profitLossReport = $data['profitLossReport'] ?? [];
?>

<div class="main">
    <div class="header-wrapper">
        <div class="header-content">
            <div class="breadcrumb">Báo Cáo / Tài Chính</div>
            <h2 class="page-title">Báo cáo Hiệu suất Lợi nhuận</h2>
        </div>
    </div>
    
    <div class="card p-4">
        <div class="alert alert-info mb-4">
            <i class="fas fa-info-circle"></i> 
            Doanh thu được tính từ các đơn hàng <b>đã thanh toán (Paid)</b>. Chi phí bao gồm phân bổ tài nguyên và các khoản chi khác.
        </div>

        <table class="table table-bordered table-hover mt-2">
            <thead class="table-light">
                <tr>
                    <th>ID Chuyến</th>
                    <th>Tên Tour</th>
                    <th>Ngày Khởi hành</th>
                    <th class="text-end">Tổng Thu (Revenue)</th>
                    <th class="text-end">Tổng Chi (Expense)</th>
                    <th class="text-end">Lãi Gộp</th>
                    <th class="text-center">Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $total_net_profit = 0; 
                    $total_revenue_all = 0; 
                    $total_expense_all = 0; 
                ?>
                <?php if (!empty($profitLossReport)): ?>
                    <?php foreach ($profitLossReport as $report):
                        $netProfit = $report['total_revenue'] - $report['total_expense'];
                        
                        // Cộng dồn tổng
                        $total_net_profit += $netProfit;
                        $total_revenue_all += $report['total_revenue'];
                        $total_expense_all += $report['total_expense'];
                        
                        $profitClass = ($netProfit >= 0) ? 'text-success' : 'text-danger';
                    ?>
                        <tr>
                            <td>#<?= $report['departure_id'] ?></td>
                            <td><?= htmlspecialchars($report['tour_name']) ?></td>
                            <td><?= date('d/m/Y', strtotime($report['start_date'])) ?></td>
                            
                            <td class="text-end text-primary"><?= number_format($report['total_revenue']) ?> đ</td>
                            <td class="text-end text-warning"><?= number_format($report['total_expense']) ?> đ</td>
                            
                            <td class="text-end fw-bold <?= $profitClass ?>">
                                <?= number_format($netProfit) ?> đ
                            </td>
                            
                            <td class="text-center">
                                <?php if ($netProfit > 0): ?>
                                    <span class="badge bg-success">Lãi</span>
                                <?php elseif ($netProfit < 0): ?>
                                    <span class="badge bg-danger">Lỗ</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Hòa vốn</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            Chưa có dữ liệu tài chính nào để báo cáo.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
            
            <!-- FOOTER TỔNG KẾT -->
            <tfoot class="bg-light fw-bold">
                <tr>
                    <td colspan="3" class="text-end">TỔNG CỘNG TOÀN HỆ THỐNG:</td>
                    <td class="text-end text-primary"><?= number_format($total_revenue_all) ?> đ</td>
                    <td class="text-end text-warning"><?= number_format($total_expense_all) ?> đ</td>
                    <td class="text-end <?= ($total_net_profit >= 0) ? 'text-success' : 'text-danger' ?>">
                        <?= number_format($total_net_profit) ?> đ
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>