<?php include 'views/guide/layout/header.php'; ?>
<?php
// Provide defaults if controller didn't set them
$assignments = $assignments ?? [];
$total = $total ?? count($assignments);
$upcoming = $upcoming ?? 0;
$guestTotal = $guestTotal ?? 0;
?>

<aside class="panel">
  <div class="search-row">
    <input id="search" type="search" placeholder="Tìm theo tên chuyến, hướng dẫn, mô tả...">
    <button id="reset" class="btn">Reset</button>
  </div>

  <div class="filters" style="margin-top:12px">
    <div class="chip active" data-filter="all">Tất cả</div>
    <div class="chip" data-filter="Sắp diễn ra">Sắp diễn ra</div>
    <div class="chip" data-filter="Đã hoàn tất">Đã hoàn tất</div>
  </div>

  <div class="list" id="list"></div>
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

    <div class="stats" style="margin-top:14px">
      <div class="stat">
        <div style="font-size:12px;color:var(--muted)">Số khách</div>
        <div id="d-guests" style="font-weight:700;font-size:20px;margin-top:6px">—</div>
      </div>
      <div class="stat">
        <div style="font-size:12px;color:var(--muted)">Trạng thái</div>
        <div id="d-status" style="font-weight:700;font-size:20px;margin-top:6px">—</div>
      </div>
      <div class="stat">
        <div style="font-size:12px;color:var(--muted)">Mã chuyến</div>
        <div id="d-id" style="font-weight:700;font-size:20px;margin-top:6px">—</div>
      </div>
    </div>

    <div id="d-itinerary" style="margin-top:12px">
      <h3 style="margin:0 0 8px 0">Lộ trình chi tiết</h3>
      <div id="d-stops" class="stops"></div>
    </div>

    <!-- Guest list -->
    <div id="guestSection" class="guest-list">
      <div style="display:flex;align-items:center;justify-content:space-between">
        <div>
          <div style="font-weight:700">Danh sách khách</div>
          <div id="attendanceSummary" style="font-size:13px;color:var(--muted);margin-top:4px">0 / 0 đã điểm danh</div>
        </div>
        <div style="display:flex;gap:8px;align-items:center">
          <button id="markAll" class="btn">Điểm danh tất cả</button>
          <button id="exportCsv" class="btn">Xuất CSV</button>
        </div>
      </div>

      <div id="guestList" style="margin-top:12px"></div>

      <div class="guest-controls">
        <button id="saveAttendance" class="primary">Lưu điểm danh</button>
        <button id="clearAttendance" class="ghost">Xóa điểm danh</button>
      </div>
    </div>

    <div style="margin-top:12px;display:flex;gap:8px">
      <button class="primary">Bắt đầu chuyến</button>
      <button class="ghost">Thêm ghi chú</button>
      <button class="danger">Hủy chuyến</button>
    </div>
  </div>

  <div style="display:flex;gap:12px;flex-wrap:wrap">
    <div class="panel stat" style="min-width:180px">
      <div style="font-size:13px;color:var(--muted)">Tổng chuyến</div>
      <div id="total" style="font-weight:700;font-size:20px;margin-top:6px">0</div>
    </div>

    <div class="panel stat" style="min-width:180px">
      <div style="font-size:13px;color:var(--muted)">Sắp diễn ra</div>
      <div id="upcoming" style="font-weight:700;font-size:20px;margin-top:6px">0</div>
    </div>

    <div class="panel stat" style="min-width:180px">
      <div style="font-size:13px;color:var(--muted)">Khách tổng</div>
      <div id="guestTotal" style="font-weight:700;font-size:20px;margin-top:6px">0</div>
    </div>
  </div>
</section>
<a href="index.php?action=logout">Logout</a>
<?php include 'views/guide/layout/footer.php'; ?>

<script>
  // Inject server-side data and render with enhanced UI
  window.__guideAssignments = <?= json_encode($assignments, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
  window.__guideStats = {
    total: <?= (int)$total ?>,
    upcoming: <?= (int)$upcoming ?>,
    guestTotal: <?= (int)$guestTotal ?>
  };

  // Helper to escape HTML
  function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>\"']/g, function(s) {
      return {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#39;'
      } [s];
    });
  }

  // Helper to format date
  function formatDate(dateStr) {
    if (!dateStr) return 'N/A';
    const d = new Date(dateStr);
    return d.toLocaleDateString('vi-VN', {
      year: 'numeric',
      month: '2-digit',
      day: '2-digit'
    });
  }

  function formatDateTime(dateStr) {
    if (!dateStr) return 'N/A';
    const d = new Date(dateStr);
    return d.toLocaleDateString('vi-VN', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
      }) + ' ' +
      d.toLocaleTimeString('vi-VN', {
        hour: '2-digit',
        minute: '2-digit'
      });
  }

  // Track current selection and guest check-in state
  let currentDeparture = null;
  let guestCheckins = {};

  (function renderGuideSchedule() {
    const list = document.getElementById('list');
    const totalEl = document.getElementById('total');
    const upcomingEl = document.getElementById('upcoming');
    const guestTotalEl = document.getElementById('guestTotal');

    totalEl.textContent = window.__guideStats.total;
    upcomingEl.textContent = window.__guideStats.upcoming;
    guestTotalEl.textContent = window.__guideStats.guestTotal;

    if (!window.__guideAssignments || window.__guideAssignments.length === 0) {
      list.innerHTML = '<div style="padding:16px;text-align:center;color:var(--muted);border-radius:10px;background:#f9fafb"><i class="fas fa-calendar" style="font-size:24px;margin-bottom:8px;opacity:0.5;display:block"></i>Không có lịch trình được phân công</div>';
      return;
    }

    // Build list items
    list.innerHTML = '';
    window.__guideAssignments.forEach(function(a) {
      const item = document.createElement('div');
      item.className = 'item';
      const startDate = formatDate(a.start_date);
      const guestCount = parseInt(a.total_booked_guests) || 0;
      item.innerHTML = `
        <div style="font-weight:600;font-size:14px">${escapeHtml(a.tour_name || 'Chuyến chưa tên')}</div>
        <div class="meta" style="margin-top:4px">
          <div><strong>Mã chuyến:</strong> #${a.departure_id}</div>
          <div><strong>Khởi hành:</strong> ${startDate}</div>
          <div><strong>Khách:</strong> <span style="font-weight:700;color:#4e54c8">${guestCount}</span> người</div>
        </div>
      `;

      item.addEventListener('click', function() {
        // Remove previous selection
        document.querySelectorAll('.item.selected').forEach(el => el.classList.remove('selected'));
        item.classList.add('selected');
        currentDeparture = a;

        // Fill detail pane
        document.getElementById('d-title').textContent = escapeHtml(a.tour_name || 'Chuyến chưa tên');
        document.getElementById('d-sub').textContent = formatDateTime(a.start_date);
        document.getElementById('d-guests').textContent = guestCount;
        document.getElementById('d-status').textContent = guestCount > 0 ? '✓ Có khách' : 'Chưa có khách';
        document.getElementById('d-id').textContent = a.departure_id;

        // Render itinerary with sample stops
        const stops = [{
            time: '08:00',
            location: 'Điểm tập hợp',
            desc: 'Tập hợp và kiểm tra danh sách khách'
          },
          {
            time: '09:00',
            location: 'Khởi hành',
            desc: 'Lên xe và bắt đầu hành trình'
          },
          {
            time: '12:00',
            location: 'Dừng ăn trưa',
            desc: 'Nghỉ ngơi và ăn trưa'
          },
          {
            time: '18:00',
            location: 'Đích đến',
            desc: 'Kết thúc chuyến đi'
          }
        ];
        let stopsHtml = '';
        stops.forEach(s => {
          stopsHtml += `<div class="stop">
            <div class="time">${s.time}</div>
            <div style="flex:1">
              <div style="font-weight:600;font-size:13px">${s.location}</div>
              <div style="font-size:12px;color:var(--muted);margin-top:2px">${s.desc}</div>
            </div>
          </div>`;
        });
        document.getElementById('d-stops').innerHTML = stopsHtml;

        // guest list render
        renderGuestList(guestCount);
      });

      list.appendChild(item);
    });

    // Auto-click first
    const first = list.querySelector('.item');
    if (first) first.click();
  })();

  // Render guest list with check-in toggles
  function renderGuestList(count) {
    const guestList = document.getElementById('guestList');
    if (count === 0) {
      guestList.innerHTML = '<div style="text-align:center;color:var(--muted);padding:16px">Chuyến này chưa có khách đặt</div>';
      document.getElementById('attendanceSummary').textContent = '0 / 0 đã điểm danh';
      return;
    }

    // Generate mock guest data (in real app, fetch from server)
    let guestHtml = '';
    for (let i = 1; i <= count; i++) {
      const id = `guest-${i}`;
      const isChecked = guestCheckins[id] || false;
      guestHtml += `
        <div class="guest">
          <div class="left">
            <div class="avatar-sm">${String.fromCharCode(64 + i)}</div>
            <div>
              <div style="font-weight:600;font-size:13px">Khách ${i}</div>
              <div style="font-size:12px;color:var(--muted)">Điện thoại: 0123456789${i}</div>
            </div>
          </div>
          <div style="display:flex;align-items:center;gap:8px">
            <div class="checkbox ${isChecked ? 'checked' : ''}" data-guest-id="${id}" onclick="toggleCheckin('${id}')">
              ${isChecked ? '<i class="fas fa-check" style="font-size:10px"></i>' : ''}
            </div>
            <span class="checked-time">${isChecked ? '✓ Đã điểm danh' : 'Chờ'}</span>
          </div>
        </div>
      `;
    }
    guestList.innerHTML = guestHtml;
    updateAttendanceSummary(count);
  }

  function toggleCheckin(guestId) {
    guestCheckins[guestId] = !guestCheckins[guestId];
    const checkbox = document.querySelector(`[data-guest-id="${guestId}"]`);
    checkbox.classList.toggle('checked');
    const timeSpan = checkbox.parentElement.querySelector('.checked-time');
    timeSpan.textContent = guestCheckins[guestId] ? '✓ Đã điểm danh' : 'Chờ';
    updateAttendanceSummary(currentDeparture?.total_booked_guests || 0);
  }

  function updateAttendanceSummary(total) {
    const checked = Object.values(guestCheckins).filter(v => v).length;
    document.getElementById('attendanceSummary').textContent = `${checked} / ${total} đã điểm danh`;
  }

  // Filter and search functionality
  const searchInput = document.getElementById('search');
  const resetBtn = document.getElementById('reset');
  const filterChips = document.querySelectorAll('.chip');

  searchInput.addEventListener('input', function() {
    filterList();
  });

  resetBtn.addEventListener('click', function() {
    searchInput.value = '';
    filterChips.forEach(chip => chip.classList.remove('active'));
    document.querySelector('[data-filter="all"]').classList.add('active');
    filterList();
  });

  filterChips.forEach(chip => {
    chip.addEventListener('click', function() {
      filterChips.forEach(c => c.classList.remove('active'));
      this.classList.add('active');
      filterList();
    });
  });

  function filterList() {
    const searchTerm = searchInput.value.toLowerCase();
    const activeFilter = document.querySelector('.chip.active')?.getAttribute('data-filter') || 'all';
    const items = document.querySelectorAll('.item');

    items.forEach(item => {
      const text = item.textContent.toLowerCase();
      const matchesSearch = text.includes(searchTerm);
      const matchesFilter = activeFilter === 'all' || item.textContent.includes(activeFilter);
      item.style.display = matchesSearch && matchesFilter ? '' : 'none';
    });
  }

  // Attendance controls
  document.getElementById('markAll').addEventListener('click', function() {
    if (!currentDeparture) return;
    for (let i = 1; i <= (currentDeparture.total_booked_guests || 0); i++) {
      guestCheckins[`guest-${i}`] = true;
    }
    renderGuestList(currentDeparture.total_booked_guests);
  });

  document.getElementById('clearAttendance').addEventListener('click', function() {
    guestCheckins = {};
    if (currentDeparture) renderGuestList(currentDeparture.total_booked_guests);
  });

  document.getElementById('saveAttendance').addEventListener('click', function() {
    alert('Đã lưu điểm danh!');
  });
</script>