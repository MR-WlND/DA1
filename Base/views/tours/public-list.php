<?php include PATH_VIEW . 'layout/client-header.php'; ?>

<!-- HERO BANNER -->
<section class="hero-banner">
    <div class="hero-bg"></div>
    <div class="hero-content">
        <div class="hero-tag">✨ Khám phá · Trải nghiệm · Lưu giữ kỷ niệm</div>
        <h1>Khám Phá Thế Giới Qua Lăng Kính Tinh Tế Của Người Nhật</h1>
        <p class="hero-sub">Chúng tôi thiết kế mỗi hành trình như một tác phẩm nghệ thuật – nơi trải nghiệm chân thực gặp gỡ tiện nghi hiện đại.</p>
        <div class="hero-stats">
            <div class="hero-stat">
                <div class="num"><?= count($listTours ?? []) ?>+</div>
                <div class="lbl">Tour đang mở</div>
            </div>
            <div class="hero-stat">
                <div class="num">50+</div>
                <div class="lbl">Điểm đến</div>
            </div>
            <div class="hero-stat">
                <div class="num">10k+</div>
                <div class="lbl">Khách hài lòng</div>
            </div>
        </div>
    </div>
</section>

<!-- SEARCH BAR -->
<div style="padding: 0 24px;">
    <div class="search-bar-wrap">
        <form method="get" action="">
            <input type="hidden" name="action" value="public-tours">
            <div class="sb-inner">
                <div class="sb-field">
                    <label>Điểm đến</label>
                    <input type="text" name="q" placeholder="Bạn muốn đi đâu?" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                </div>
                <div class="sb-field">
                    <label>Danh mục tour</label>
                    <select name="category_id">
                        <option value="">Tất cả danh mục</option>
                        <?php foreach ($listCategories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= (isset($_GET['category_id']) && $_GET['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name'] ?? '') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="sb-field">
                    <label>Loại tour</label>
                    <select name="tour_type">
                        <option value="">Tất cả loại</option>
                        <option value="Nội địa" <?= (($_GET['tour_type'] ?? '') === 'Nội địa') ? 'selected' : '' ?>>Nội địa</option>
                        <option value="Quốc tế" <?= (($_GET['tour_type'] ?? '') === 'Quốc tế') ? 'selected' : '' ?>>Quốc tế</option>
                    </select>
                </div>
                <button type="submit" class="sb-btn">
                    <i class="fas fa-search"></i> Tìm Kiếm
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="client-container">

    <!-- SIDEBAR FILTER -->
    <aside class="sidebar-filter">
        <div class="filter-card">
            <h4>Danh mục Tour</h4>
            <a href="<?= BASE_URL ?>?action=public-tours" class="filter-item <?= empty($_GET['category_id']) ? 'active' : '' ?>">
                <span class="dot"></span> Tất cả
                <span class="count"><?= count($listTours ?? []) ?></span>
            </a>
            <?php foreach ($listCategories as $cat): 
                $catCount = count(array_filter($listTours ?? [], fn($t) => ($t['category_id'] ?? null) == $cat['id']));
            ?>
            <a href="<?= BASE_URL ?>?action=public-tours&category_id=<?= $cat['id'] ?>" class="filter-item <?= (isset($_GET['category_id']) && $_GET['category_id'] == $cat['id']) ? 'active' : '' ?>">
                <span class="dot"></span>
                <?= htmlspecialchars($cat['name'] ?? '') ?>
                <span class="count"><?= $catCount ?></span>
            </a>
            <?php endforeach; ?>
        </div>

        <div class="filter-card">
            <h4>Loại hình</h4>
            <a href="<?= BASE_URL ?>?action=public-tours" class="filter-item <?= empty($_GET['tour_type']) ? 'active' : '' ?>">
                <span class="dot"></span> Tất cả
            </a>
            <a href="<?= BASE_URL ?>?action=public-tours&tour_type=Nội địa" class="filter-item <?= (($_GET['tour_type'] ?? '') === 'Nội địa') ? 'active' : '' ?>">
                <span class="dot"></span> Nội địa
            </a>
            <a href="<?= BASE_URL ?>?action=public-tours&tour_type=Quốc tế" class="filter-item <?= (($_GET['tour_type'] ?? '') === 'Quốc tế') ? 'active' : '' ?>">
                <span class="dot"></span> Quốc tế
            </a>
        </div>

        <div class="filter-card">
            <h4>Liên hệ nhanh</h4>
            <p style="font-size:0.82rem;color:#888;line-height:1.6;">
                <i class="fas fa-phone-alt" style="color:#c0392b;margin-right:6px;"></i> 1800 xxxx<br>
                <i class="fas fa-envelope" style="color:#c0392b;margin-right:6px;"></i> support@globetrek.vn<br>
                <i class="fas fa-clock" style="color:#c0392b;margin-right:6px;"></i> 7:00 – 22:00 hàng ngày
            </p>
            <a href="<?= BASE_URL ?>?action=request-tour" style="display:block;margin-top:14px;padding:10px;background:#fef0ef;border-radius:8px;text-align:center;font-size:0.85rem;font-weight:700;color:#c0392b;text-decoration:none;transition:background 0.18s;">
                <i class="fas fa-suitcase-rolling me-1"></i> Đặt Tour Tùy Chỉnh
            </a>
        </div>
    </aside>

    <!-- TOUR LIST -->
    <div>
        <div class="tours-header">
            <div>
                <h2>Tất cả Tours</h2>
                <span class="result-count"><?= count($listTours ?? []) ?> kết quả</span>
            </div>
            <div class="sort-tabs">
                <button class="sort-tab active">Phổ biến</button>
                <button class="sort-tab">Mới nhất</button>
                <button class="sort-tab">Giá thấp</button>
                <button class="sort-tab">Giá cao</button>
            </div>
        </div>

        <?php
        // Apply tour_type filter if set
        $displayTours = $listTours ?? [];
        $qFilter = strtolower(trim($_GET['q'] ?? ''));
        $typeFilter = $_GET['tour_type'] ?? '';
        if ($typeFilter) {
            $displayTours = array_filter($displayTours, fn($t) => ($t['tour_type'] ?? '') === $typeFilter);
        }
        if ($qFilter) {
            $displayTours = array_filter($displayTours, fn($t) => 
                str_contains(strtolower($t['name'] ?? ''), $qFilter) || 
                str_contains(strtolower($t['description'] ?? ''), $qFilter)
            );
        }
        ?>

        <div class="tour-grid">
            <?php if (!empty($displayTours)): ?>
                <?php foreach ($displayTours as $tour): ?>
                    <?php
                    $imgUrl = 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=600&q=70';
                    if (!empty($tour['gallery'])) {
                        foreach ($tour['gallery'] as $img) {
                            if (!empty($img['is_featured']) && !empty($img['image_url'])) {
                                $imgUrl = BASE_URL . 'assets/uploads/' . $img['image_url'];
                                break;
                            }
                        }
                        if ($imgUrl === 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=600&q=70' && !empty($tour['gallery'][0]['image_url'])) {
                            $imgUrl = BASE_URL . 'assets/uploads/' . $tour['gallery'][0]['image_url'];
                        }
                    }
                    $isInternational = ($tour['tour_type'] ?? '') === 'Quốc tế';
                    ?>
                    <div class="tour-card-wrap">
                        <a href="<?= BASE_URL ?>?action=public-detail-tour&id=<?= $tour['id'] ?>" class="tour-card">
                            <div class="tour-card-img">
                                <img src="<?= htmlspecialchars($imgUrl) ?>"
                                     alt="<?= htmlspecialchars($tour['name'] ?? '') ?>"
                                     loading="lazy"
                                     onerror="this.src='https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=600&q=70'">
                                <span class="tour-card-badge <?= $isInternational ? '' : 'domestic' ?>">
                                    <?= $isInternational ? 'Quốc Tế' : 'Nội Địa' ?>
                                </span>
                                <div class="tour-card-save" onclick="event.preventDefault(); this.innerHTML='<i class=\'fas fa-heart\'></i>'; this.style.color='#e74c3c';">
                                    <i class="far fa-heart"></i>
                                </div>
                            </div>
                            <div class="tour-card-body">
                                <div class="tour-cat-tag">
                                    <i class="fas fa-tag"></i>
                                    <?= htmlspecialchars($tour['category_name'] ?? 'Du lịch') ?>
                                </div>
                                <div class="tour-card-title"><?= htmlspecialchars($tour['name'] ?? '') ?></div>
                                <div class="tour-card-desc"><?= htmlspecialchars(strip_tags($tour['description'] ?? '')) ?></div>
                                <div class="tour-card-footer">
                                    <div class="tour-price">
                                        Giá từ
                                        <strong><?= number_format($tour['base_price'] ?? 0, 0, ',', '.') ?><span>đ</span></strong>
                                    </div>
                                    <span class="btn-detail">Chi Tiết</span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-map-marked-alt"></i>
                    <p style="font-size:1.1rem;font-weight:700;color:#555;margin-bottom:8px;">Không tìm thấy tour phù hợp</p>
                    <p style="font-size:0.9rem;">Hãy thử thay đổi bộ lọc hoặc tìm kiếm với từ khóa khác.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include PATH_VIEW . 'layout/client-footer.php'; ?>
