<?php
require 'config.php';
require 'functions.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $query = "SELECT * FROM user WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_email'] = $row['email'];
            redirect('dashboard.php');
        } else {
            $error = 'Password salah!';
        }
    } else {
        $error = 'Email tidak ditemukan!';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Arsip BK</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="login-box">
        <h2>Login</h2>
        <?php if ($error): ?>
            <div class="error"><?= esc($error) ?></div>
        <?php endif; ?>
        <form method="post">
            <label>E-Mail Address</label><br>
            <input type="email" name="email" required><br>
            <label>Password</label><br>
            <input type="password" name="password" required><br>
            <label><input type="checkbox" name="remember"> Remember Me</label><br>
            <button type="submit">Login</button>
            <a href="#" class="forgot">Forgot Your Password?</a>
            <br><br>
            <a href="register.php" class="btn">Register</a>
        </form>
    </div>
</body>
</html>
