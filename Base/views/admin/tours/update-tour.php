<?php 
// File: views/admin/tours/update-tour.php
include PATH_VIEW . 'layout/header.php'; 

// Dữ liệu Tour chính (đã được Controller hợp nhất từ DB và POST)
$tour = $data ?? []; 

// Dữ liệu phụ thuộc phức tạp
$currentDestinations = $data['destinations'] ?? [];
$currentDepartures = $data['departures'] ?? [];
$currentGallery = $data['gallery'] ?? [];
$currentItineraryDetails = $data['itinerary_details'] ?? []; 

// Tạo chuỗi HTML options cho select destination (dùng trong JS nếu cần, nhưng ta dùng PHP)
$destinationOptionsHtml = '';
if (!empty($listDestinations)) { 
    foreach ($listDestinations as $des) {
        $id = $des['id'];
        $name = $des['name'] ?? '';
        $destinationOptionsHtml .= "<option value=\"{$id}\">{$name}</option>";
    }
}
?>

<div class="main">
    <h2>Cập nhật Tour: <?= $tour['name'] ?? 'Không tên' ?></h2>

    <div class="card">
        <form action="<?= BASE_URL ?>?action=update-tour&id=<?= $tour['id'] ?>" method="post" enctype="multipart/form-data">
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger mb-3">
                    <strong>Lỗi:</strong> <?= $error ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-6"><div class="form-group mb-3">
                    <label for="name" class="form-label">Tên Tour:</label>
                    <input type="text" name="name" class="form-control" value="<?= $tour['name'] ?? '' ?>" required>
                </div></div>
                <div class="col-md-6"><div class="form-group mb-3">
                    <label for="base_price" class="form-label">Giá cơ bản (VNĐ):</label>
                    <input type="number" name="base_price" class="form-control" value="<?= $tour['base_price'] ?? '' ?>" min="0" required>
                </div></div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="tour_type" class="form-label">Loại tour:</label>
                        <select name="tour_type" class="form-control" required>
                            <option value="Nội địa" <?= (($tour['tour_type'] ?? '') == 'domestic') ? 'selected' : '' ?>>Nội địa</option>
                            <option value="Quốc tế" <?= (($tour['tour_type'] ?? '') == 'international') ? 'selected' : '' ?>>Quốc tế</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="tour_origin" class="form-label">Nguồn tour:</label>
                        <select name="tour_origin" class="form-control" required>
                            <option value="Catalog" <?= (($tour['tour_origin'] ?? '') == 'Catalog') ? 'selected' : '' ?>>Catalog</option>
                            <option value="Custom" <?= (($tour['tour_origin'] ?? '') == 'Custom') ? 'selected' : '' ?>>Custom</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="category_id" class="form-label">Danh mục:</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">-- Chọn danh mục --</option>
                            <?php foreach ($listCategories as $c): ?>
                                <option value="<?= $c['id'] ?>" <?= (($tour['category_id'] ?? null) == $c['id']) ? 'selected' : '' ?>>
                                    <?= $c['name'] ?? '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group mb-3">
    <label for="cancellation_policy_text" class="form-label">Nội dung Chính sách Hủy:</label>
    <textarea id="cancellation_policy_text" name="cancellation_policy_text" class="form-control" rows="6">
        <?= $tour['cancellation_policy_text'] ?? '' ?>
    </textarea>
</div>
            </div>
            
            <div class="form-group mb-3">
                <label for="description" class="form-label">Mô tả Tour:</label>
                <textarea name="description" class="form-control" rows="4"><?= $tour['description'] ?? '' ?></textarea>
            </div>
            
            <div class="form-group mb-3">
                <label class="form-label">Ảnh Gallery Hiện tại (<?= count($currentGallery) ?> ảnh):</label>
                <div class="d-flex flex-wrap gap-2 mb-2">
                    <?php foreach ($currentGallery as $img): ?>
                        <div style="position: relative; width: 80px; height: 60px;">
                            <img src="<?= BASE_ASSETS_UPLOADS . $img['image_url'] ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px;" title="<?= htmlspecialchars($img['image_url']) ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
                <label for="gallery_images" class="form-label">Upload ảnh mới (sẽ thay thế ảnh cũ):</label>
                <input type="file" name="gallery_images[]" id="gallery_images" class="form-control" multiple accept="image/*">
            </div>

            <hr>

            <h4>Lộ trình (Điểm đến)</h4>
            <div id="destination-wrapper">
                <?php 
                $destinations = $currentDestinations;
                if (empty($destinations)) $destinations[] = ['destination_id' => '', 'order_number' => ''];
                foreach ($destinations as $i => $dest): ?>
                    <div class="d-flex gap-2 mt-2 align-items-center">
                        <select name="destinations[<?= $i ?>][destination_id]" class="form-control" required>
                            <option value="">-- Chọn điểm đến --</option>
                            <?php foreach ($listDestinations as $d): ?>
                                <?php $selected = (($dest['destination_id'] ?? $dest['id']) == $d['id']) ? 'selected' : ''; ?>
                                <option value="<?= $d['id'] ?>" <?= $selected ?>><?= $d['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="number" min="1" name="destinations[<?= $i ?>][order_number]" class="form-control" value="<?= $dest['order_number'] ?? '' ?>" placeholder="Thứ tự" required>
                        <button type="button" class="btn btn-danger remove-item-btn">X</button>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" id="add-destination-btn" class="btn btn-secondary mt-2">+ Thêm điểm đến</button>
            <hr>
            
            <h4>Lịch trình Chi tiết (Ngày/Giờ)</h4>
            <div id="itinerary-detail-wrapper">
                <?php 
                $itineraryDetails = $currentItineraryDetails;
                if (empty($itineraryDetails)) $itineraryDetails[] = ['day_number' => '', 'time_slot' => '', 'activity' => ''];
                foreach ($itineraryDetails as $i => $item): ?>
                    <div class="d-flex gap-2 mt-2 align-items-center">
                        <input type="number" name="itinerary_details[<?= $i ?>][day_number]" class="form-control" value="<?= $item['day_number'] ?? '' ?>" placeholder="Ngày #" min="1" required style="width: 15%;">
                        <input type="time" name="itinerary_details[<?= $i ?>][time_slot]" class="form-control" value="<?= $item['time_slot'] ?? '' ?>" placeholder="Thời gian (tùy chọn)" style="width: 20%;">
                        <input type="text" name="itinerary_details[<?= $i ?>][activity]" class="form-control" value="<?= $item['activity'] ?? '' ?>" placeholder="Hoạt động chi tiết" required>
                        <button type="button" class="btn btn-danger btn-sm remove-item-btn">X</button>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" id="add-itinerary-btn" class="btn btn-secondary mt-2">+ Thêm Hoạt động</button>
            <hr>

            <h4>Lịch khởi hành</h4>
            <div id="departure-wrapper">
                <?php 
                $departures = $currentDepartures;
                if (empty($departures)) $departures[] = ['start_date' => '', 'end_date' => '', 'current_price' => '', 'available_slots' => ''];
                foreach ($departures as $i => $dep): ?>
                    <div class="d-flex gap-2 mt-2 align-items-center">
                        <input type="date" name="departures[<?= $i ?>][start_date]" class="form-control" value="<?= $dep['start_date'] ?? '' ?>" required>
                        <input type="date" name="departures[<?= $i ?>][end_date]" class="form-control" value="<?= $dep['end_date'] ?? '' ?>" required>
                        <input type="number" name="departures[<?= $i ?>][current_price]" class="form-control" value="<?= $dep['current_price'] ?? '' ?>" placeholder="Giá bán hiện tại" min="0" required>
                        <input type="number" name="departures[<?= $i ?>][available_slots]" class="form-control" value="<?= $dep['available_slots'] ?? '' ?>" placeholder="Số chỗ tối đa" min="0" required>
                        <button type="button" class="btn btn-danger remove-item-btn" style="height:38px;">X</button>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" id="add-departure-btn" class="btn btn-secondary mt-2">+ Thêm lịch khởi hành</button>
            <hr>

            <input type="submit" name="final_update_action" class="btn btn-primary" value="Cập nhật Tour">
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Xử lý Lộ trình (Điểm đến) ---
    const addDestinationBtn = document.getElementById('add-destination-btn');
    const destinationWrapper = document.getElementById('destination-wrapper');
    // Lấy HTML mẫu cho select options, đã được tạo sẵn bằng PHP
    const destinationOptions = `<?= addslashes($destinationOptionsHtml) ?>`;

    addDestinationBtn.addEventListener('click', function() {
        const newIndex = destinationWrapper.children.length;
        const newRow = document.createElement('div');
        newRow.className = 'd-flex gap-2 mt-2 align-items-center';
        newRow.innerHTML = `
            <select name="destinations[${newIndex}][destination_id]" class="form-control" required>
                <option value="">-- Chọn điểm đến --</option>
                ${destinationOptions}
            </select>
            <input type="number" min="1" name="destinations[${newIndex}][order_number]" class="form-control" placeholder="Thứ tự" required>
            <button type="button" class="btn btn-danger remove-item-btn">X</button>
        `;
        destinationWrapper.appendChild(newRow);
    });

    // --- Xử lý Lịch trình chi tiết ---
    const addItineraryBtn = document.getElementById('add-itinerary-btn');
    const itineraryWrapper = document.getElementById('itinerary-detail-wrapper');

    addItineraryBtn.addEventListener('click', function() {
        const newIndex = itineraryWrapper.children.length;
        const newRow = document.createElement('div');
        newRow.className = 'd-flex gap-2 mt-2 align-items-center';
        newRow.innerHTML = `
            <input type="number" name="itinerary_details[${newIndex}][day_number]" class="form-control" placeholder="Ngày #" min="1" required style="width: 15%;">
            <input type="time" name="itinerary_details[${newIndex}][time_slot]" class="form-control" placeholder="Thời gian (tùy chọn)" style="width: 20%;">
            <input type="text" name="itinerary_details[${newIndex}][activity]" class="form-control" placeholder="Hoạt động chi tiết" required>
            <button type="button" class="btn btn-danger btn-sm remove-item-btn">X</button>
        `;
        itineraryWrapper.appendChild(newRow);
    });

    // --- Xử lý Lịch khởi hành ---
    const addDepartureBtn = document.getElementById('add-departure-btn');
    const departureWrapper = document.getElementById('departure-wrapper');

    addDepartureBtn.addEventListener('click', function() {
        const newIndex = departureWrapper.children.length;
        const newRow = document.createElement('div');
        newRow.className = 'd-flex gap-2 mt-2 align-items-center';
        newRow.innerHTML = `
            <input type="date" name="departures[${newIndex}][start_date]" class="form-control" required>
            <input type="date" name="departures[${newIndex}][end_date]" class="form-control" required>
            <input type="number" name="departures[${newIndex}][current_price]" class="form-control" placeholder="Giá bán hiện tại" min="0" required>
            <input type="number" name="departures[${newIndex}][available_slots]" class="form-control" placeholder="Số chỗ tối đa" min="0" required>
            <button type="button" class="btn btn-danger remove-item-btn" style="height:38px;">X</button>
        `;
        departureWrapper.appendChild(newRow);
    });

    // --- Xử lý chung cho các nút Xóa ---
    // Sử dụng event delegation để xử lý cả các nút được thêm sau này
    document.querySelector('.card').addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-item-btn')) {
            // Tìm phần tử cha (dòng) để xóa
            const rowToRemove = e.target.closest('.d-flex');
            if (rowToRemove) {
                rowToRemove.remove();
            }
        }
    });
});
</script>

<?php include PATH_VIEW . 'layout/footer.php'; ?>