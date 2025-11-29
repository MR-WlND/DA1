<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <h2>Quản lý chính sách hủy</h2>

    <div class="card">
        <div class="toph4">
            <h4>Danh sách chính sách hủy</h4>
            <a href="<?= BASE_URL ?>?action=create-policy" class="btn btn-nut">+ Thêm chính sách</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên chính sách</th>
                    <th>Chi tiết</th>
                    <th>Ngày tạo</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($listPolicies as $policy): ?>
                    <tr>
                        <td><?= $policy['id'] ?></td>
                        <td><?= $policy['policy_name'] ?></td>
                        <td><?= nl2br($policy['details']) ?></td>
                        <td><?= date('d/m/Y', strtotime($policy['created_at'])) ?></td>

                        <td>
                            <a href="<?= BASE_URL ?>?action=update-policy&id=<?= $policy['id'] ?>" class="btn edit">Quản lý</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>

        </table>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>
