<?php
$finance = $finance ?? [];
?>
<div class="container mt-4">
    <h2 class="mb-4">Quan ly doanh thu</h2>
    <table border="1" width="100%" cellpadding="10" cellspacing="0">
             <thead>
                <tr style="background:#eee;">
                    <th>ID</th>
                    <th>Booking ID</th>
                    <th>So tien</th>
                    <th>Loai giao dich</th>
                    <th>Ngay tao</th>
                </tr>
             </thead>
    <tbody>
        <?php if (empty($finances)) :?>
            <tr>
                <td colspan="5" style="text-align:center;">Khong co du lieu</td>
            </tr>
        <?php else: ?>
            <?php foreach ($finances as $item): ?>
                <tr>
                    <td><?= $item['id'] ?></td>
                        <td><?= $item['booking_id'] ?></td>
                        <td><?= number_format($item['amount']) ?>đ</td>
                        <td><?= $item['type'] ?></td>
                        <td><?= $item['created_at'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
    </table>
</div>
