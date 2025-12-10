<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Quản lý Yêu cầu Tour Tùy chỉnh (<?= count($listRequests) ?>)</h2>

    <?php if (empty($listRequests)): ?>
        <div class="alert alert-info mt-4">
            Hiện chưa có yêu cầu đặt tour tùy chỉnh nào mới.
        </div>
    <?php else: ?>
        <table class="table table-striped table-bordered table-sm mt-4">
            <thead>
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 20%;">Khách hàng</th>
                    <th style="width: 20%;">Điểm đến & Yêu cầu</th>
                    <th style="width: 10%;">Số người</th>
                    <th style="width: 15%;">Ngày khởi hành</th>
                    <th style="width: 15%;">Ngày yêu cầu</th>
                    <th style="width: 10%;">Trạng thái</th>
                    <th style="width: 5%;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listRequests as $req): ?>
                    <tr>
                        <td><?= $req['id'] ?></td>
                        <td>
                            <strong><?= $req['customer_name'] ?></strong><br>
                            <small>SĐT: <?= $req['customer_phone'] ?></small><br>
                            <small>Email: <?= $req['customer_email'] ?></small>
                        </td>
                        <td>
                            <p class="mb-0">
                                <?= nl2br(substr($req['destination_notes'], 0, 80)) ?>...
                            </p>
                            <small class="text-muted">Ngân sách: <?= number_format($req['budget_range'] ?? 0) ?> đ</small>
                        </td>
                        <td><?= $req['num_people'] ?></td>
                        <td><?= $req['desired_start_date'] ?? 'Không rõ' ?></td>
                        <td><?= date('Y-m-d H:i', strtotime($req['request_date'])) ?></td>
                        <td>
                            <span class="badge bg-<?= ($req['request_status'] == 'New') ? 'warning' : (($req['request_status'] == 'Quoting') ? 'primary' : 'success') ?>">
                                <?= $req['request_status'] ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>?action=view-request&id=<?= $req['id'] ?>" class="btn btn-sm btn-info text-white" title="Xem chi tiết">
                                Chi tiết
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php include PATH_VIEW . 'layout/footer.php'; ?>