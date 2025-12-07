<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <div class="header-wrapper">
        <div class="header-content">
            <div class="breadcrumb">Quản Lý đặt chỗ / Phân Bổ Tài Nguyên</div>
            <h2 class="page-title">Phân bổ Tài nguyên</h2>
            <p class="page-sub">Quản lý toàn bộ danh sách phân bổ tài nguyên trong hệ thống admin</p>
        </div>
    </div>
    <div class="card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="m-0">Danh sách phân bổ tài nguyên</h2>
        <a href="<?= BASE_URL ?>?action=create-resource" class="btn btn-primary"><i class="fas fa-plus"></i> Thêm Phân bổ Mới</a>
    </div>
    

        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th width="10%">ID</th>
                    <th width="20%">Tour</th>
                    <th width="15%">Ngày Khởi hành</th>
                    <th width="15%">Loại Tài nguyên</th>
                    <th width="20%">Tên Tài nguyên</th>
                    <th width="12%">Chi phí</th>
                    <th width="8%">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($listResources)): ?>
                    <?php foreach ($listResources as $resource): ?>
                        <tr>
                            <td><code><?= $resource['id'] ?></code></td>
                            <td>
                                <strong><?= htmlspecialchars($resource['tour_name'] ?? 'N/A') ?></strong>
                            </td>
                            <td><small><?= date('d/m/Y', strtotime($resource['start_date'])) ?></small></td>
                            <td>
                                <span class="badge 
                                    <?php
                                    $type = strtolower($resource['resource_type'] ?? '');
                                    if ($type == 'guide') echo 'bg-info';
                                    elseif ($type == 'hotel') echo 'bg-primary';
                                    elseif ($type == 'transport') echo 'bg-success';
                                    else echo 'bg-secondary';
                                    ?>
                                ">
                                    <i class="fas 
                                        <?php
                                        if ($type == 'guide') echo 'fa-person';
                                        elseif ($type == 'hotel') echo 'fa-hotel';
                                        elseif ($type == 'transport') echo 'fa-car';
                                        else echo 'fa-info-circle';
                                        ?>
                                    "></i>
                                    <?= ucfirst($resource['resource_type']) ?>
                                </span>
                            </td>
                            <td>
                                <?= htmlspecialchars($resource['resource_name'] ?? 'Không xác định') ?>
                                <?php if (!empty($resource['details'])): ?>
                                    <br><small class="text-muted">Ghi chú: <?= htmlspecialchars(substr($resource['details'], 0, 30)) ?>...</small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?= number_format($resource['cost'] ?? 0) ?></strong> VNĐ
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="<?= BASE_URL ?>?action=update-resource&id=<?= $resource['id'] ?>" class="btn btn-outline-primary" title="Chỉnh sửa"><i class="fas fa-edit"></i></a>
                                    <a href="<?= BASE_URL ?>?action=delete-resource&id=<?= $resource['id'] ?>" onclick="return confirm('Xác nhận xóa?')" class="btn btn-outline-danger" title="Xóa"><i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align:center;">Chưa có phân công tài nguyên nào được thiết lập.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>