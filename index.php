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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        body {
            background: #f4f7fb;
            min-height: 100vh;
        }
        .login-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .login-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.08);
            padding: 40px 36px 32px 36px;
            max-width: 370px;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .login-logo {
            background: #1976d2;
            color: #fff;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2em;
            margin-bottom: 18px;
        }
        .login-title {
            font-size: 1.5em;
            font-weight: bold;
            color: #222;
            margin-bottom: 8px;
        }
        .login-subtitle {
            color: #555;
            margin-bottom: 24px;
            font-size: 1em;
        }
        .login-card form {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .login-card label {
            font-weight: 500;
            color: #222;
        }
        .login-card input[type="email"],
        .login-card input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }
        .login-card button {
            width: 100%;
            background: #1976d2;
            color: #fff;
            border: none;
            padding: 12px 0;
            border-radius: 5px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            margin: 0;
            transition: background 0.2s;
        }
        .login-card button:hover {
            background: #1256a3;
        }
        .login-card .btn {
            width: 100%;
            display: block;
            text-align: center;
            background: #43a047;
            color: #fff;
            border-radius: 5px;
            padding: 12px 0;
            font-size: 1.1em;
            font-weight: bold;
            text-decoration: none;
            margin: 0;
            transition: background 0.2s;
        }
        .login-card .btn:hover {
            background: #2e7031;
        }
        .login-card .forgot {
            display: block;
            text-align: right;
            color: #1976d2;
            font-size: 0.98em;
            margin-bottom: 8px;
            text-decoration: none;
        }
        .login-card .forgot:hover {
            text-decoration: underline;
        }
        .error {
            background: #e57373;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 16px;
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-logo"><i class="fa fa-user-lock"></i></div>
            <div class="login-title">Login</div>
            <div class="login-subtitle">Arsip Bimbingan Konseling</div>
            <?php if ($error): ?>
                <div class="error"><?= esc($error) ?></div>
            <?php endif; ?>
            <form method="post">
                <label>E-Mail Address</label>
                <input type="email" name="email" required autofocus>
                <label>Password</label>
                <input type="password" name="password" required>
                <label style="font-weight:normal;"><input type="checkbox" name="remember"> Remember Me</label>
                <button type="submit">Login</button>
                <a href="register.php" class="btn">Register</a>
            </form>
        </div>
    </div>
</body>
</html>
