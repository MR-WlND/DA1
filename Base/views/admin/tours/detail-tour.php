<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="tour-detail">
    <div class="card">
        <!-- Hero Gallery -->
        <div class="hero-gallery">
            <?php if (!empty($tour['gallery'])): ?>
                <div class="slider" style="position:relative; max-width:800px; margin:auto; overflow:hidden; border-radius:8px;">
                    <?php foreach ($tour['gallery'] as $i => $img): ?>
                        <img class="slide" src="<?= BASE_ASSETS_UPLOADS . $img['image_url'] ?>"
                            style="width:100%; height:400px; object-fit:cover; display:<?= $i === 0 ? 'block' : 'none' ?>; transition:opacity 0.5s;">
                    <?php endforeach; ?>

                    <button onclick="plusSlide(-1)" style="position:absolute;top:50%;left:10px;transform:translateY(-50%);background:rgba(0,0,0,0.5);color:#fff;border:none;padding:10px;cursor:pointer;">&#10094;</button>
                    <button onclick="plusSlide(1)" style="position:absolute;top:50%;right:10px;transform:translateY(-50%);background:rgba(0,0,0,0.5);color:#fff;border:none;padding:10px;cursor:pointer;">&#10095;</button>
                </div>

                <script>
                    let slideIndex = 0;
                    const slides = document.querySelectorAll('.slide');

                    function showSlide(n) {
                        slides.forEach(s => s.style.display = 'none');
                        slides[n].style.display = 'block';
                    }

                    function plusSlide(n) {
                        slideIndex = (slideIndex + n + slides.length) % slides.length;
                        showSlide(slideIndex);
                    }
                </script>
            <?php endif; ?>
            <h1 class="tour-title"><?= htmlspecialchars($tour['name']) ?></h1>
            <div class="tour-tags">
                <span class="tag"><?= htmlspecialchars($tour['category_name'] ?? '') ?></span>
                <span class="tag"><?= ($tour['tour_type'] == 'domestic') ? 'Nội địa' : 'Quốc tế' ?></span>
            </div>
        </div>

        <!-- Lộ trình (Timeline) -->
        <section class="itinerary">
            <h2>Lộ trình chi tiết</h2>
            <div class="timeline">
                <?php
                $destinations = $tour['destinations'] ?? [];
                ?>
                <?php foreach ($destinations as $d): ?>
                    <div class="timeline-item">
                        <div class="timeline-number"><?= $d['order_number'] ?? '-' ?></div>
                        <div class="timeline-content">
                            <h4><?= $d['name'] ?></h4>
                            <p><?= htmlspecialchars($d['description'] ?? $tour['description'] ?? '') ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Giá & Lịch khởi hành -->
        <section class="departures">
            <h2>Lịch khởi hành & Giá</h2>
            <table class=" table-primary table-departures">
                <thead>
                    <tr>
                        <th>Ngày đi</th>
                        <th>Ngày về</th>
                        <th>Giá bán (VNĐ)</th>
                        <th>Số chỗ còn lại</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($tour['departures'])): ?>
                        <tr>
                            <td colspan="5" style="text-align:center;">Chưa có lịch khởi hành nào được thiết lập.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($tour['departures'] as $dep): ?>
                            <tr>
                                <td><?= $dep['start_date'] ?? '-' ?></td>
                                <td><?= $dep['end_date'] ?? '-' ?></td>
                                <td><?= number_format($dep['current_price'] ?? 0) ?></td>
                                <td><?= $dep['available_slots'] ?? 'N/A' ?></td>
                                <td>
                                    <a href="<?= BASE_URL ?>?action=book&id=<?= $tour['id'] ?>&dep_id=<?= $dep['departure_id'] ?>" class="btn-book">Đặt chỗ</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

        <!-- Chính sách & Mô tả -->
        <section class="policy-description">
            <?php if (!empty($tour['policy_details'])): ?>
                <div class="policy">
                    <h3>Chính sách hủy</h3>
                    <p><?= nl2br($tour['policy_details']) ?></p>
                </div>
            <?php endif; ?>

            <div class="description">
                <h3>Mô tả chi tiết</h3>
                <p><?= nl2br($tour['description'] ?? '') ?></p>
            </div>
        </section>
        <div>
            <a href="<?= BASE_URL ?>?action=list-tour" class="btn btn-danger">Quay lại</a>
        </div>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>