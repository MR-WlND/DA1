<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Thêm Hướng dẫn viên</h2>

    <form action="<?= BASE_URL ?>?action=create-guide" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Tên:</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Mật khẩu:</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="phone">Điện thoại:</label>
            <input type="text" name="phone" id="phone" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="category">Loại:</label>
            <select name="category" id="category" class="form-control" required>
                <option value="domestic">Nội địa</option>
                <option value="international">Quốc tế</option>
            </select>
        </div>

        <div class="form-group">
            <label for="specialty_route">Tuyến chuyên môn:</label>
            <input type="text" name="specialty_route" id="specialty_route" class="form-control">
        </div>

        <div class="form-group">
            <label for="specialty_group">Nhóm chuyên môn:</label>
            <select name="specialty_group" id="specialty_group" class="form-control">
                <option value="standard">Standard</option>
                <option value="vip">VIP</option>
                <option value="corporate">Corporate</option>
                <option value="leisure">Leisure</option>
            </select>
        </div>

        <div class="form-group">
            <label for="certification">Chứng chỉ:</label>
            <input type="text" name="certification" id="certification" class="form-control">
        </div>

        <div class="form-group">
            <label for="health_status">Tình trạng sức khỏe:</label>
            <input type="text" name="health_status" id="health_status" class="form-control">
        </div>

        <div class="form-group">
            <label for="experience_years">Kinh nghiệm (năm):</label>
            <input type="number" name="experience_years" id="experience_years" class="form-control" min="0">
        </div>

        <div class="form-group">
            <label for="languages">Ngôn ngữ:</label>
            <input type="text" name="languages" id="languages" class="form-control">
        </div>

        <div class="form-group">
            <label for="date_of_birth">Ngày sinh:</label>
            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control">
        </div>

        <div class="form-group">
            <label for="notes">Ghi chú:</label>
            <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label for="photo_url">Ảnh:</label>
            <input type="file" name="photo_url" id="photo_url" class="form-control">
        </div>

        <button type="submit" class="btn btn-nut mt-2">Thêm Hướng dẫn viên</button>
        <a href="<?= BASE_URL ?>?action=list-guide" class="btn btn-secondary mt-2">Quay lại</a>
    </form>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
