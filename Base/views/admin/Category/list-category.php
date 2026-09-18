<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <!-- Session Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success" style="padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; margin-bottom: 20px;">
            <?= $_SESSION['success'] ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger" style="padding: 15px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px; margin-bottom: 20px;">
            <?= $_SESSION['error'] ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="header-wrapper">
        <div class="header-content">
            <div class="breadcrumb">Quản Lý Tour / Danh Mục Tour</div>
            <h2 class="page-title">Danh Mục Tour</h2>
            <p class="page-sub">Quản lý toàn bộ danh mục tour trong hệ thống admin</p>
        </div>
    </div>
    <div class="card">
        <div class="toph4">
            <h4>Danh sách danh mục tour<h4>
                    <a href="<?= BASE_URL ?>?action=create-category" class="btn btn-nut">+ Thêm danh mục</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Mô tả</th>
                    <th>Ngày tạo</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listCategory as $category): ?>
                    <tr>
                        <td><?= $category['id'] ?></td>
                        <td><?= $category['name'] ?></td>
                        <td><?= $category['description'] ?></td>
                        <td><?= date('d/m/Y', strtotime($category['created_at'])) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>?action=update-category&id=<?= $category['id'] ?>" class="btn edit"><i class="fas fa-edit"></i></a>
                            <a href="<?= BASE_URL ?>?action=delete-category&id=<?= $category['id'] ?>"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?')"
                                class="btn delete"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>