<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Cập nhật chính sách hủy :</h2>

    <div class="card">
        <div class="toph4">
            <h4>Thông tin chính sách</h4>
        </div>

        <form action="<?= BASE_URL ?>?action=update-policy&id=<?= $policy['id'] ?>" method="post">

            <div class="form-group mb-3">
                <label for="policy_name" class="form-label">Tên chính sách:</label>
                <input type="text" class="form-control" id="policy_name" name="policy_name"
                    value="<?=$policy['policy_name'] ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="details" class="form-label">Nội dung chi tiết:</label>
                <textarea class="form-control" id="details" name="details" rows="4" required><?= htmlspecialchars($policy['details']) ?></textarea>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-nut">Cập nhật</button>
                <a onclick="return confirm('Xóa chính sách này?')"
                    href="<?= BASE_URL ?>?action=delete-policy&id=<?= $policy['id'] ?>"
                    class="btn btn-danger">Xóa</a>
            </div>

        </form>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>