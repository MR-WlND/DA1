<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Cập nhật Tour :</h2>
    <div class="card">
        <div class="toph4">
            <h4><?= htmlspecialchars($data['name'] ?? 'Không tên') ?></h4>
        </div>

        <form action="<?= BASE_URL ?>?action=update-tour&id=<?= $data['id'] ?>" method="post" enctype="multipart/form-data">

            <!-- Tên Tour -->
            <div class="form-group mb-3">
                <label for="name" class="form-label">Tên Tour:</label>
                <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($data['name'] ?? '') ?>" required>
            </div>

            <!-- Loại Tour -->
            <div class="form-group mb-3">
                <label for="tour_type" class="form-label">Loại tour:</label>
                <select name="tour_type" id="tour_type" class="form-control" required>
                    <option value="domestic" <?= ($data['tour_type'] ?? '') == 'domestic' ? 'selected' : '' ?>>Nội địa</option>
                    <option value="international" <?= ($data['tour_type'] ?? '') == 'international' ? 'selected' : '' ?>>Quốc tế</option>
                </select>
            </div>

            <!-- Mô tả -->
            <div class="form-group mb-3">
                <label for="description" class="form-label">Mô tả Tour:</label>
                <textarea name="description" id="description" class="form-control" rows="4"><?= htmlspecialchars($data['description'] ?? '') ?></textarea>
            </div>

            <!-- Gallery -->
            <div class="form-group mb-3">
                <label class="form-label">Ảnh Gallery hiện tại (<?= count($data['gallery'] ?? []) ?> ảnh):</label>
                <div class="d-flex flex-wrap gap-2 mb-2">
                    <?php foreach ($data['gallery'] ?? [] as $img): ?>
                        <div style="position: relative; width: 80px; height: 60px;">
                            <img src="<?= BASE_URL . 'assets/uploads/tours_gallery/' . htmlspecialchars($img['image_url']) ?>" 
                                 style="width:100%; height:100%; object-fit:cover; border-radius:4px;">
                            <input type="hidden" name="gallery_images_old[]" value="<?= htmlspecialchars($img['image_url']) ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
                <label for="gallery_images" class="form-label">Upload ảnh mới (sẽ thay thế ảnh cũ):</label>
                <input type="file" name="gallery_images[]" id="gallery_images" class="form-control" multiple accept="image/*">
            </div>

            <hr>

            <!-- Destinations -->
            <h4>Lộ trình (Điểm đến)</h4>
            <?php
            $destinations = $data['destinations'] ?? [];
            if (empty($destinations)) $destinations[] = ['destination_id' => '', 'order_number' => ''];
            foreach ($destinations as $i => $dest):
            ?>
                <div class="d-flex gap-2 mt-2 align-items-center">
                    <select name="destinations[<?= $i ?>][destination_id]" class="form-control" required>
                        <option value="">-- Chọn điểm đến --</option>
                        <?php foreach ($listDestinations ?? [] as $d): ?>
                            <option value="<?= $d['id'] ?>" <?= ($dest['destination_id'] ?? '') == $d['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($d['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" name="destinations[<?= $i ?>][order_number]" class="form-control" 
                           value="<?= $dest['order_number'] ?? '' ?>" min="1" required>
                </div>
            <?php endforeach; ?>
            <div class="mt-2">
                <button type="submit" name="add_destination" value="1" class="btn btn-nut">+ Thêm điểm đến</button>
            </div>

            <hr>

            <!-- Departures -->
            <h4>Lịch khởi hành</h4>
            <?php
            $departures = $data['departures'] ?? [];
            if (empty($departures)) $departures[] = ['start_date'=>'','end_date'=>'','current_price'=>'','available_slots'=>''];
            foreach ($departures as $i => $dep):
            ?>
                <div class="d-flex gap-2 mt-2 align-items-center">
                    <input type="date" name="departures[<?= $i ?>][start_date]" class="form-control" value="<?= $dep['start_date'] ?? '' ?>" required>
                    <input type="date" name="departures[<?= $i ?>][end_date]" class="form-control" value="<?= $dep['end_date'] ?? '' ?>" required>
                    <input type="number" name="departures[<?= $i ?>][current_price]" class="form-control" placeholder="Giá bán hiện tại" value="<?= $dep['current_price'] ?? '' ?>" min="0" required>
                    <input type="number" name="departures[<?= $i ?>][available_slots]" class="form-control" placeholder="Số chỗ tối đa" value="<?= $dep['available_slots'] ?? '' ?>" min="0" required>
                </div>
            <?php endforeach; ?>
            <div class="mt-2">
                <button type="submit" name="add_departure" value="1" class="btn btn-nut">+ Thêm lịch khởi hành</button>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-nut">Cập nhật Tour</button>
                <a href="<?= BASE_URL ?>?action=delete-tour&id=<?= $data['id'] ?>" 
                   onclick="return confirm('Bạn có chắc chắn muốn xóa tour này không?')" 
                   class="btn btn-danger">Xóa</a>
            </div>
        </form>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
