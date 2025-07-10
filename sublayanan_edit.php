<?php
require 'config.php';
require 'functions.php';
require_login();

$id = (int)($_GET['id'] ?? 0);
$q = mysqli_query($conn, "SELECT * FROM sublayanan WHERE id=$id");
$data = mysqli_fetch_assoc($q);
if (!$data) redirect('layanan.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    mysqli_query($conn, "UPDATE sublayanan SET nama='$nama' WHERE id=$id");
    redirect('layanan.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Sub Layanan</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h2>Edit Sub Layanan</h2>
    <form method="post">
        <label>Nama Sub Layanan</label><br>
        <input type="text" name="nama" value="<?= esc($data['nama']) ?>" required><br><br>
        <button type="submit">Update</button>
        <a href="layanan.php" class="btn">Batal</a>
    </form>
</body>
</html> 