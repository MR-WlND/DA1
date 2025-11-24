<?php require_once __DIR__ . '/../../layout/header.php'; ?>

<h2>Edit Booking #<?= $booking['id'] ?></h2>

<form action="" method="POST">
    <label>Customer Name</label>
    <input type="text" name="customer_name" value="<?= $booking['customer_name'] ?>" required>

    <label>Tour</label>
    <select name="tour_id" required>
        <?php foreach ($tours as $tour): ?>
            <option value="<?= $tour['id'] ?>" <?= $tour['id'] == $booking['tour_id'] ? 'selected' : '' ?>>
                <?= $tour['name'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Quantity</label>
    <input type="number" name="quantity" value="<?= $booking['quantity'] ?>" required>

    <label>Total Price</label>
    <input type="number" name="total_price" value="<?= $booking['total_price'] ?>" required>

    <button type="submit">Update</button>
</form>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>