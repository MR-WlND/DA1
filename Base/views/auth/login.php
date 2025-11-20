<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/auth.css">
</head>

<body>
    <form action="?action=handleLogin" method="post" class="login-form">
        <h1 class="title">Login</h1>
        <?php if (isset($error)) : ?>
            <p style="color: red; text-align: center; margin-bottom: 15px;"><?= $error ?></p>
        <?php endif; ?>
        <div class="login box">
            <input class="field" type="email" id="login" name="email" required>
            <label for="login">Email</label>
        </div>
        <div class="password box">
            <input class="field" type="password" id="password" name="password" required>
            <input type="checkbox" id="hide" class="hide">
            <label for="password">Password</label>
        </div>
        <div class="options">
            <label class="remember-me">
                <input type="checkbox" name="remember"> Remember me <span class="checkmark"></span>
            </label>
            <a href="#" class="forgot-password">Forgot password?</a>
        </div>
        <input type="submit" name="login" class="button" value="Login">
        <p class="admin-contact">
            Bạn không có tài khoản? <a href="#">liên hệ với quản trị viên</a>.
        </p>
    </form>
    <script src="assets/js/auth.js"></script>
</body>

</html>