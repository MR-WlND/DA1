<?php 
// File: views/admin/logistics/update-resource.php
include PATH_VIEW . 'layout/header.php'; 

// Dữ liệu phân bổ hiện tại được Controller truyền vào
$resource = $resource ?? []; 

// Lấy các giá trị cũ
$current_resource_type = $resource['resource_type'] ?? '';
$current_resource_id = $resource['resource_id'] ?? null;
$current_departure_id = $resource['departure_id'] ?? null;

// Khối này tạo chuỗi <option> HTML từ các danh sách Master Data
// Lưu ý: Chúng ta không cần pre-select ở đây vì logic chọn sẽ nằm trong hàm JS

$guideOptions = '';
foreach ($listGuides as $g) {
    // Thêm thuộc tính 'selected' nếu ID khớp
    $selected = ($g['id'] == $current_resource_id && $current_resource_type == 'guide') ? 'selected' : '';
    $guideOptions .= "<option value='{$g['id']}' {$selected}>{$g['name']} ({$g['languages']})</option>";
}

$hotelOptions = '';
foreach ($listHotels as $h) {
    $selected = ($h['id'] == $current_resource_id && $current_resource_type == 'hotel') ? 'selected' : '';
    $hotelOptions .= "<option value='{$h['id']}' {$selected}>{$h['name']} ({$h['address']})</option>";
}

$transportOptions = '';
foreach ($listTransport as $t) {
    $selected = ($t['id'] == $current_resource_id && $current_resource_type == 'transport') ? 'selected' : '';
    $transportOptions .= "<option value='{$t['id']}' {$selected}>{$t['supplier_name']} ({$t['phone']})</option>";
}
?>

<div class="main">
    <h2>Cập nhật Phân bổ Tài nguyên #<?= $resource['id'] ?? 'N/A' ?></h2>
    <div class="card p-4">
        <form action="<?= BASE_URL ?>?action=update-resource&id=<?= $resource['id'] ?? '' ?>" method="post">
            
            <div class="form-group mb-4">
                <label for="departure_id" class="form-label">Chọn Chuyến Khởi Hành:</label>
                <select name="departure_id" id="departure_id" class="form-control" required>
                    <option value="">-- Chọn chuyến đi --</option>
                    <?php foreach ($listDepartures as $dep): ?>
                        <option 
                            value="<?= $dep['departure_id'] ?>" 
                            <?= ($dep['departure_id'] == $current_departure_id) ? 'selected' : '' ?>>
                            <?= $dep['tour_name'] ?? 'N/A' ?> 
                            (Ngày: <?= date('d/m/Y', strtotime($dep['start_date'])) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group mb-4">
                <label for="resource_type" class="form-label">Loại Tài nguyên:</label>
                <select name="resource_type" id="resource_type" class="form-control" onchange="updateResourceFields(this.value)" required>
                    <option value="guide" <?= ($current_resource_type == 'guide') ? 'selected' : '' ?>>Hướng dẫn viên</option>
                    <option value="hotel" <?= ($current_resource_type == 'hotel') ? 'selected' : '' ?>>Khách sạn/Lưu trú</option>
                    <option value="transport" <?= ($current_resource_type == 'transport') ? 'selected' : '' ?>>Vận tải/Xe</option>
                    <option value="other" <?= ($current_resource_type == 'other') ? 'selected' : '' ?>>Chi phí khác (Ghi chú)</option>
                </select>
            </div>
            
            <div id="resource-selection-area" class="mb-4">
                <p class="text-muted small">Vui lòng chọn loại tài nguyên để tiếp tục phân bổ.</p>
            </div>

            <div class="form-group mb-3">
                <label for="cost" class="form-label">Chi phí dự kiến (VNĐ):</label>
                <input type="number" name="cost" id="cost" class="form-control" min="0" required
                       value="<?= $resource['cost'] ?? 0 ?>">
            </div>

            <div class="form-group mb-3">
                <label for="details" class="form-label">Ghi chú/Mô tả chi tiết:</label>
                <textarea name="details" id="details" class="form-control" rows="2"><?= $resource['details'] ?? '' ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Lưu Cập Nhật</button>
            <a href="<?= BASE_URL ?>?action=list-resource" class="btn btn-danger mt-3">Hủy</a>
        </form>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
<script>
    // 1. Chuyển các biến PHP thành biến JS để sử dụng
    const guideOptions = `<?= $guideOptions ?>`;
    const hotelOptions = `<?= $hotelOptions ?>`;
    const transportOptions = `<?= $transportOptions ?>`;
    
    // Hàm chính thay đổi form dựa trên loại tài nguyên (resource_type)
    function updateResourceFields(type) {
        const selectionArea = document.getElementById('resource-selection-area');
        let content = '';

        // Tùy chỉnh nội dung dựa trên loại được chọn
        if (type === 'guide') {
            content = `
                <div class="form-group">
                    <label for="guide_id" class="form-label">Chọn Hướng dẫn viên:</label>
                    <select name="guide_id" id="guide_id" class="form-control" required>
                        <option value="">-- Chọn HDV --</option>
                        ${guideOptions}
                    </select>
                </div>`;
        } else if (type === 'hotel') {
            content = `
                <div class="form-group">
                    <label for="hotel_id" class="form-label">Chọn Khách sạn:</label>
                    <select name="hotel_id" id="hotel_id" class="form-control" required>
                        <option value="">-- Chọn Khách sạn --</option>
                        ${hotelOptions}
                    </select>
                </div>`;
        } else if (type === 'transport') {
            content = `
                <div class="form-group">
                    <label for="transport_id" class="form-label">Chọn NCC Vận tải:</label>
                    <select name="transport_id" id="transport_id" class="form-control" required>
                        <option value="">-- Chọn NCC --</option>
                        ${transportOptions}
                    </select>
                </div>`;
        } else if (type === 'other') {
             // Đối với 'other', chỉ cần ghi chi tiết vào trường details
             content = `<p class="alert alert-info small mt-2">Vui lòng nhập chi tiết chi phí khác vào trường Ghi chú.</p>`;
        } else {
            content = `<p class="text-muted small">Vui lòng chọn loại tài nguyên.</p>`;
        }

        selectionArea.innerHTML = content;
    }
    
    // Khởi tạo form khi tải trang (đảm bảo dropdown hoạt động)
    document.addEventListener('DOMContentLoaded', function() {
        const initialType = document.getElementById('resource_type').value;
        updateResourceFields(initialType);
    });
</script>