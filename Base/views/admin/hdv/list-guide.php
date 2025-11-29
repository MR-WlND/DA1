<?php include 'views/layout/header.php'; ?>

<div class="main">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
            <h2>Quản lý Hướng dẫn viên</h2>
            <a href="<?= BASE_URL ?>?action=create-guide" class="btn btn-primary btn-lg">+ Thêm HDV mới</a>
        </div>

        <section class="guide-list">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Ảnh</th>
                            <th>Thông tin HDV</th>
                            <th>Liên hệ</th>
                            <th>Phân loại</th>
                            <th>Kinh nghiệm</th>
                            <th>Ngôn ngữ</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listGuide as $guide): ?>
                            <tr>
                                <td class="text-center"><?= $guide['id'] ?></td>

                                <td class="text-center">
                                    <?php if (!empty($guide['photo_url'])): ?>
                                        <img src="<?= BASE_URL . $guide['photo_url'] ?>" alt="Avatar" 
                                             style="width:60px; height:60px; border-radius:50%; object-fit: cover; border: 2px solid #ddd;">
                                    <?php else: ?>
                                        <span class="badge bg-secondary">No Image</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <strong><?= htmlspecialchars($guide['name']) ?></strong>
                                </td>

                                <td>
                                    <div>📧 <?= htmlspecialchars($guide['email']) ?></div>
                                    <div>📞 <?= htmlspecialchars($guide['phone']) ?></div>
                                </td>

                                <td>
                                    <?php if (isset($guide['category']) && $guide['category'] == 'international'): ?>
                                        <span class="badge bg-primary">Quốc tế</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Nội địa</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <?= htmlspecialchars($guide['experience_years'] ?? '0') ?> năm
                                </td>

                                <td>
                                    <?= htmlspecialchars($guide['languages'] ?? '-') ?>
                                </td>

                                <td class="text-center">
                                    <a href="<?= BASE_URL ?>?action=update-guide&id=<?= $guide['id'] ?>" class="btn btn-sm btn-warning mb-1">
                                        <i class="fa fa-edit"></i> Sửa
                                    </a>
                                    <a href="<?= BASE_URL ?>?action=detail-guide&id=<?= $guide['id'] ?>" class="btn btn-sm btn-info mb-1">
                                        <i class="fa fa-eye"></i> Xem
                                    </a>
                                    <a href="<?= BASE_URL ?>?action=delete-guide&id=<?= $guide['id'] ?>" 
                                       onclick="return confirm('Bạn chắc chắn muốn xóa HDV này? Hành động không thể hoàn tác!')" 
                                       class="btn btn-sm btn-danger mb-1">
                                        <i class="fa fa-trash"></i> Xóa
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>