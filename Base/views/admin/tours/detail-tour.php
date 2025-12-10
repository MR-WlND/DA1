<?php include PATH_VIEW . 'layout/header.php'; ?>

<style>
    body {
        font-family: 'Inter', sans-serif;
        background: #f5f6f7;
        margin: 0;
        padding: 0;
        color: #1f2937;
    }

    /* ===== HERO GALLERY ===== */
    .gallery {
        position: relative;
        width: 100%;
        height: 420px;
        border-radius: 14px;
        overflow: hidden;
        background: #ddd;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .gallery img {
        width: 100%;
        height: 420px;
        object-fit: cover;
        display: none;
    }

    .gallery .arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 42px;
        height: 42px;
        background: rgba(255,255,255,0.8);
        border-radius: 50%;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    .arrow:hover { transform: translateY(-50%) scale(1.05); }

    .arrow.prev { left: 12px; }
    .arrow.next { right: 12px; }

    .hero-info {
        position: absolute;
        bottom: 20px;
        left: 24px;
        color: #fff;
        text-shadow: 0 3px 12px rgba(0,0,0,0.7);
    }

    .hero-info h1 {
        font-size: 32px;
        margin: 0 0 8px;
        font-weight: 800;
    }

    .tag {
        display: inline-block;
        padding: 5px 14px;
        border-radius: 20px;
        background: #7c3aed;
        color: #fff;
        margin-right: 6px;
        font-size: 13px;
        font-weight: 600;
    }

    /* ===== SECTION CARD ===== */
    .card {
        background: #fff;
        border-radius: 12px;
        padding: 22px;
        margin-top: 26px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.06);
    }

    .card h2 {
        margin-bottom: 14px;
        font-size: 22px;
        font-weight: 700;
        color: #1f2937;
    }

    /* ===== TIMELINE ===== */
    .timeline {
        border-left: 3px solid #6366f1;
        padding-left: 18px;
    }

    .timeline-item {
        margin-bottom: 16px;
        position: relative;
    }

    .timeline-item::before {
        content: '';
        width: 14px;
        height: 14px;
        background: #6366f1;
        border-radius: 50%;
        position: absolute;
        left: -26px;
        top: 10px;
    }

    .timeline-item h4 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
    }

    /* ===== DEPARTURES ===== */
    .departure-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 18px;
    }

    .departure {
        background: #fff;
        padding: 16px;
        border-radius: 12px;
        border: 1px solid #ececec;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .departure h5 {
        margin: 0 0 6px;
        font-size: 16px;
        font-weight: 700;
    }

    .price-line {
        display: flex;
        justify-content: space-between;
        margin: 8px 0;
        font-weight: 600;
    }

    .btn-book {
        display: block;
        text-align: center;
        padding: 8px 0;
        background: #10b981;
        color: #fff;
        font-weight: 700;
        border-radius: 10px;
        text-decoration: none;
    }

    /* ===== DESCRIPTION & POLICY ===== */
    .text-block {
        line-height: 1.65;
        color: #374151;
        margin-top: 12px;
        white-space: pre-line;
    }

    /* ===== BACK ===== */
    .btn-back {
        display: inline-block;
        margin-top: 24px;
        padding: 10px 18px;
        background: #ef4444;
        color: #fff;
        border-radius: 10px;
        font-weight: 700;
        text-decoration: none;
    }
</style>
<div class="main">

    <!-- HERO GALLERY -->
    <?php if (!empty($tour['gallery'])): ?>
    <div class="gallery">
        <?php foreach ($tour['gallery'] as $i => $img): ?>
            <img class="slide" src="<?= BASE_ASSETS_UPLOADS . $img['image_url'] ?>" style="<?= $i === 0 ? 'display:block;' : '' ?>">
        <?php endforeach; ?>

        <button class="arrow prev" id="prev">&#10094;</button>
        <button class="arrow next" id="next">&#10095;</button>

        <div class="hero-info">
            <h1><?= $tour['name'] ?></h1>
            <span class="tag"><?= $tour['category_name'] ?? '' ?></span>
            <span class="tag"><?= $tour['tour_type']=='domestic'?'Nội địa':'Quốc tế' ?></span>
        </div>
    </div>

    <script>
        (function(){
            const slides = document.querySelectorAll('.slide');
            let i = 0;
            const show = idx => {
                slides.forEach(s => s.style.display = 'none');
                slides[idx].style.display = 'block';
            };
            document.getElementById('prev').onclick = () => { i = (i - 1 + slides.length) % slides.length; show(i); };
            document.getElementById('next').onclick = () => { i = (i + 1) % slides.length; show(i); };
        })();
    </script>

    <?php endif; ?>

    <!-- TIMELINE -->
    <div class="card">
        <h2>Lộ trình</h2>
        <div class="timeline">
            <?php foreach($tour['destinations'] ?? [] as $d): ?>
            <div class="timeline-item">
                <h4><?= $d['name'] ?></h4>
                <p><?= $d['description'] ?? '' ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- ITINERARY DETAILS -->
    <div class="card">
        <h2>Lịch trình Chi tiết</h2>

        <?php $itinerary = $tour['itinerary_details'] ?? []; ?>

        <?php if (empty($itinerary)): ?>
            <p>Chưa có dữ liệu.</p>
        <?php else: ?>
        <table style="width:100%; border-collapse:collapse;" border="1">
            <thead>
                <tr style="background:#f1f5f9;">
                    <th style="padding:10px; width:15%;">Ngày</th>
                    <th style="padding:10px; width:20%;">Thời gian</th>
                    <th style="padding:10px;">Hoạt động</th>
                </tr>
            </thead>
            <tbody>
                <?php $dNow = null; foreach($itinerary as $row): ?>
                <tr>
                    <td style="padding:10px; font-weight:700;"><?= $row['day_number'] != $dNow ? 'Ngày '.$row['day_number'] : '' ?></td>
                    <td style="padding:10px;"><?= $row['time_slot'] ?? 'Cả ngày' ?></td>
                    <td style="padding:10px;"><?= $row['activity'] ?></td>
                </tr>
                <?php $dNow = $row['day_number']; endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

    <!-- DEPARTURE -->
    <div class="card">
        <h2>Lịch khởi hành & Giá</h2>
        <div class="departure-grid">
            <?php foreach($tour['departures'] ?? [] as $dep): ?>
            <div class="departure">
                <h5><?= $dep['start_date'] ?> → <?= $dep['end_date'] ?></h5>
                <div class="price-line">
                    <span>Giá: <?= number_format($dep['current_price']) ?>đ</span>
                    <span>Chỗ: <?= $dep['available_slots'] ?></span>
                </div>
                <a class="btn-book" href="<?= BASE_URL ?>?action=create-booking&id=<?= $tour['id'] ?>&dep_id=<?= $dep['departure_id'] ?>">Đặt chỗ</a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- DESCRIPTION -->
    <div class="card">
        <h2>Mô tả chi tiết</h2>
        <div class="text-block"><?= $tour['description'] ?? '' ?></div>

        <?php if (!empty($tour['cancellation_policy_text'])): ?>
        <h2 style="margin-top:24px;">Chính sách hủy</h2>
        <div class="text-block"><?=$tour['cancellation_policy_text'] ?></div>
        <?php endif; ?>
    </div>

    <a href="<?= BASE_URL ?>?action=list-tour" class="btn-back">Quay lại</a>

</div>
