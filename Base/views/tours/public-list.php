<?php include PATH_VIEW . 'layout/client-header.php'; ?>

<!-- HERO BANNER -->
<section class="hero-banner">
    <div class="hero-bg"></div>
    <div class="hero-content">
        <div class="hero-breadcrumb">
            <a href="<?= BASE_URL ?>?action=public-tours">Trang chủ</a>
            <span class="sep">/</span>
            <span>Tuyển Tập Trải Nghiệm Tinh Tuyển</span>
        </div>
        
        <div class="hero-tag-wrap">
            <span class="hero-tag">• HÀNH TRÌNH VƯƠN RA THẾ GIỚI - TRIẾT LÝ OMOTENASHI</span>
        </div>
        
        <h1>Khám Phá Thế Giới Qua Lăng Kính Tinh Tế Của Người Nhật</h1>
        <p class="hero-sub">Những chuyến du ngoạn năm châu được chăm chút tĩnh lặng và tỉ mỉ, kết hợp vẻ đẹp kỳ vĩ của thiên nhiên thế giới cùng lòng hiếu khách Omotenashi.</p>
    </div>
</section>

<!-- SEARCH BAR -->
<div style="padding: 0 24px;">
    <div class="search-bar-wrap">
        <form method="get" action="">
            <input type="hidden" name="action" value="public-tours">
            <div class="sb-inner">
                <div class="sb-field">
                    <label>ĐIỂM ĐẾN THẾ GIỚI</label>
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
                    <label>THỜI ĐIỂM LÝ TƯỞNG</label>
                    <select name="tour_type">
                        <option value="">Tất cả loại</option>
                        <option value="Nội địa" <?= (($_GET['tour_type'] ?? '') === 'Nội địa') ? 'selected' : '' ?>>Nội địa</option>
                        <option value="Quốc tế" <?= (($_GET['tour_type'] ?? '') === 'Quốc tế') ? 'selected' : '' ?>>Quốc tế</option>
                    </select>
                </div>
                <div class="sb-field">
                    <label>PHONG CÁCH LỮ HÀNH</label>
                    <select name="style">
                        <option value="">Tất cả phong cách</option>
                    </select>
                </div>
                <button type="submit" class="sb-btn">
                    <i class="fas fa-search"></i> KHÁM PHÁ
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="client-container">

    <!-- SIDEBAR FILTER -->
    <aside class="sidebar-filter">
        <div class="filter-header">
            <h3>BỘ LỌC TINH CHỌN</h3>
            <a href="<?= BASE_URL ?>?action=public-tours" class="reset-filter">Đặt lại</a>
        </div>

        <div class="filter-group">
            <h4>CHỦ ĐỀ TRẢI NGHIỆM</h4>
            <label class="custom-cb"><input type="checkbox" checked><span class="cb-mark"></span><span class="cb-text">Nghỉ Dưỡng Thụy Sĩ & Onsen Alpine</span></label>
            <label class="custom-cb"><input type="checkbox" checked><span class="cb-mark"></span><span class="cb-text">Di Sản Châu Âu & Nghệ Thuật Sống</span></label>
            <label class="custom-cb"><input type="checkbox"><span class="cb-mark"></span><span class="cb-text">Viễn Du Bắc Cực & Cực Quang Tĩnh Lặng</span></label>
            <label class="custom-cb"><input type="checkbox"><span class="cb-mark"></span><span class="cb-text">Kỳ Nghỉ Biển Đảo Riêng Tư (Amalfi & Maldives)</span></label>
        </div>

        <div class="filter-group">
            <h4>ĐIỂM ĐẾN CHÂU LỤC</h4>
            <label class="custom-cb"><input type="checkbox" checked><span class="cb-mark"></span><span class="cb-text">Châu Âu Tinh Tuyển</span></label>
            <label class="custom-cb"><input type="checkbox"><span class="cb-mark"></span><span class="cb-text">Bắc Mỹ Hoang Sơ</span></label>
            <label class="custom-cb"><input type="checkbox"><span class="cb-mark"></span><span class="cb-text">Châu Đại Dương Tự Nhiên</span></label>
            <label class="custom-cb"><input type="checkbox"><span class="cb-mark"></span><span class="cb-text">Con Đường Tơ Lụa & Đông Á</span></label>
        </div>

        <div class="filter-group">
            <div class="fg-title-flex">
                <h4>NGÂN SÁCH TUYỂN CHỌN</h4>
                <span class="fg-val">Dưới 90tr VNĐ</span>
            </div>
            <div class="range-slider">
                <div class="rs-track">
                    <div class="rs-fill" style="width:50%;"></div>
                </div>
                <div class="rs-thumb" style="left:50%;"></div>
            </div>
            <div class="rs-labels">
                <span>30.000.000 đ</span>
                <span>120.000.000 đ</span>
            </div>
        </div>

        <div class="filter-group">
            <h4>THỜI GIAN LƯU TRÚ</h4>
            <label class="custom-radio"><input type="radio" name="dur"><span class="rd-mark"></span><span class="rd-text">4 đến 5 ngày</span></label>
            <label class="custom-radio"><input type="radio" name="dur" checked><span class="rd-mark"></span><span class="rd-text">6 đến 8 ngày (Tiêu chuẩn)</span></label>
            <label class="custom-radio"><input type="radio" name="dur"><span class="rd-mark"></span><span class="rd-text">Trên 9 ngày (Chuyên sâu)</span></label>
        </div>

        <div class="filter-group border-0">
            <h4>QUY CHUẨN OMOTENASHI</h4>
            <div class="check-list">
                <div class="cl-item"><i class="fas fa-check"></i> Đoàn riêng tối đa 10 - 12 khách</div>
                <div class="cl-item"><i class="fas fa-check"></i> Khách sạn & Chateaux 5 sao quốc tế</div>
                <div class="cl-item"><i class="fas fa-check"></i> Concierge & Hướng dẫn viên tinh hoa</div>
                <div class="cl-item"><i class="fas fa-check"></i> Bảo hiểm lữ hành toàn cầu cao cấp</div>
            </div>
        </div>
    </aside>

    <!-- TOUR LIST -->
    <div>
        <div class="tours-header">
            <div class="th-left">
                <h2>Tuyển tập</h2>
                <span class="result-count">(<?= count($listTours ?? []) ?> hành trình)</span>
            </div>
            <div class="th-center">
                <a href="#" class="active">Tất cả thế giới</a>
                <a href="#">Châu Âu Mùa Thu</a>
                <a href="#">Bắc Âu Tĩnh Lặng</a>
                <a href="#">Hải Trình Biển Đảo</a>
            </div>
            <div class="th-right">
                Xếp theo: <strong>Được yêu thích <i class="fas fa-chevron-down" style="font-size:0.7rem; margin-left:4px;"></i></strong>
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
                                <div class="tour-card-save" onclick="event.preventDefault(); this.innerHTML='<i class=\'fas fa-heart\'></i>'; this.style.color='#e74c3c';">
                                    <i class="far fa-heart"></i>
                                </div>
                                <div class="tour-card-duration">7 Ngày 6 Đêm</div>
                            </div>
                            <div class="tour-card-body">
                                <div class="tour-card-meta">
                                    <span class="cat-name"><?= mb_strtoupper(htmlspecialchars($tour['category_name'] ?? 'DU LỊCH'), 'UTF-8') ?></span>
                                    <span class="rating"><i class="fas fa-star"></i> 5.0</span>
                                </div>
                                <h3 class="tour-card-title"><?= htmlspecialchars($tour['name'] ?? '') ?></h3>
                                <div class="tour-card-desc"><?= htmlspecialchars(strip_tags($tour['description'] ?? '')) ?></div>
                                <div class="tour-card-footer">
                                    <div class="price-box">
                                        <span class="pl">Giá trọn gói</span>
                                        <span class="pv"><?= number_format($tour['base_price'] ?? 0, 0, ',', '.') ?> đ</span>
                                    </div>
                                    <span class="btn-detail">CHI TIẾT <i class="fas fa-arrow-right" style="font-size:0.75rem; margin-left:4px;"></i></span>
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
        
        <!-- Pagination Mockup -->
        <div class="pagination-mock">
            <div class="pm-left">Trang 1 / 3 (18 hành trình tuyển chọn)</div>
            <div class="pm-right">
                <a href="#" class="pm-btn"><i class="fas fa-chevron-left"></i></a>
                <a href="#" class="pm-btn active">1</a>
                <a href="#" class="pm-btn">2</a>
                <a href="#" class="pm-btn">3</a>
                <a href="#" class="pm-btn"><i class="fas fa-chevron-right"></i></a>
            </div>
        </div>
    </div>
</div>

<?php include PATH_VIEW . 'layout/client-footer.php'; ?>
