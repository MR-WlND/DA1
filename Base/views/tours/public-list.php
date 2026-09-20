<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Danh mục Tour Khám phá</h2>
        <form action="" method="get" class="d-flex">
            <input type="hidden" name="action" value="public-tours">
            <select name="category_id" class="form-select me-2" onchange="this.form.submit()">
                <option value="">-- Tất cả danh mục --</option>
                <?php if (!empty($listCategories)): ?>
                    <?php foreach ($listCategories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= (isset($_GET['category_id']) && $_GET['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name'] ?? '') ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Lọc</button>
        </form>
    </div>

    <div class="row">
        <?php if (!empty($listTours)): ?>
            <?php foreach ($listTours as $tour): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <?php 
                        $imgUrl = 'assets/images/default-tour.jpg'; // default
                        if (!empty($tour['gallery']) && isset($tour['gallery'][0]['image_url'])) {
                            $imgUrl = BASE_URL . 'assets/uploads/' . $tour['gallery'][0]['image_url'];
                        }
                        ?>
                        <img src="<?= $imgUrl ?>" class="card-img-top" alt="<?= htmlspecialchars($tour['name'] ?? '') ?>" style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($tour['name'] ?? '') ?></h5>
                            <p class="card-text text-muted mb-2">
                                <i class="fas fa-tag"></i> <?= htmlspecialchars($tour['category_name'] ?? 'Chưa phân loại') ?> <br>
                                <i class="fas fa-money-bill-wave"></i> Từ <?= number_format($tour['base_price'] ?? 0, 0, ',', '.') ?> đ
                            </p>
                            <p class="card-text flex-grow-1" style="font-size: 0.9rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                                <?= htmlspecialchars(strip_tags($tour['description'] ?? '')) ?>
                            </p>
                            <a href="<?= BASE_URL ?>?action=public-detail-tour&id=<?= $tour['id'] ?>" class="btn btn-outline-primary mt-auto w-100">Xem Chi Tiết</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">Chưa có tour nào để hiển thị.</div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
