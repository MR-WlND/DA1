        <?php include 'views/layout/header.php'; ?>
        <?php $action = $_GET['action'] ?? 'dashboard'; ?>


            <div class="main">
                <h2>Chi tiết người dùng: <?= $user['name'] ?></h2>

                <div class="detail-container">
                    <div class="detail-row">
                        <div class="detail-label">ID:</div>
                        <div class="detail-value"><?= $user['id'] ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Họ và tên:</div>
                        <div class="detail-value"><?= $user['name'] ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Email:</div>
                        <div class="detail-value"><?= $user['email'] ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Số điện thoại:</div>
                        <div class="detail-value"><?= $user['phone'] ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Vai trò:</div>
                        <div class="detail-value"><?= $user['role'] ?></div>
                    </div>
                    <?php if ($user['role'] == 'guide'): ?>
                        <div class="detail-row">
                            <div class="detail-label">Kinh nghiệm (năm):</div>
                            <div class="detail-value"><?= $user['hdv_experience'] ?? 'Chưa cập nhật' ?></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Ngôn ngữ:</div>
                            <div class="detail-value"><?= $user['hdv_languages'] ?? 'Chưa cập nhật' ?></div>
                        </div>
                    <?php endif; ?>
                    <div class="detail-row">
                        <div class="detail-label">Ngày tạo:</div>
                            <div class="detail-value"><?= date('d/m/Y H:i:s', strtotime($user['created_at'])) ?></div>
                    </div>
                </div>
                    <a href="<?= BASE_URL ?>?action=list-user" class="btn btn-danger">Quay lại danh sách</a>
            </div>

        <?php include 'views/layout/footer.php'; ?>