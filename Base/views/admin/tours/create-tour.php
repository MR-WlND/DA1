<?php include PATH_VIEW . 'layout/header.php'; ?>

<?php
// Khối PHP Setup: Tạo biến HTML options cho select destination (dùng trong JS)
$destinationOptionsHtml = '';
if (!empty($listDestinations)) {
    foreach ($listDestinations as $des) {
        $id = $des['id'];
        $name = htmlspecialchars($des['name'] ?? '');
        $destinationOptionsHtml .= "<option value=\"{$id}\">{$name}</option>";
    }
}
?>

<div class="main">
    <h2>Thêm Tour mới</h2>

    <div class="card">
        <form action="<?= BASE_URL ?>?action=create-tour" method="post" enctype="multipart/form-data">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Tên Tour:</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="base_price" class="form-label">Giá cơ bản (VNĐ):</label>
                        <input type="number" id="base_price" name="base_price" class="form-control" min="0" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="tour_type" class="form-label">Loại tour:</label>
                        <select id="tour_type" name="tour_type" class="form-control" required>
                            <option value="Nội địa" selected>Nội địa</option>
                            <option value="Quốc tế">Quốc tế</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="tour_origin" class="form-label">Nguồn tour:</label>
                        <select id="tour_origin" name="tour_origin" class="form-control" required>
                            <option value="Catalog" selected>Catalog</option>
                            <option value="Custom">Custom</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="category_id" class="form-label">Danh mục:</label>
                        <select id="category_id" name="category_id" class="form-control" required>
                            <option value="">-- Chọn danh mục --</option>
                            <?php foreach ($listCategories as $c): ?>
                                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name'] ?? '') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group mb-3">
    <label for="cancellation_policy_text" class="form-label">Nội dung Chính sách Hủy:</label>
    <textarea id="cancellation_policy_text" name="cancellation_policy_text" class="form-control" rows="6">
        <?= htmlspecialchars($tour['cancellation_policy_text'] ?? '') ?>
    </textarea>
</div>
            </div>

            <div class="form-group mb-3">
                <label for="description" class="form-label">Mô tả Tour:</label>
                <textarea id="description" name="description" class="form-control" rows="4"></textarea>
            </div>

            <div class="form-group mb-3">
                <label for="gallery_images" class="form-label">Ảnh gallery:</label>
                <input type="file" id="gallery_images" name="gallery_images[]" class="form-control" multiple accept="image/*" required>
            </div>

            <hr>

            <h4>Lộ trình (Điểm đến)</h4>
            <div id="destination-wrapper"></div>
            <button type="button" class="btn btn-primary btn-sm mt-2" onclick="addDestination()">+ Thêm điểm đến</button>
            <hr>

            <h4>Lịch trình Chi tiết (Ngày/Giờ)</h4>
            <div id="itinerary-detail-wrapper"></div>
            <button type="button" class="btn btn-primary btn-sm mt-2" onclick="addItineraryItem()">+ Thêm Hoạt động</button>
            <hr>

            <h4>Lịch khởi hành</h4>
            <div id="departure-wrapper"></div>
            <button type="button" class="btn btn-primary btn-sm mt-2" onclick="addDeparture()">+ Thêm lịch khởi hành</button>
            <hr>

            <button type="submit" class="btn btn-success mt-3">Lưu Tour</button>
        </form>
    </div>
</div>


<script>
    let destinationIndex = 0;
    let departureIndex = 0;
    let itineraryIndex = 0; // Thêm biến index cho Lịch trình Chi tiết

    /* Nội dung <option> cho select destination được sinh server-side */
    const destinationOptions = `<?= $destinationOptionsHtml ?>`;

    /* 1. Thêm một dòng destination (select + order_number) */
    function addDestination() {
        const wrapper = document.getElementById('destination-wrapper');

        const html = `
            <div class="d-flex gap-2 mt-2 align-items-center">
                <select name="destinations[${destinationIndex}][destination_id]" class="form-control" required>
                    <option value="">-- Chọn điểm đến --</option>
                    ${destinationOptions}
                </select>
                <input type="number" name="destinations[${destinationIndex}][order_number]" class="form-control" placeholder="Thứ tự" min="1" required>
                <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger">X</button>
            </div>
        `;
        wrapper.insertAdjacentHTML('beforeend', html);
        destinationIndex++;
    }

    /* 2. Thêm một dòng departure (start_date, end_date, current_price, available_slots) */
    function addDeparture() {
        const wrapper = document.getElementById('departure-wrapper');

        const html = `
            <div class="d-flex gap-2 mt-2 align-items-center">
                <input type="date" name="departures[${departureIndex}][start_date]" class="form-control" required>
                <input type="date" name="departures[${departureIndex}][end_date]" class="form-control" required>
                <input type="number" name="departures[${departureIndex}][current_price]" class="form-control" placeholder="Giá bán hiện tại" min="0" required>
                <input type="number" name="departures[${departureIndex}][available_slots]" class="form-control" placeholder="Số lượt đặt tối đa" min="0" required>
                <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger">X</button>
            </div>
        `;
        wrapper.insertAdjacentHTML('beforeend', html);
        departureIndex++;
    }

    /* 3. Thêm một dòng chi tiết lịch trình (Day/Time/Activity) */
    function addItineraryItem() {
        const wrapper = document.getElementById('itinerary-detail-wrapper');

        const html = `
            <div class="d-flex gap-2 mt-2 align-items-center">
                <input type="number" name="itinerary_details[${itineraryIndex}][day_number]" class="form-control" placeholder="Ngày #" min="1" required style="width: 20%;">
                <input type="time" name="itinerary_details[${itineraryIndex}][time_slot]" class="form-control" placeholder="Thời gian (tùy chọn)" style="width: 20%;">
                <input type="text" name="itinerary_details[${itineraryIndex}][activity]" class="form-control" placeholder="Hoạt động chi tiết" required>
                <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger btn-sm">X</button>
            </div>
        `;
        wrapper.insertAdjacentHTML('beforeend', html);
        itineraryIndex++;
    }

    /* Khi load trang: tự tạo 1 dòng input cho mỗi phần */
    document.addEventListener('DOMContentLoaded', function() {
        addDestination();
        addDeparture();
        addItineraryItem();
    });
</script>

<?php include PATH_VIEW . 'layout/footer.php'; ?>