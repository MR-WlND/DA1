<?php include PATH_VIEW . 'layout/client-header.php'; ?>

<style>
.detail-wrap {
    max-width: 1280px;
    margin: 32px auto;
    padding: 0 24px 60px;
}

.breadcrumb-bar {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.85rem;
    color: #888;
    margin-bottom: 24px;
}
.breadcrumb-bar a { color: #c0392b; text-decoration: none; }
.breadcrumb-bar a:hover { text-decoration: underline; }
.breadcrumb-bar i { font-size: 0.7rem; }

.detail-grid {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 28px;
    align-items: start;
    margin-bottom: 32px;
}

.detail-gallery {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.detail-gallery .main-img {
    width: 100%;
    height: 420px;
    object-fit: cover;
    display: block;
}

.gallery-thumbs {
    display: flex;
    gap: 8px;
    padding: 10px;
    background: #f5f5f5;
    overflow-x: auto;
}

.gallery-thumbs img {
    width: 80px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
    cursor: pointer;
    border: 2px solid transparent;
    transition: border-color 0.18s;
    flex-shrink: 0;
}

.gallery-thumbs img:hover,
.gallery-thumbs img.active {
    border-color: #c0392b;
}

/* Booking card */
.booking-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.1);
    overflow: hidden;
    position: sticky;
    top: 80px;
}

.booking-card-head {
    background: linear-gradient(135deg, #c0392b, #922b21);
    color: #fff;
    padding: 20px 22px;
}

.booking-card-head .price-from {
    font-size: 0.82rem;
    opacity: 0.8;
    margin-bottom: 4px;
}

.booking-card-head .price-main {
    font-size: 2rem;
    font-weight: 800;
    line-height: 1;
}

.booking-card-head .price-main span {
    font-size: 1rem;
    font-weight: 600;
}

.booking-card-body {
    padding: 20px 22px;
}

.booking-card-body .info-row {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 0;
    border-bottom: 1px solid #f0f0f0;
    font-size: 0.875rem;
}

.booking-card-body .info-row:last-of-type {
    border-bottom: none;
    margin-bottom: 16px;
}

.booking-card-body .info-row i {
    width: 20px;
    color: #c0392b;
    text-align: center;
    flex-shrink: 0;
}

.booking-card-body .info-row strong {
    min-width: 90px;
    color: #888;
    font-weight: 500;
}

.departure-select {
    width: 100%;
    padding: 12px 14px;
    border: 1.5px solid #e5e5e5;
    border-radius: 10px;
    font-size: 0.9rem;
    font-family: inherit;
    background: #fafafa;
    outline: none;
    margin-bottom: 14px;
    transition: border-color 0.2s;
    -webkit-appearance: none;
}

.departure-select:focus {
    border-color: #c0392b;
    background: #fff;
}

.btn-book-now {
    display: block;
    width: 100%;
    padding: 14px;
    background: #c0392b;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 700;
    font-family: inherit;
    cursor: pointer;
    text-decoration: none;
    text-align: center;
    transition: background 0.2s, transform 0.15s;
}

.btn-book-now:hover {
    background: #a93226;
    transform: translateY(-1px);
    color: #fff;
}

.btn-book-now.outline {
    background: transparent;
    border: 2px solid #c0392b;
    color: #c0392b;
    margin-top: 10px;
}

.btn-book-now.outline:hover {
    background: #fef0ef;
}

.login-notice {
    background: #fff3cd;
    border: 1px solid #ffd60a;
    border-radius: 8px;
    padding: 12px 14px;
    font-size: 0.85rem;
    color: #856404;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Detail tabs */
.detail-tabs-wrap {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    overflow: hidden;
}

.tab-nav {
    display: flex;
    border-bottom: 2px solid #f0f0f0;
    background: #fafafa;
}

.tab-nav button {
    padding: 16px 28px;
    border: none;
    background: none;
    font-family: inherit;
    font-size: 0.9rem;
    font-weight: 600;
    color: #888;
    cursor: pointer;
    position: relative;
    transition: color 0.2s;
}

.tab-nav button.active {
    color: #c0392b;
}

.tab-nav button.active::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    right: 0;
    height: 2px;
    background: #c0392b;
}

.tab-content-area {
    padding: 28px;
}

.tab-pane-custom { display: none; }
.tab-pane-custom.active { display: block; }

.tab-pane-custom p, .tab-pane-custom li {
    line-height: 1.8;
    color: #555;
    font-size: 0.9rem;
}

.accordion-day {
    border: 1px solid #f0f0f0;
    border-radius: 10px;
    margin-bottom: 10px;
    overflow: hidden;
}

.accordion-day-head {
    padding: 14px 18px;
    background: #fafafa;
    font-weight: 700;
    font-size: 0.9rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: background 0.18s;
}

.accordion-day-head:hover { background: #fef0ef; color: #c0392b; }

.accordion-day-body {
    padding: 16px 18px;
    display: none;
    border-top: 1px solid #f0f0f0;
}

.accordion-day-body.open { display: block; }

.activity-item {
    display: flex;
    gap: 12px;
    margin-bottom: 10px;
    align-items: flex-start;
}

.activity-time {
    background: #c0392b;
    color: #fff;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    white-space: nowrap;
    flex-shrink: 0;
}

@media (max-width: 1024px) {
    .detail-grid { grid-template-columns: 1fr; }
    .booking-card { position: static; }
}
</style>

<div class="detail-wrap">
    <!-- BREADCRUMB -->
    <div class="breadcrumb-bar">
        <a href="<?= BASE_URL ?>?action=public-tours">Trang chủ</a>
        <i class="fas fa-chevron-right"></i>
        <a href="<?= BASE_URL ?>?action=public-tours">Danh sách Tour</a>
        <i class="fas fa-chevron-right"></i>
        <span><?= htmlspecialchars($tour['name'] ?? '') ?></span>
    </div>

    <div class="detail-grid">
        <!-- GALLERY -->
        <div class="detail-gallery">
            <?php
            $galleryImgs = $tour['gallery'] ?? [];
            $mainImg = !empty($galleryImgs) ? BASE_URL . 'assets/uploads/' . $galleryImgs[0]['image_url'] : 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=900&q=80';
            ?>
            <img id="mainGalleryImg" src="<?= htmlspecialchars($mainImg) ?>" class="main-img" alt="<?= htmlspecialchars($tour['name'] ?? '') ?>">
            <?php if (count($galleryImgs) > 1): ?>
            <div class="gallery-thumbs">
                <?php foreach ($galleryImgs as $i => $img): ?>
                    <img src="<?= BASE_URL . 'assets/uploads/' . $img['image_url'] ?>"
                         class="<?= $i === 0 ? 'active' : '' ?>"
                         onclick="switchImage(this, '<?= BASE_URL . 'assets/uploads/' . $img['image_url'] ?>')"
                         alt="Ảnh <?= $i+1 ?>">
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- BOOKING CARD -->
        <div class="booking-card">
            <div class="booking-card-head">
                <div class="price-from">Giá khởi điểm từ</div>
                <div class="price-main"><?= number_format($tour['base_price'] ?? 0, 0, ',', '.') ?><span> VNĐ</span></div>
            </div>
            <div class="booking-card-body">
                <div class="info-row">
                    <i class="fas fa-tag"></i>
                    <strong>Danh mục</strong>
                    <?= htmlspecialchars($tour['category_name'] ?? 'N/A') ?>
                </div>
                <div class="info-row">
                    <i class="fas fa-globe"></i>
                    <strong>Loại tour</strong>
                    <?= htmlspecialchars($tour['tour_type'] ?? 'N/A') ?>
                </div>
                <div class="info-row">
                    <i class="fas fa-map-marker-alt"></i>
                    <strong>Điểm đến</strong>
                    <?php
                    if (!empty($tour['destinations'])) {
                        $dnames = array_map(fn($d) => $d['name'] ?? '', $tour['destinations']);
                        echo htmlspecialchars(implode(' → ', $dnames));
                    } else {
                        echo "Đang cập nhật";
                    }
                    ?>
                </div>

                <?php if (!empty($tourDepartures)): ?>
                    <?php if (empty($_SESSION['user'])): ?>
                        <div class="login-notice">
                            <i class="fas fa-info-circle"></i>
                            Vui lòng <a href="<?= BASE_URL ?>?action=login" style="color:#c0392b;font-weight:700;">đăng nhập</a> để đặt tour.
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($_SESSION['user']) && $_SESSION['user']['role'] === 'customer'): ?>
                        <form action="<?= BASE_URL ?>?action=checkout-simple" method="get" onsubmit="return validateBooking()">
                            <input type="hidden" name="action" value="checkout-simple">
                            <select name="id" class="departure-select" id="depSelect" required>
                                <option value="">-- Chọn lịch khởi hành --</option>
                                <?php foreach ($tourDepartures as $dep): ?>
                                    <option value="<?= $dep['id'] ?>">
                                        Khởi hành: <?= date('d/m/Y', strtotime($dep['start_date'])) ?>
                                        – Giá: <?= number_format($dep['current_price'], 0, ',', '.') ?>đ
                                        (Còn <?= $dep['available_slots'] ?> chỗ)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="btn-book-now">
                                <i class="fas fa-ticket-alt me-2"></i> Đặt Tour Ngay
                            </button>
                        </form>
                    <?php else: ?>
                        <select class="departure-select" disabled>
                            <option>-- Chọn lịch khởi hành --</option>
                            <?php foreach ($tourDepartures as $dep): ?>
                                <option>
                                    Khởi hành: <?= date('d/m/Y', strtotime($dep['start_date'])) ?>
                                    – <?= number_format($dep['current_price'], 0, ',', '.') ?>đ
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <a href="<?= BASE_URL ?>?action=login" class="btn-book-now">
                            <i class="fas fa-lock me-2"></i> Đăng nhập để đặt tour
                        </a>
                    <?php endif; ?>

                    <a href="<?= BASE_URL ?>?action=request-tour" class="btn-book-now outline">
                        <i class="fas fa-suitcase-rolling me-2"></i> Yêu cầu tour tùy chỉnh
                    </a>
                <?php else: ?>
                    <div style="background:#fff3cd;border-radius:8px;padding:14px;font-size:0.87rem;color:#856404;margin-bottom:14px;">
                        <i class="fas fa-calendar-times me-2"></i>
                        Chưa có lịch khởi hành mới. Hãy đặt tour theo yêu cầu!
                    </div>
                    <a href="<?= BASE_URL ?>?action=request-tour" class="btn-book-now">
                        <i class="fas fa-suitcase-rolling me-2"></i> Yêu Cầu Tour Tùy Chỉnh
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- DETAIL TABS -->
    <div class="detail-tabs-wrap">
        <div class="tab-nav">
            <button class="active" onclick="switchTab(this, 'tab-overview')">
                <i class="fas fa-info-circle me-1"></i> Tổng quan
            </button>
            <button onclick="switchTab(this, 'tab-itinerary')">
                <i class="fas fa-route me-1"></i> Lịch trình
            </button>
            <button onclick="switchTab(this, 'tab-policy')">
                <i class="fas fa-file-contract me-1"></i> Chính sách
            </button>
        </div>
        <div class="tab-content-area">
            <div id="tab-overview" class="tab-pane-custom active">
                <?php if (!empty($tour['description'])): ?>
                    <?= nl2br(htmlspecialchars(strip_tags($tour['description']))) ?>
                <?php else: ?>
                    <p style="color:#aaa;">Chưa có thông tin tổng quan.</p>
                <?php endif; ?>
            </div>

            <div id="tab-itinerary" class="tab-pane-custom">
                <?php if (!empty($tour['itinerary'])): ?>
                    <?php
                    $days = [];
                    foreach ($tour['itinerary'] as $item) {
                        $days[$item['day_number']][] = $item;
                    }
                    ?>
                    <?php foreach ($days as $dayNum => $activities): ?>
                        <div class="accordion-day">
                            <div class="accordion-day-head" onclick="toggleDay(this)">
                                <span><i class="fas fa-sun me-2" style="color:#c0392b;"></i>Ngày <?= $dayNum ?></span>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="accordion-day-body">
                                <?php foreach ($activities as $act): ?>
                                    <div class="activity-item">
                                        <span class="activity-time"><?= date('H:i', strtotime($act['time_slot'] ?? '00:00:00')) ?></span>
                                        <span><?= htmlspecialchars($act['activity'] ?? '') ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color:#aaa;">Lịch trình chi tiết đang được cập nhật.</p>
                <?php endif; ?>
            </div>

            <div id="tab-policy" class="tab-pane-custom">
                <?php if (!empty($tour['cancellation_policy_text'])): ?>
                    <?= nl2br(htmlspecialchars(strip_tags($tour['cancellation_policy_text']))) ?>
                <?php else: ?>
                    <p style="color:#aaa;">Chính sách hủy đặt tour đang được cập nhật.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function switchTab(btn, tabId) {
    document.querySelectorAll('.tab-nav button').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-pane-custom').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById(tabId)?.classList.add('active');
}

function switchImage(thumb, src) {
    document.getElementById('mainGalleryImg').src = src;
    document.querySelectorAll('.gallery-thumbs img').forEach(img => img.classList.remove('active'));
    thumb.classList.add('active');
}

function toggleDay(head) {
    const body = head.nextElementSibling;
    body.classList.toggle('open');
    head.querySelector('i.fa-chevron-down').style.transform = body.classList.contains('open') ? 'rotate(180deg)' : '';
}

function validateBooking() {
    const sel = document.getElementById('depSelect');
    if (!sel || !sel.value) {
        alert('Vui lòng chọn lịch khởi hành!');
        return false;
    }
    return true;
}
</script>

<?php include PATH_VIEW . 'layout/client-footer.php'; ?>
