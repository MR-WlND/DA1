<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
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
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>