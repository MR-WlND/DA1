<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Cập nhật Tour :</h2>
    <div class="card">
        <div class="toph4">
            <h4><?= $data['name'] ?? 'Không tên' ?></h4>
        </div>

        <form action="<?= BASE_URL ?>?action=update-tour&id=<?= $data['id'] ?>" 
              method="post" enctype="multipart/form-data">

            <!-- Tên Tour -->
            <div class="form-group mb-3">
                <label class="form-label">Tên Tour:</label>
                <input type="text" name="name" class="form-control"
                       value="<?= $data['name'] ?? '' ?>" required>
            </div>

            <!-- Loại Tour -->
            <div class="form-group mb-3">
                <label class="form-label">Loại tour:</label>
                <select name="tour_type" class="form-control">
                    <option value="domestic" <?= ($data['tour_type'] == 'domestic') ? 'selected' : '' ?>>Nội địa</option>
                    <option value="international" <?= ($data['tour_type'] == 'international') ? 'selected' : '' ?>>Quốc tế</option>
                </select>
            </div>

            <!-- Giá gốc -->
            <div class="form-group mb-3">
                <label class="form-label">Giá gốc:</label>
                <input type="number" name="base_price" min="0" class="form-control"
                       value="<?= $data['base_price'] ?? '' ?>">
            </div>

            <!-- Mô tả -->
            <div class="form-group mb-3">
                <label class="form-label">Mô tả:</label>
                <textarea name="description" class="form-control" rows="4"><?= $data['description'] ?></textarea>
            </div>


            <!-- GALLERY -->
            <hr>
            <h4>Ảnh Gallery</h4>

            <?php $gallery = $data['gallery'] ?? []; ?>

            <!-- Hiển thị ảnh cũ -->
            <?php if (!empty($gallery)): ?>
                <label>Ảnh hiện tại:</label>
                <div class="d-flex flex-wrap gap-2 mb-2">
                    <?php foreach ($gallery as $img): ?>
                        <div style="width:80px; height:60px; position:relative;">
                            <img src="<?= BASE_ASSETS_UPLOADS . $img['image_url'] ?>" 
                                 style="width:100%; height:100%; object-fit:cover; border-radius:4px;">
                            <input type="hidden" name="gallery_images_old[]" value="<?= $img['image_url'] ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Upload ảnh mới -->
            <div class="form-group mb-3">
                <label>Thêm ảnh mới:</label>
                <input type="file" name="gallery_images[]" class="form-control" multiple>
            </div>


            <!-- LỘ TRÌNH -->
            <hr>
            <h4>Lộ trình (Điểm đến)</h4>

            <?php
                $destinations = $data['destinations'] ?? [];
                if (empty($destinations)) {
                    $destinations[] = ['destination_id' => '', 'order_number' => ''];
                }
            ?>

            <?php foreach ($destinations as $i => $dest): ?>
                <div class="d-flex gap-2 mt-2 align-items-center">

                    <select name="destinations[<?= $i ?>][destination_id]" class="form-control" required>
                        <option value="">-- Chọn điểm đến --</option>
                        <?php foreach ($listDestinations as $d): ?>
                            <?php $selected = ($dest['destination_id'] ?? $dest['id']) == $d['id'] ? 'selected' : '' ?>
                            <option value="<?= $d['id'] ?>" <?= $selected ?>><?= $d['name'] ?></option>
                        <?php endforeach; ?>
                    </select>

                    <input type="number" min="1" name="destinations[<?= $i ?>][order_number]"
                           class="form-control" value="<?= $dest['order_number'] ?>">

                    <!-- Nút xóa dòng -->
                    <button type="submit" name="remove_destination" value="<?= $i ?>" class="btn btn-danger">
                        X
                    </button>
                </div>
            <?php endforeach; ?>

            <button type="submit" name="add_destination" value="1" class="btn btn-nut mt-2">
                + Thêm điểm đến
            </button>


            <!-- LỊCH KHỞI HÀNH -->
            <hr>
            <h4>Lịch khởi hành</h4>

            <?php
                $departures = $data['departures'] ?? [];
                if (empty($departures)) {
                $departures[] = ['start_date' => '', 'end_date' => '', 'current_price' => '', 'available_slots' => ''];
                }
            ?>

            <?php foreach ($departures as $i => $dep): ?>
                <div class="d-flex gap-2 mt-2 align-items-center">
                    <input type="date" class="form-control"
                           name="departures[<?= $i ?>][start_date]"
                           value="<?= $dep['start_date'] ?>" required>

                    <input type="date" class="form-control"
                           name="departures[<?= $i ?>][end_date]"
                           value="<?= $dep['end_date'] ?>" required>

                    <input type="number" min="0" class="form-control"
                           name="departures[<?= $i ?>][current_price]"
                           value="<?= $dep['current_price'] ?>" placeholder="Giá bán" required>

                    <input type="number" min="0" class="form-control"
                           name="departures[<?= $i ?>][available_slots]"
                           value="<?= $dep['available_slots'] ?>" placeholder="Chỗ" required>

                    <!-- nút xóa -->
                    <button type="submit" name="remove_departure" value="<?= $i ?>" class="btn btn-danger" style="height:38px;">X</button>
                </div>
            <?php endforeach; ?>

            <button type="submit" name="add_departure" value="1" class="btn btn-nut mt-2">
                + Thêm lịch khởi hành
            </button>

            <hr>

            <button type="submit" class="btn btn-nut">Cập nhật Tour</button>
            <a href="<?= BASE_URL ?>?action=delete-tour&id=<?= $data['id'] ?>"
               onclick="return confirm('Bạn có chắc muốn xóa tour này không?')"
               class="btn btn-danger">Xóa</a>

        </form>

    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>