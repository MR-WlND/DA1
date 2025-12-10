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
      <button id="addLogBtn" class="ghost">Thêm ghi chú</button>
      <button class="danger">Hủy chuyến</button>
    </div>

    <!-- Log Section -->
    <div id="logSection" class="panel" style="margin-top:16px;">
        <h3 style="margin:0 0 12px 0; display: flex; justify-content: space-between; align-items: center;">
            <span>Nhật ký chuyến đi</span>
            <i id="logsSpinner" class="fas fa-spinner fa-spin" style="display: none;"></i>
        </h3>
        <div id="logHistory" style="margin-bottom: 16px;"></div>

        <!-- New Log Form -->
        <div id="logForm" style="display:none;">
            <h4 style="margin:0 0 8px 0">Thêm nhật ký mới</h4>
            <textarea id="logContent" placeholder="Nhập nội dung nhật ký..." style="width:100%;min-height:80px;"></textarea>
            <div style="margin-top:8px;display:flex;gap:8px;">
                <button id="saveLogBtn" class="primary">Lưu nhật ký</button>
                <button id="cancelLogBtn" class="ghost">Hủy</button>
            </div>
        </div>
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
<a class="btn primary" href="index.php?action=logout">Logout</a>
<?php include 'views/guide/layout/footer.php'; ?>

<style>
.log-item {
    border-bottom: 1px solid #eee;
    padding: 8px 4px;
    margin-bottom: 8px;
}
.log-item:last-child {
    border-bottom: none;
}
.log-meta {
    font-size: 12px;
    margin-bottom: 4px;
}
.log-meta .muted {
    color: var(--muted);
}
.log-content {
    font-size: 14px;
    white-space: pre-wrap; /* To respect newlines */
}
.error {
    color: red;
    padding: 8px;
    border: 1px solid red;
    border-radius: 4px;
}
</style>

<script>
    // Inject server-side data and render with enhanced UI
    // Ghi chú: Cần đảm bảo PHP cung cấp a.guests_manifest và a.itinerary_stops
    window.__guideAssignments = <?= json_encode($assignments, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
    window.__guideStats = {
        total: <?= (int)$total ?>,
        upcoming: <?= (int)$upcoming ?>,
        guestTotal: <?= (int)$guestTotal ?>
    };

    // Helper functions (Giữ nguyên)
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

    function canTakeAttendance() {
        if (!currentDeparture || !currentDeparture.start_date || !currentDeparture.end_date) {
            return false;
        }
        const now = new Date();
        const startDate = new Date(currentDeparture.start_date);
        const endDate = new Date(currentDeparture.end_date);

        now.setHours(0, 0, 0, 0);
        startDate.setHours(0, 0, 0, 0);
        endDate.setHours(0, 0, 0, 0);

        return now >= startDate && now <= endDate;
    }

    // Track current selection and guest check-in state
    let currentDeparture = null;
    let guestCheckins = {}; // { guest_id: boolean }

    // --- MAIN RENDER ---
    (function renderGuideSchedule() {
        const list = document.getElementById('list');
        document.getElementById('total').textContent = window.__guideStats.total;
        document.getElementById('upcoming').textContent = window.__guideStats.upcoming;
        document.getElementById('guestTotal').textContent = window.__guideStats.guestTotal;

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
            // 🟢 Lấy số lượng khách thực tế từ manifest nếu có
            const guestCount = a.guests_manifest?.length || parseInt(a.total_booked_guests) || 0; 

            item.innerHTML = `
                <div style="font-weight:600;font-size:14px">${escapeHtml(a.tour_name || 'Chuyến chưa tên')}</div>
                <div class="meta" style="margin-top:4px">
                    <div><strong>Mã chuyến:</strong> #${a.departure_id}</div>
                    <div><strong>Khởi hành:</strong> ${startDate}</div>
                    <div><strong>Khách:</strong> <span style="font-weight:700;color:#4e54c8">${guestCount}</span> người</div>
                </div>
            `;

            item.addEventListener('click', function() {
                // Reset check-in state
                guestCheckins = {}; 
                
                // Remove previous selection
                document.querySelectorAll('.item.selected').forEach(el => el.classList.remove('selected'));
                item.classList.add('selected');
                currentDeparture = a;

                // Fill detail pane
                document.getElementById('d-title').textContent = escapeHtml(a.tour_name || 'Chuyến chưa tên');
                
                // 🛑 SỬA LỖI ĐỊNH DẠNG: Dùng formatDateTime cho ngày/giờ
                document.getElementById('d-sub').textContent = formatDateTime(a.start_date); 
                
                document.getElementById('d-guests').textContent = guestCount;
                document.getElementById('d-status').textContent = guestCount > 0 ? '✓ Có khách' : 'Chưa có khách';
                document.getElementById('d-id').textContent = a.departure_id;

                // 🟢 GỌI HÀM RENDER LỘ TRÌNH THỰC TẾ
                renderItinerary(a.itinerary_stops);

                // 🟢 GỌI HÀM RENDER DANH SÁCH KHÁCH THỰC TẾ
                renderGuestList(a.guests_manifest || []);

                // Fetch and render logs
                fetchAndRenderLogs(a.departure_id);
            });

            list.appendChild(item);
        });

        // Auto-click first
        const first = list.querySelector('.item');
        if (first) first.click();
    })();

    // 🛑 THÊM HÀM RENDER ITINERARY (Lộ trình chi tiết)
    function renderItinerary(stops) {
        const stopsEl = document.getElementById('d-stops');
        if (!stops || stops.length === 0) {
            stopsEl.innerHTML = '<div style="color:var(--muted);padding:8px">Không có thông tin lộ trình chi tiết.</div>';
            return;
        }

        let stopsHtml = '';
        stops.forEach(s => {
            stopsHtml += `<div class="stop">
                <div class="time">${escapeHtml(s.time_slot || 'N/A')}</div>
                <div style="flex:1">
                    <div style="font-weight:600;font-size:13px">${escapeHtml(s.activity || 'Hoạt động')}</div>
                    <div style="font-size:12px;color:var(--muted);margin-top:2px">Ngày ${s.day_number}</div>
                </div>
            </div>`;
        });
        stopsEl.innerHTML = stopsHtml;
    }


    // 🛑 HÀM RENDER GUEST LIST DÙNG DỮ LIỆU THỰC TẾ
    function renderGuestList(guests) {
        const guestList = document.getElementById('guestList');
        if (!guests || guests.length === 0) {
            guestList.innerHTML = '<div style="text-align:center;color:var(--muted);padding:16px">Chuyến này chưa có khách đặt</div>';
            updateAttendanceSummary(0);
            return;
        }

        let guestHtml = '';
        guests.forEach((guest, index) => {
            const id = guest.id || `mock-guest-${index}`;
            
            // Khởi tạo trạng thái check-in từ dữ liệu server (guest.is_checked_in)
            if (guestCheckins[id] === undefined) {
                guestCheckins[id] = guest.is_checked_in == 1; 
            }

            const isChecked = guestCheckins[id];
            const phone = escapeHtml(guest.phone || 'N/A');
            const name = escapeHtml(guest.name || `Khách ${index + 1}`);

            guestHtml += `
                <div class="guest">
                    <div class="left">
                        <div class="avatar-sm">${name.charAt(0).toUpperCase()}</div>
                        <div>
                            <div style="font-weight:600;font-size:13px">${name}</div>
                            <div style="font-size:12px;color:var(--muted)">Điện thoại: ${phone}</div>
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
        });
        guestList.innerHTML = guestHtml;
        updateAttendanceSummary(guests.length);
    }

    // --- CÁC HÀM KHÁC (GIỮ NGUYÊN) ---
    function toggleCheckin(guestId) {
        if (!canTakeAttendance()) {
            alert('Lỗi: Chỉ có thể điểm danh trong thời gian diễn ra chuyến đi.');
            return;
        }
        guestCheckins[guestId] = !guestCheckins[guestId];
        const checkbox = document.querySelector(`[data-guest-id="${guestId}"]`);
        checkbox.classList.toggle('checked');
        const timeSpan = checkbox.parentElement.querySelector('.checked-time');
        timeSpan.textContent = guestCheckins[guestId] ? '✓ Đã điểm danh' : 'Chờ';
        updateAttendanceSummary(currentDeparture?.guests_manifest?.length || 0); // Sửa lỗi gọi total_booked_guests
    }

    function updateAttendanceSummary(total) {
        const checked = Object.values(guestCheckins).filter(v => v).length;
        document.getElementById('attendanceSummary').textContent = `${checked} / ${total} đã điểm danh`;
    }

    // Filter and search functionality (Giữ nguyên)
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

    // Attendance controls (Sửa lại logic để dùng dữ liệu thực tế)
    document.getElementById('markAll').addEventListener('click', function() {
        if (!canTakeAttendance()) {
            alert('Lỗi: Chỉ có thể điểm danh trong thời gian diễn ra chuyến đi.');
            return;
        }
        if (!currentDeparture || !currentDeparture.guests_manifest) return;
        currentDeparture.guests_manifest.forEach(guest => {
             const id = guest.id || `mock-guest-${guest.index}`;
             guestCheckins[id] = true;
        });
        renderGuestList(currentDeparture.guests_manifest);
    });

    document.getElementById('clearAttendance').addEventListener('click', function() {
        if (!canTakeAttendance()) {
            alert('Lỗi: Chỉ có thể thao tác điểm danh trong thời gian diễn ra chuyến đi.');
            return;
        }
        guestCheckins = {};
        if (currentDeparture) renderGuestList(currentDeparture.guests_manifest || []);
    });

    document.getElementById('saveAttendance').addEventListener('click', function() {
        if (!canTakeAttendance()) {
            alert('Lỗi: Chỉ có thể lưu điểm danh trong thời gian diễn ra chuyến đi.');
            return;
        }
        alert('Đã lưu điểm danh! (Cần tích hợp AJAX gửi dữ liệu)');
    });

    // --- Log Functionality ---

    const addLogBtn = document.getElementById('addLogBtn');
    const logForm = document.getElementById('logForm');
    const cancelLogBtn = document.getElementById('cancelLogBtn');
    const saveLogBtn = document.getElementById('saveLogBtn');
    const logContent = document.getElementById('logContent');
    const logHistory = document.getElementById('logHistory');
    const logsSpinner = document.getElementById('logsSpinner');

    addLogBtn.addEventListener('click', () => {
        logForm.style.display = 'block';
        addLogBtn.style.display = 'none'; // Hide button when form is open
    });

    cancelLogBtn.addEventListener('click', () => {
        logForm.style.display = 'none';
        addLogBtn.style.display = ''; // Show button again
        logContent.value = ''; // Clear textarea
    });

    saveLogBtn.addEventListener('click', async () => {
        const content = logContent.value.trim();
        if (!content) {
            alert('Vui lòng nhập nội dung nhật ký.');
            return;
        }
        if (!currentDeparture) {
            alert('Lỗi: Chưa chọn chuyến đi.');
            return;
        }

        saveLogBtn.disabled = true;
        saveLogBtn.textContent = 'Đang lưu...';

        try {
            const response = await fetch('index.php?action=add_tour_log', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    departure_id: currentDeparture.departure_id,
                    log_content: content
                })
            });

            const result = await response.json();
            if (response.ok && result.success) {
                logContent.value = '';
                logForm.style.display = 'none';
                addLogBtn.style.display = '';
                await fetchAndRenderLogs(currentDeparture.departure_id); // Refresh logs
            } else {
                throw new Error(result.error || 'Không thể lưu nhật ký.');
            }
        } catch (error) {
            alert(`Lỗi: ${error.message}`);
        } finally {
            saveLogBtn.disabled = false;
            saveLogBtn.textContent = 'Lưu nhật ký';
        }
    });

    async function fetchAndRenderLogs(departureId) {
        if (!departureId) return;
        logsSpinner.style.display = 'block';
        logHistory.innerHTML = '';
        try {
            const response = await fetch(`index.php?action=get_tour_logs&departure_id=${departureId}`);
            const logs = await response.json();

            if (response.ok) {
                if (logs.error) throw new Error(logs.error);
                renderLogs(logs);
            } else {
                throw new Error((logs && logs.error) || 'Could not fetch logs.');
            }
        } catch (error) {
            logHistory.innerHTML = `<div class="error">Lỗi tải nhật ký: ${error.message}</div>`;
        } finally {
            logsSpinner.style.display = 'none';
        }
    }

    function renderLogs(logs) {
        if (!logs || logs.length === 0) {
            logHistory.innerHTML = '<div style="color:var(--muted);padding:8px">Chưa có nhật ký nào.</div>';
            return;
        }
        let html = '';
        logs.forEach(log => {
            html += `
                <div class="log-item">
                    <div class="log-meta">
                        <strong>${escapeHtml(log.staff_name)}</strong>
                        <span class="muted"> - ${formatDateTime(log.log_date)}</span>
                    </div>
                    <div class="log-content">${escapeHtml(log.log_content)}</div>
                </div>
            `;
        });
        logHistory.innerHTML = html;
    }
</script>