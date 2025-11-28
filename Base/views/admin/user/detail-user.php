<?php include 'views/layout/header.php'; ?>

<div class="main">
    <h2>Chi tiết người dùng :</h2>
    <div class="card">
        <div class="toph4">
            <h4><?= htmlspecialchars($user['name']) ?></h4>
        </div>
        <div class="detail-row">
            <div class="detail-label">ID:</div>
            <div class="detail-value"><?= $user['id'] ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Họ và tên:</div>
            <div class="detail-value"><?= htmlspecialchars($user['name']) ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Email:</div>
            <div class="detail-value"><?= htmlspecialchars($user['email']) ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Số điện thoại:</div>
            <div class="detail-value"><?= htmlspecialchars($user['phone']) ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Vai trò:</div>
            <div class="detail-value"><?= htmlspecialchars($user['role']) ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Ngày tạo:</div>
            <div class="detail-value"><?= date('d/m/Y H:i:s', strtotime($user['created_at'])) ?></div>
        </div>
    </div>

    <div class="mt-3">
        <a href="<?= BASE_URL ?>?action=list-user" class="btn btn-primary">Quay lại danh sách</a>
        <a href="<?= BASE_URL ?>?action=delete-user&id=<?= $user['id'] ?>"
            onclick="return confirm('Xóa người dùng này?')" class="btn btn-danger">Xóa</a>
    </div>

</div>

<?php include 'views/layout/footer.php'; ?>