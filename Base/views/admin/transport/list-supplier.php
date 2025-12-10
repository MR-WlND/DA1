<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <div class="header-wrapper">
        <div class="header-content">
            <div class="breadcrumb">Quản Lý Khách Sạn & NCC / NCC Vận Tải</div>
            <h2 class="page-title">Quản lý NCC Vận Tải</h2>
            <p class="page-sub">Quản lý toàn bộ NCC vận tải trong hệ thống admin</p>
        </div>
    </div>
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
                                <a href="<?= BASE_URL ?>?action=delete-supplier&id=<?= $supplier['id'] ?? '' ?>"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa NCC này không?')"
                                    class="btn delete"><i class="fas fa-trash"></i></a>
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