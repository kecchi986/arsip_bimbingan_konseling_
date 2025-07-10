<?php
require 'config.php';
require 'functions.php';
require_login();

$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = $_POST['old_password'];
    $new = $_POST['new_password'];
    $new2 = $_POST['new_password2'];
    $user_id = $_SESSION['user_id'];
    $q = mysqli_query($conn, "SELECT password FROM user WHERE id=$user_id");
    $row = mysqli_fetch_assoc($q);
    if (!password_verify($old, $row['password'])) {
        $error = 'Password lama salah!';
    } elseif ($new !== $new2) {
        $error = 'Konfirmasi password baru tidak sama!';
    } else {
        $hash = password_hash($new, PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE user SET password='$hash' WHERE id=$user_id");
        $success = 'Password berhasil diubah!';
    }
}
$email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'admin@school.com';
$page = 'password';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ganti Password - Arsip Bimbingan Konseling</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        body { background: #f4f7fb; margin: 0; padding: 0; }
        .layout { display: flex; min-height: 100vh; }
        .sidebar { width: 260px; background: #fff; border-right: 1px solid #e3eaf6; display: flex; flex-direction: column; justify-content: space-between; padding: 0; }
        .sidebar-header { font-size: 1.25em; font-weight: bold; color: #1976d2; padding: 32px 0 24px 32px; letter-spacing: 0.5px; }
        .sidebar-menu { flex: 1; }
        .sidebar-menu ul { list-style: none; padding: 0; margin: 0; }
        .sidebar-menu li { margin-bottom: 2px; }
        .sidebar-menu a { display: flex; align-items: center; padding: 12px 32px; color: #222; text-decoration: none; font-size: 1em; border-left: 4px solid transparent; transition: background 0.15s, border 0.15s; }
        .sidebar-menu a.active, .sidebar-menu a:hover { background: #e3eaf6; border-left: 4px solid #1976d2; color: #1976d2; }
        .sidebar-footer { padding: 24px 32px 32px 32px; border-top: 1px solid #e3eaf6; }
        .admin-info { display: flex; align-items: center; gap: 12px; margin-bottom: 18px; }
        .admin-avatar { width: 38px; height: 38px; background: #1976d2; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.3em; font-weight: bold; }
        .admin-details { display: flex; flex-direction: column; }
        .admin-name { font-weight: bold; font-size: 1em; }
        .admin-email { font-size: 0.95em; color: #555; }
        .btn-logout { background: #e53935; color: #fff; border: none; padding: 8px 0; border-radius: 6px; width: 100%; font-size: 1em; font-weight: 500; cursor: pointer; text-align: center; text-decoration: none; display: block; margin-top: 8px; transition: background 0.2s; }
        .btn-logout:hover { background: #b71c1c; }
        .main { flex: 1; padding: 0 0 0 0; min-width: 0; }
        .main-content { max-width: 500px; margin: 0 auto; padding: 48px 32px 32px 32px; }
        .main-content h1 { font-size: 2em; font-weight: bold; margin-bottom: 8px; color: #222; }
        .form-container { background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); padding: 32px 32px 24px 32px; }
        .form-table { width: 100%; border-collapse: collapse; }
        .form-table td { padding: 10px 6px; vertical-align: top; }
        .form-table label { font-weight: normal; color: #333; }
        .form-actions { text-align: right; padding-top: 18px; }
        .btn-simpan { background: #1976d2; color: #fff; border: none; padding: 7px 22px; border-radius: 4px; font-size: 1em; margin-left: 8px; }
        .btn-batal { background: #e53935; color: #fff; border: none; padding: 7px 22px; border-radius: 4px; font-size: 1em; }
        input[type="password"] { width: 100%; padding: 7px; border: 1px solid #ccc; border-radius: 4px; }
        .error { background: #e57373; color: #fff; padding: 8px; border-radius: 4px; margin-bottom: 12px; }
        .success { background: #43a047; color: #fff; padding: 8px; border-radius: 4px; margin-bottom: 12px; }
        @media (max-width: 900px) { .main-content { padding: 32px 8px; } }
        @media (max-width: 700px) { .sidebar { width: 100px; } .sidebar-header, .sidebar-footer { padding-left: 10px; padding-right: 10px; } .sidebar-menu a { padding: 12px 10px; font-size: 0.95em; } .main-content { padding: 18px 2px; } }
    </style>
</head>
<body>
<div class="layout">
    <div class="sidebar">
        <div>
            <div class="sidebar-header">Arsip Bimbingan Konseling</div>
            <nav class="sidebar-menu">
                <ul>
                    <li><a href="dashboard.php" class="<?= $page=='dashboard'?'active':'' ?>"><i class="fa fa-home" style="width:22px;"></i> Dashboard</a></li>
                    <li><a href="bimbingan_list.php" class="<?= $page=='bimbingan'?'active':'' ?>"><i class="fa fa-file-alt" style="width:22px;"></i> Rekaman Konseling</a></li>
                    <li><a href="siswa.php" class="<?= $page=='siswa'?'active':'' ?>"><i class="fa fa-users" style="width:22px;"></i> Data Siswa</a></li>
                    <li><a href="layanan.php" class="<?= $page=='layanan'?'active':'' ?>"><i class="fa fa-book" style="width:22px;"></i> Layanan</a></li>
                    <li><a href="ganti_password.php" class="<?= $page=='password'?'active':'' ?>"><i class="fa fa-key" style="width:22px;"></i> Ganti Password</a></li>
                </ul>
            </nav>
        </div>
        <div class="sidebar-footer">
            <div class="admin-info">
                <div class="admin-avatar">A</div>
                <div class="admin-details">
                    <div class="admin-name">Administrator</div>
                    <div class="admin-email"><?= esc($email) ?></div>
                </div>
            </div>
            <a href="logout.php" class="btn-logout"><i class="fa fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
    <div class="main">
        <div class="main-content">
            <h1>Ganti Password</h1>
            <div class="form-container">
                <?php if ($error): ?><div class="error"> <?= esc($error) ?> </div><?php endif; ?>
                <?php if ($success): ?><div class="success"> <?= esc($success) ?> </div><?php endif; ?>
                <form method="post">
                    <table class="form-table">
                        <tr>
                            <td style="width:180px;"><label>Password Lama</label></td>
                            <td><input type="password" name="old_password" required></td>
                        </tr>
                        <tr>
                            <td><label>Password Baru</label></td>
                            <td><input type="password" name="new_password" required></td>
                        </tr>
                        <tr>
                            <td><label>Konfirmasi Password Baru</label></td>
                            <td><input type="password" name="new_password2" required></td>
                        </tr>
                    </table>
                    <div class="form-actions">
                        <a href="dashboard.php" class="btn-batal">Batal</a>
                        <button type="submit" class="btn-simpan">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html> 