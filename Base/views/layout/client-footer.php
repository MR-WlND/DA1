<!-- COMMITMENT SECTION -->
<section class="commitment-section">
    <div class="cs-inner">
        <div class="cs-top-title">TRIẾT LÝ PHỤNG SỰ</div>
        <h2>Cam Kết Tinh Thần Omotenashi</h2>
        <p class="cs-sub">Sự chăm sóc thầm lặng, chu đáo và trân trọng sâu sắc từng khoảnh khắc của quý khách.</p>
        <div class="commit-grid">
            <div class="commit-item">
                <div class="ci-icon"><i class="fas fa-money-bill-wave"></i></div>
                <h3>Minh Bạch Tuyệt Đối</h3>
                <p>Giá trọn gói minh bạch, không phí ẩn hay phụ phí ngoài kế hoạch.</p>
            </div>
            <div class="commit-item">
                <div class="ci-icon"><i class="fas fa-headset"></i></div>
                <h3>Concierge Riêng Biệt</h3>
                <p>Đội ngũ am hiểu sâu sắc văn hóa, túc trực hỗ trợ 24/7 từ tâm.</p>
            </div>
            <div class="commit-item">
                <div class="ci-icon"><i class="far fa-calendar-alt"></i></div>
                <h3>Linh Hoạt 100%</h3>
                <p>Đổi lịch trình hoặc bảo lưu trọn vẹn giá trị dễ dàng đến 7 ngày trước đi.</p>
            </div>
            <div class="commit-item border-0">
                <div class="ci-icon"><i class="fas fa-shield-alt"></i></div>
                <h3>Bảo Hiểm Toàn Diện</h3>
                <p>Gói bảo hiểm quốc tế tự động kích hoạt bảo vệ trọn vẹn hành trình.</p>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="client-footer">
    <div class="cf-inner">
        <div class="cf-top">
            <div>
                <a href="<?= BASE_URL ?>?action=public-tours" class="brand-wrap mb-4" style="text-decoration:none; display:flex; align-items:center; gap:12px;">
                    <div class="footer-logo-circle">
                        <div class="red-dot"></div>
                    </div>
                    <div class="brand-text">
                        <div class="brand-name" style="font-family:'Inter', sans-serif; font-size:1.45rem; font-weight:800; letter-spacing:0.5px; color:#222;">GlobeTrek</div>
                    </div>
                </a>
                <p class="cf-desc">Thiết kế những hải trình văn hóa và kỳ nghỉ dưỡng đẳng cấp thế giới theo tinh thần Omotenashi — Phụng sự từ tâm, trọn vẹn từng khoảnh khắc tĩnh tại khắp năm châu.</p>
                <div class="cf-info-text">
                    Giấy phép Lữ hành Quốc tế số: 79-1028/2024/TCDL-GP LHQT<br>
                    Trụ sở: Tòa nhà Zen Tower, 128 Nguyễn Huệ, Quận 1, TP. HCM
                </div>
            </div>
            <div>
                <h4>Điểm Đến Mùa Này</h4>
                <ul>
                    <li><a href="#">Thụy Sĩ Mùa Tuyết Trắng</a></li>
                    <li><a href="#">Bờ Biển Amalfi</a></li>
                    <li><a href="#">Cực Quang Iceland</a></li>
                    <li><a href="#">Kyoto Mùa Lá Đỏ</a></li>
                    <li><a href="#">New Zealand Vùng Hồ</a></li>
                </ul>
            </div>
            <div>
                <h4>Chăm Sóc & Quy Chuẩn</h4>
                <ul>
                    <li><a href="#">Quy chuẩn Phục vụ Omotenashi</a></li>
                    <li><a href="#" style="color: #c0392b;">Bảo hiểm Du lịch Toàn cầu</a></li>
                    <li><a href="#">Chính sách Đặt tour & Hoàn hủy</a></li>
                    <li><a href="#">Giải đáp thắc mắc thường gặp</a></li>
                </ul>
            </div>
            <div>
                <h4>Bản Tin Đặc Quyền</h4>
                <p class="cf-desc" style="font-size:0.85rem;">Đăng ký nhận tuyển tập hành trình mùa mới và voucher 500.000 VNĐ cho chuyến đi đầu tiên.</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="Email của quý khách..">
                    <button type="submit">Đăng Ký</button>
                </form>
                <div class="security-badge">
                    <i class="far fa-check-circle"></i> Bảo mật dữ liệu chuẩn PCI-DSS
                </div>
            </div>
        </div>
        <div class="cf-bottom">
            <div class="cf-copyright">© 2025 GlobeTrek Luxury Travel. Bản quyền được bảo lưu toàn diện.</div>
            <div class="cf-links">
                <a href="#">Điều khoản sử dụng</a>
                <span class="sep">·</span>
                <a href="#">Chính sách quyền riêng tư</a>
                <span class="sep">·</span>
                <a href="#">Chứng thực IATA & JATA</a>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Simple search filter
const navSearch = document.getElementById('navSearch');
if (navSearch) {
    navSearch.addEventListener('input', function() {
        const q = this.value.toLowerCase().trim();
        document.querySelectorAll('.tour-card').forEach(card => {
            const title = (card.querySelector('.tour-card-title')?.textContent || '').toLowerCase();
            const desc = (card.querySelector('.tour-card-desc')?.textContent || '').toLowerCase();
            card.closest('.tour-card-wrap') && (card.closest('.tour-card-wrap').style.display = (title.includes(q) || desc.includes(q)) ? '' : 'none');
        });
    });
}
</script>
</body>
</html>
