<!-- COMMITMENT SECTION -->
<section class="commitment-section">
    <div class="cs-inner">
        <h2>Cam Kết Tình Thần Omotenashi</h2>
        <p class="cs-sub">Sự hài lòng của bạn là ưu tiên số một của chúng tôi. Chúng tôi cam kết mang lại trải nghiệm du lịch trọn vẹn.</p>
        <div class="commit-grid">
            <div class="commit-item">
                <div class="ci-icon"><i class="fas fa-shield-alt"></i></div>
                <h3>Hoàn Tiền Đảm Bảo</h3>
                <p>Nếu không hài lòng trong 24 giờ đầu, chúng tôi hoàn tiền 100% không câu hỏi.</p>
            </div>
            <div class="commit-item">
                <div class="ci-icon"><i class="fas fa-headset"></i></div>
                <h3>Điểm Đón Mọi Nơi</h3>
                <p>Hỗ trợ đón trả khách tại nhiều điểm trên toàn quốc, tận nơi – tiện lợi tối đa.</p>
            </div>
            <div class="commit-item">
                <div class="ci-icon"><i class="fas fa-star"></i></div>
                <h3>Chăm Sóc & Duy Chuẩn</h3>
                <p>Đội ngũ hướng dẫn viên chuyên nghiệp, dịch vụ 5 sao trong từng hành trình.</p>
            </div>
            <div class="commit-item">
                <div class="ci-icon"><i class="fas fa-lock"></i></div>
                <h3>Bảo Tin Tức Quyền Riêng</h3>
                <p>Thông tin cá nhân và thanh toán của bạn được mã hóa và bảo vệ tuyệt đối.</p>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="client-footer">
    <div class="cf-inner">
        <div class="cf-top">
            <div>
                <div class="cf-brand">GlobeTrek</div>
                <p class="cf-desc">Nền tảng đặt tour du lịch hàng đầu Việt Nam. Kết nối bạn với những hành trình khó quên khắp thế giới.</p>
                <div class="cf-socials">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
            <div>
                <h4>Điểm Đến Nổi Bật</h4>
                <ul>
                    <li><a href="#">Phú Quốc, Việt Nam</a></li>
                    <li><a href="#">Sapa, Việt Nam</a></li>
                    <li><a href="#">Đà Nẵng, Việt Nam</a></li>
                    <li><a href="#">Seoul, Hàn Quốc</a></li>
                    <li><a href="#">Tokyo, Nhật Bản</a></li>
                </ul>
            </div>
            <div>
                <h4>Chăm Sóc & Dịch Vụ</h4>
                <ul>
                    <li><a href="<?= BASE_URL ?>?action=public-tours">Danh Sách Tour</a></li>
                    <li><a href="<?= BASE_URL ?>?action=request-tour">Tour Tùy Chỉnh</a></li>
                    <?php if (!empty($_SESSION['user'])): ?>
                    <li><a href="<?= BASE_URL ?>?action=my-bookings">Đơn Hàng Của Tôi</a></li>
                    <li><a href="<?= BASE_URL ?>?action=my-quotes">Báo Giá Của Tôi</a></li>
                    <?php else: ?>
                    <li><a href="<?= BASE_URL ?>?action=login">Đăng Nhập</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div>
                <h4>Hỗ Trợ Thêm Câu Hỏi</h4>
                <ul>
                    <li><a href="#">Câu hỏi thường gặp</a></li>
                    <li><a href="#">Chính sách hoàn tiền</a></li>
                    <li><a href="#">Điều khoản dịch vụ</a></li>
                    <li><a href="#">Liên hệ hỗ trợ</a></li>
                    <li><a href="#">Hotline: 1800 xxxx</a></li>
                </ul>
            </div>
        </div>
        <div class="cf-bottom">
            <span>© 2025 GlobeTrek. All rights reserved.</span>
            <span>Được xây dựng với ❤ tại Việt Nam</span>
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
