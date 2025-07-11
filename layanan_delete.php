<?php
require 'functions.php';
require_login();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    redirect('layanan.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Layanan - Admin</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Delete Layanan</h1>
        <p>Apakah Anda yakin ingin menghapus layanan ini?</p>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $layanan['id']; ?>">
            <button type="submit" name="delete" class="btn btn-danger">Hapus</button>
            <a href="layanan.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html> 