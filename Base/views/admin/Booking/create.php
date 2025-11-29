<?php include_once __DIR__ . '/../layout/header.php'; ?>

<h2>Tạo booking mới</h2>

<form action="/booking/store" method="POST">
    <label>User:</label>
    <select name="user_id" required>
        <?php foreach ($users as $u): ?>
            <option value="<?= $u['id'] ?>"><?= $u['name'] ?></option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Room:</label>
    <select name="room_id" required>
        <?php foreach ($rooms as $r): ?>
            <option value="<?= $r['id'] ?>"><?= $r['name'] ?></option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Ngày bắt đầu:</label>
    <input type="date" name="start_date" required>
    <br><br>

    <label>Ngày kết thúc:</label>
    <input type="date" name="end_date" required>
    <br><br>

    <label>Tổng tiền:</label>
    <input type="number" name="total_price" required>
    <br><br>

    <button type="submit">Lưu</button>
</form>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>