<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Quản lý Nhà Cung Cấp Vận Tải</h2>
    <div class="card">
        <div class="toph4">
            <h4>Danh sách Nhà Cung Cấp</h4>
            <a href="<?= BASE_URL ?>?action=create-supplier" class="btn btn-nut">+ Thêm NCC Vận Tải</a>
        </div>
        
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên NCC</th>
                    <th>Người liên hệ</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Ghi chú</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($listSuppliers)): ?>
                    <?php foreach ($listSuppliers as $supplier): ?>
                        <tr>
                            <td><?= $supplier['id'] ?></td>
                            <td><?= $supplier['supplier_name'] ?? '' ?></td>
                            <td><?= $supplier['contact_person'] ?? '' ?></td>
                            <td><?= $supplier['phone'] ?? '' ?></td>
                            <td><?= $supplier['email'] ?? '' ?></td>
                            <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                <?= $supplier['details'] ?? '' ?>
                            </td>
                            <td>
                                <a href="<?= BASE_URL ?>?action=update-supplier&id=<?= $supplier['id'] ?>" class="btn edit"><i class="fas fa-edit"></i> </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align:center;">Chưa có Nhà cung cấp vận tải nào được thêm vào hệ thống.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>