<?php
require 'config.php';
require 'functions.php';

$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    if ($password !== $password2) {
        $error = 'Konfirmasi password tidak sama!';
    } else {
        $cek = mysqli_query($conn, "SELECT id FROM user WHERE email='$email'");
        if (mysqli_num_rows($cek) > 0) {
            $error = 'Email sudah terdaftar!';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            mysqli_query($conn, "INSERT INTO user (email, password) VALUES ('$email', '$hash')");
            $success = 'Registrasi berhasil! Silakan login.';
            header('Location: index.php?register=success');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register User</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="login-box">
        <h2>Register</h2>
        <?php if ($error): ?>
            <div class="error"><?= esc($error) ?></div>
        <?php endif; ?>
        <form method="post">
            <label>E-Mail Address</label><br>
            <input type="email" name="email" required><br>
            <label>Password</label><br>
            <input type="password" name="password" required><br>
            <label>Konfirmasi Password</label><br>
            <input type="password" name="password2" required><br>
            <button type="submit">Register</button>
            <a href="index.php" class="btn">Login</a>
        </form>
    </div>
</body>
</html> 