<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Thêm Tour mới</h2>

    <div class="card">
        <div class="toph4">
            <h4>Thông tin Tour</h4>
        </div>

        <form action="<?= BASE_URL ?>?action=create-tour" method="post" enctype="multipart/form-data">

            <!-- Tên tour -->
            <div class="form-group mb-3">
                <label for="name" class="form-label">Tên Tour:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>

            <!-- Loại tour -->
            <div class="form-group mb-3">
                <label for="tour_type" class="form-label">Loại tour:</label>
                <select id="tour_type" name="tour_type" class="form-control" required>
                    <option value="Nội địa">Nội địa</option>
                    <option value="Quốc tế">Quốc tế</option>
                </select>
            </div>

            <!-- Giá gốc -->
            <div class="form-group mb-3">
                <label for="base_price" class="form-label">Giá cơ bản (VNĐ):</label>
                <input type="number" id="base_price" name="base_price" class="form-control" min="0" required>
            </div>

            <div class="form-group mb-3">
                <label for="description" class="form-label">Mô tả Tour:</label>
                <textarea id="description" name="description" class="form-control" rows="4"></textarea>
            </div>

            <!-- Tour origin -->
            <div class="form-group mb-3">
                <label for="tour_origin" class="form-label">Nguồn tour:</label>
                <select id="tour_origin" name="tour_origin" class="form-control" required>
                    <option value="Catalog">Catalog</option>
                    <option value="Custom">Custom</option>
                </select>
            </div>

            <!-- Danh mục -->
            <div class="form-group mb-3">
                <label for="category_id" class="form-label">Danh mục:</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <option value="">-- Chọn danh mục --</option>
                    <?php if (!empty($listCategories)): ?>
                        <?php foreach ($listCategories as $c): ?>
                            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name'] ?? '') ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <!-- Chính sách hủy -->
            <div class="form-group mb-3">
                <label for="policy_id" class="form-label">Chính sách hủy:</label>
                <select id="policy_id" name="policy_id" class="form-control">
                    <option value="">-- Chọn chính sách (nếu có) --</option>
                    <?php if (!empty($listPolicies)): ?>
                        <?php foreach ($listPolicies as $p): ?>
                            <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['policy_name'] ?? $p['title'] ?? '') ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <hr>
            <!-- LỘ TRÌNH (DESTINATIONS) -->
            <h4>Lộ trình (Điểm đến)</h4>
            <div id="destination-wrapper"></div>
            <div class="mt-2">
                <button type="button" class="btn btn-nut" onclick="addDestination()">+ Thêm điểm đến</button>
            </div>
            <hr>
            <!-- LỊCH KHỞI HÀNH (DEPARTURES) -->
            <h4>Lịch khởi hành</h4>
            <div id="departure-wrapper"></div>

            <div class="mt-2">
                <button type="button" class="btn btn-nut" onclick="addDeparture()">+ Thêm lịch khởi hành</button>
            </div>

            <hr>

            <!-- GALLERY IMAGES -->
            <div class="form-group mb-3">
                <label for="gallery_images" class="form-label">Ảnh gallery (ảnh đầu tiên sẽ là ảnh đại diện):</label>
                <input type="file" id="gallery_images" name="gallery_images[]" class="form-control" multiple accept="image/*">
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-nut">Lưu Tour</button>
                <a href="<?= BASE_URL ?>?action=list-tour" class="btn btn-danger">Hủy</a>
            </div>
        </form>
    </div>
</div>

<?php
$destinationOptionsHtml = '';
if (!empty($listDestinations)) {
    foreach ($listDestinations as $des) {
        $id = $des['id'];
        $name = htmlspecialchars($des['name']);
        $destinationOptionsHtml .= "<option value=\"$id\">$name</option>";
    }
}
?>
<script>
    /**
     * JavaScript quản lý dynamic form cho Destinations & Departures
     * - Destinations: gửi destinations[i][destination_id], destinations[i][order_number]
     * - Departures: gửi departures[i][start_date], departures[i][end_date], departures[i][current_price], departures[i][available_slots]
     */

    let destinationIndex = 0;
    let departureIndex = 0;

    /* Nội dung <option> cho select destination được sinh server-side */
    const destinationOptions = `<?= $destinationOptionsHtml ?>`;

    /* Thêm một dòng destination (select + order_number + remove) */
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

    /* Thêm một dòng departure (start_date, end_date, current_price, available_slots, remove) */
    function addDeparture() {
        const wrapper = document.getElementById('departure-wrapper');

        const html = `
        <div class="d-flex gap-2 mt-2 align-items-center">
            <input type="date" name="departures[${departureIndex}][start_date]" class="form-control" required>
            <input type="date" name="departures[${departureIndex}][end_date]" class="form-control" required>
            <input type="number" name="departures[${departureIndex}][current_price]" class="form-control" placeholder="Giá bán hiện tại" min="0" required>
            <input type="number" name="departures[${departureIndex}][available_slots]" class="form-control" placeholder="Số chỗ tối đa" min="0" required>
            <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger">X</button>
        </div>
    `;
        wrapper.insertAdjacentHTML('beforeend', html);
        departureIndex++;
    }

    /* Khi load trang: tự tạo 1 destination + 1 departure để người dùng không phải bấm */
    document.addEventListener('DOMContentLoaded', function() {
        addDestination();
        addDeparture();
    });
</script>

<?php include PATH_VIEW . 'layout/footer.php'; ?>