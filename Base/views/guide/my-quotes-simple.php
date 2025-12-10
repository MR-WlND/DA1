<div class="container my-5">
    <h2><?= $title ?></h2>

    <?php if (empty($data['quotesData'])): ?>
        <div class="alert alert-info">Bạn chưa có yêu cầu hoặc báo giá nào.</div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Yêu cầu #</th>
                    <th>Địa điểm</th>
                    <th>Giá cuối</th>
                    <th>Trạng thái Request</th>
                    <th>Trạng thái Quote</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $current_request_id = 0;
                foreach ($data['quotesData'] as $item): 
                    // Kiểm tra nếu đây là Request mới hoặc là một báo giá mới
                    $is_new_request = ($item['request_id'] != $current_request_id);
                    $current_request_id = $item['request_id'];
                ?>
                <tr>
                    <td><?= $item['request_id'] ?></td>
                    <td><?= $item['destination_notes'] ?></td>
                    
                    <?php if ($item['quote_id']): ?>
                        <td><?= number_format($item['final_price']) ?> VNĐ</td>
                        <td><?= $item['request_status'] ?></td>
                        <td><?= $item['quote_status'] ?></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-success">Chấp nhận</a>
                        </td>
                    <?php else: ?>
                        <td colspan="3" class="text-center text-muted">
                            Đang chờ báo giá từ Admin... (Status: <?= $item['request_status'] ?>)
                        </td>
                        <td></td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>