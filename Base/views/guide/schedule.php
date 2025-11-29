<?php include 'views/guide/layout/header.php'; ?>
<aside class="panel">
    <div class="search-row">
        <input id="search" type="search" placeholder="Tìm theo tên chuyến, hướng dẫn, mô tả...">
        <button id="reset" class="btn btn-secondary">Reset</button>
      </div>
    <h1>Lịch trình của hướng dẫn viên</h1>
    <p>Xin chào, <?= $_SESSION['user']['name'] ?></p>
    <a href="index.php?action=logout">Logout</a>
</aside>

<section class="detail">
    <div class="panel itinerary" id="detail">
        <div style="display:flex;justify-content:space-between;align-items:center">
          <div>
            <h2 id="d-title" style="margin:0;font-size:18px">Chọn lịch trình</h2>
            <div id="d-sub" style="font-size:13px;color:var(--muted)"></div>
          </div>
          <div class="actions">
            <button class="ghost">Chỉnh sửa</button>
            <button class="primary">Gửi thông báo</button>
          </div>
        </div>
    </div>
</section>


<?php include 'views/guide/layout/footer.php'; ?>