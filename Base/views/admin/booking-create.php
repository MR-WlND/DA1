<?php require_once __DIR__ . '/../../layout/header.php'; ?>

<div class="container mt-4">
    <h2>Thêm Booking</h2>

    <form method="POST">
        <label>Khách hàng</label>
        <input type="text" name="customer_name" class="form-control" required>

        <label class="mt-3">Tour</label>
        <select name="tour_id" class="form-control">
            <?php foreach ($tours as $t): ?>
                <option value="<?= $t['id'] ?>"><?= $t['name'] ?></option>
            <?php endforeach; ?>
        </select>

        <label class="mt-3">Số lượng</label>
        <input type="number" name="quantity" class="form-control" required>

        <label class="mt-3">Tổng tiền</label>
        <input type="number" name="total_price" class="form-control" required>

        <button class="btn btn-primary mt-3">Lưu</button>
    </form>
</div>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>