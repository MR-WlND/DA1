<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2 class="mb-4">Chi tiết Phân bổ Tài nguyên</h2>
    
    <?php $resource = $resource ?? []; // Đảm bảo biến tồn tại ?>
    
    <div class="card p-4">
        <h4 class="mb-3">Phân công ID: #<?= htmlspecialchars($resource['id'] ?? 'N/A') ?></h4>

        <fieldset class="mb-5 border p-3">
            <legend class="fs-5 text-secondary">Thông tin Chuyến Khởi Hành</legend>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Tên Tour:</strong> <?= htmlspecialchars($resource['tour_name'] ?? 'Không rõ') ?></p>
                    <p><strong>Ngày Khởi Hành:</strong> <?= date('d/m/Y', strtotime($resource['start_date'] ?? '')) ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>ID Chuyến:</strong> <?= htmlspecialchars($resource['departure_id'] ?? 'N/A') ?></p>
                    <p><strong>Giá Tour (Cơ sở):</strong> <?= number_format($resource['departure_price'] ?? 0) ?> VNĐ</p>
                </div>
            </div>
        </fieldset>

        <fieldset class="mb-5 border p-3">
            <legend class="fs-5 text-secondary">Chi tiết Tài nguyên được Phân bổ</legend>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Loại Phân công:</strong> 
                        <span class="badge bg-primary">
                            <?= htmlspecialchars(ucfirst($resource['resource_type'] ?? 'N/A')) ?>
                        </span>
                    </p>
                    <p><strong>ID Tham chiếu (FK):</strong> 
                        <?= htmlspecialchars($resource['resource_id'] ?? 'N/A') ?>
                    </p>
                </div>
                <div class="col-md-6">
                    <p>
                        <strong>Tên Tài nguyên:</strong> 
                        <span class="text-success fw-bold"><?= htmlspecialchars($resource['resource_name'] ?? 'Không tìm thấy tên') ?></span>
                    </p>
                    <p><strong>Chi phí Dự kiến:</strong> 
                        <?= number_format($resource['cost'] ?? 0, 0, ',', '.') ?> VNĐ
                    </p>
                </div>
            </div>
            <hr>
            <p><strong>Ghi chú/Mô tả Dịch vụ:</strong></p>
            <textarea class="form-control" rows="3" readonly><?= htmlspecialchars($resource['details'] ?? 'Không có ghi chú.') ?></textarea>
        </fieldset>


        <div class="mt-4 pt-3 border-top">
            <a href="<?= BASE_URL ?>?action=update-resource&id=<?= $resource['id'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Sửa Phân công</a>
            <a href="<?= BASE_URL ?>?action=delete-resource&id=<?= $resource['id'] ?>" onclick="return confirm('Xóa phân công này?')" class="btn btn-danger"><i class="fas fa-trash"></i> Xóa</a>
            <a href="<?= BASE_URL ?>?action=list-resource" class="btn btn-secondary">Quay lại Danh sách</a>
        </div>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>