<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Thêm người dùng mới</h2>

    <form action="<?= BASE_URL ?>?action=create-user" method="post">
        <div class="form-group">
            <label for="name" class="form-label">Họ và tên:</label>
            <input type="text" class="form-control" id="name" placeholder="Nhập họ tên" name="name" required>
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" placeholder="Nhập email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Mật khẩu:</label>
            <input type="password" class="form-control" id="password" placeholder="Nhập mật khẩu" name="password" required>
        </div>

        <div class="form-group">
            <label for="phone" class="form-label">Số điện thoại:</label>
            <input type="tel" class="form-control" id="phone" placeholder="Nhập số điện thoại" name="phone" required>
        </div>

        <div class="form-group">
            <label for="role" class="form-label">Vai trò:</label>
            <select class="form-control form-select" id="role" name="role">
                <option value="customer">Customer</option>
                <option value="guide">Guide</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <div id="guide-fields">
            <div class="form-group">
                <label for="hdv_experience" class="form-label">Kinh nghiệm (năm):</label>
                <input type="number" class="form-control" id="hdv_experience" name="hdv_experience">
            </div>

            <div class="form-group">
                <label for="hdv_languages" class="form-label">Ngôn ngữ:</label>
                <input type="text" class="form-control" id="hdv_languages" name="hdv_languages">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Thêm mới</button>
        <a href="<?= BASE_URL ?>?action=list-user" class="btn btn-danger">Quay lại</a>
    </form>

    <script>
        const roleSelect = document.getElementById("role");
        const guideFields = document.getElementById("guide-fields");

        function toggleGuideFields() {
            guideFields.style.display = roleSelect.value === "guide" ? "block" : "none";
        }

        roleSelect.addEventListener("change", toggleGuideFields);
        toggleGuideFields();
    </script>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
