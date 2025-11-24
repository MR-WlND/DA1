<?php require_once PATH_VIEW . 'layouts/header.php'; ?>

<div class="container mt-4">
    <h2>Sửa Booking</h2>

    <form method="POST">
        <label>Khách hàng</label>
        <input value="<?= $booking['customer_name'] ?>" type="text" name="customer_name" class="form-control" required>

        <label class="mt-3">Tour</label>
        <select name="tour_id" class="form-control">
            <?php foreach ($tours as $t): ?>
                <option <?= $booking['tour_id'] == $t['id'] ? 'selected' : '' ?>
                    value="<?= $t['id'] ?>"><?= $t['name'] ?></option>
            <?php endforeach; ?>
        </select>

        <label class="mt-3">Số lượng</label>
        <input value="<?= $booking['quantity'] ?>" type="number" name="quantity" class="form-control" required>

        <label class="mt-3">Tổng tiền</label>
        <input value="<?= $booking['total_price'] ?>" type="number" name="total_price" class="form-control" required>

        <button class="btn btn-primary mt-3">Cập nhật</button>
    </form>
</div>

<?php require_once PATH_VIEW . 'layouts/footer.php'; ?>
