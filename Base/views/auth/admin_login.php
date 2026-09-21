<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal Login</title>
    <link rel="stylesheet" href="assets/css/auth.css">
</head>

<body>
    <form action="?action=handleAdminLogin" method="post" class="login-form" autocomplete="off">
        <h1 class="title">Admin Login</h1>
        <?php if (isset($error)) : ?>
            <p style="color: red; text-align: center; margin-bottom: 15px;"><?= $error ?></p>
        <?php endif; ?>
        <div class="login box">
            <input class="field" type="email" id="login" name="email" placeholder=" " autocomplete="new-password" required>
            <label for="login">Email</label>
        </div>
        <div class="password box">
            <input class="field" type="password" id="password" name="password" placeholder=" " autocomplete="new-password" required>
            <input type="checkbox" id="hide" class="hide">
            <label for="password">Password</label>
        </div>
        <div class="options">
            <label class="remember-me">
                <input type="checkbox" name="remember"> Remember me <span class="checkmark"></span>
            </label>
            <a href="#" class="forgot-password">Forgot password?</a>
        </div>
        <input type="submit" name="login" class="button" value="Admin Login">
        <p class="admin-contact">
            Đăng nhập hệ thống quản trị. Trở về <a href="<?= BASE_URL ?>?action=login">Đăng nhập khách hàng</a>.
        </p>
    </form>
    <script src="assets/js/auth.js"></script>
    <script>
        // Sử dụng setTimeout để đảm bảo ghi đè trình quản lý mật khẩu của trình duyệt
        window.addEventListener('pageshow', function() {
            setTimeout(function() {
                let emailInput = document.getElementById('login');
                let passInput = document.getElementById('password');
                if(emailInput) emailInput.value = '';
                if(passInput) passInput.value = '';
            }, 50);
        });
    </script>
</body>
</html>