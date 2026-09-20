<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>?action=public-tours">Danh sách Tour</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($tour['name'] ?? '') ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Gallery -->
        <div class="col-md-7 mb-4">
            <div id="tourCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner rounded shadow-sm">
                    <?php if (!empty($tour['gallery'])): ?>
                        <?php foreach ($tour['gallery'] as $index => $img): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <img src="<?= BASE_URL . 'assets/uploads/' . $img['image_url'] ?>" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="Tour image">
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="carousel-item active">
                            <img src="assets/images/default-tour.jpg" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="Default Image">
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (!empty($tour['gallery']) && count($tour['gallery']) > 1): ?>
                    <button class="carousel-control-prev" type="button" data-bs-target="#tourCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#tourCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <!-- Info -->
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h2 class="card-title text-primary mb-3"><?= htmlspecialchars($tour['name'] ?? '') ?></h2>
                    <h4 class="text-danger fw-bold mb-4">Từ <?= number_format($tour['base_price'] ?? 0, 0, ',', '.') ?> VNĐ</h4>
                    
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item px-0"><i class="fas fa-tag text-muted me-2"></i> <strong>Danh mục:</strong> <?= htmlspecialchars($tour['category_name'] ?? 'N/A') ?></li>
                        <li class="list-group-item px-0"><i class="fas fa-globe text-muted me-2"></i> <strong>Loại Tour:</strong> <?= htmlspecialchars($tour['tour_type'] ?? 'N/A') ?></li>
                        <li class="list-group-item px-0">
                            <i class="fas fa-map-marker-alt text-muted me-2"></i> <strong>Điểm đến:</strong> 
                            <?php 
                            if (!empty($tour['destinations'])) {
                                $destNames = array_map(function($d) { return $d['name'] ?? ''; }, $tour['destinations']);
                                echo htmlspecialchars(implode(' -> ', $destNames));
                            } else {
                                echo "Đang cập nhật";
                            }
                            ?>
                        </li>
                    </ul>

                    <h5 class="fw-bold">Lịch khởi hành sắp tới:</h5>
                    <?php if (!empty($tourDepartures)): ?>
                        <form action="<?= BASE_URL ?>?action=create-booking" method="get">
                            <input type="hidden" name="action" value="create-booking">
                            <div class="form-group mb-3">
                                <select name="dep_id" class="form-select" required>
                                    <option value="">-- Chọn lịch khởi hành --</option>
                                    <?php foreach ($tourDepartures as $dep): ?>
                                        <option value="<?= $dep['id'] ?>">
                                            Khởi hành: <?= date('d/m/Y', strtotime($dep['start_date'])) ?> 
                                            - Giá: <?= number_format($dep['current_price'], 0, ',', '.') ?>đ 
                                            (Còn <?= $dep['available_slots'] ?> chỗ)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100"><i class="fas fa-ticket-alt"></i> Đặt Tour Ngay</button>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-warning">Hiện chưa có lịch khởi hành mới. Vui lòng liên hệ để đặt tour theo yêu cầu.</div>
                        <a href="<?= BASE_URL ?>?action=request-tour" class="btn btn-outline-primary w-100">Yêu cầu Tour Tùy Chỉnh</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Details Tabs -->
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-body">
            <ul class="nav nav-tabs mb-4" id="tourTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc" type="button" role="tab" aria-controls="desc" aria-selected="true">Tổng quan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold" id="itinerary-tab" data-bs-toggle="tab" data-bs-target="#itinerary" type="button" role="tab" aria-controls="itinerary" aria-selected="false">Lịch trình</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold" id="policy-tab" data-bs-toggle="tab" data-bs-target="#policy" type="button" role="tab" aria-controls="policy" aria-selected="false">Chính sách</button>
                </li>
            </ul>
            <div class="tab-content" id="tourTabContent">
                <div class="tab-pane fade show active" id="desc" role="tabpanel" aria-labelledby="desc-tab">
                    <?= nl2br(htmlspecialchars($tour['description'] ?? 'Chưa có thông tin tổng quan.')) ?>
                </div>
                <div class="tab-pane fade" id="itinerary" role="tabpanel" aria-labelledby="itinerary-tab">
                    <?php if (!empty($tour['itinerary'])): ?>
                        <div class="accordion" id="accordionItinerary">
                            <?php 
                            // Nhóm theo ngày
                            $days = [];
                            foreach ($tour['itinerary'] as $item) {
                                $days[$item['day_number']][] = $item;
                            }
                            ?>
                            <?php foreach ($days as $dayNum => $activities): ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading<?= $dayNum ?>">
                                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $dayNum ?>" aria-expanded="false" aria-controls="collapse<?= $dayNum ?>">
                                            Ngày <?= $dayNum ?>
                                        </button>
                                    </h2>
                                    <div id="collapse<?= $dayNum ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $dayNum ?>" data-bs-parent="#accordionItinerary">
                                        <div class="accordion-body">
                                            <ul class="list-unstyled mb-0">
                                                <?php foreach ($activities as $act): ?>
                                                    <li class="mb-2">
                                                        <span class="badge bg-secondary me-2"><?= date('H:i', strtotime($act['time_slot'] ?? '00:00:00')) ?></span> 
                                                        <?= htmlspecialchars($act['activity'] ?? '') ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p>Đang cập nhật lịch trình chi tiết.</p>
                    <?php endif; ?>
                </div>
                <div class="tab-pane fade" id="policy" role="tabpanel" aria-labelledby="policy-tab">
                    <?= nl2br(htmlspecialchars($tour['cancellation_policy_text'] ?? 'Chính sách đang cập nhật.')) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
