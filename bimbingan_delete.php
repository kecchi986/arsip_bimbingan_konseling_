<?php
require 'functions.php';
require_login();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    redirect('bimbingan_list.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Bimbingan - <?php echo $bimbingan['nama_mahasiswa']; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Delete Bimbingan - <?php echo $bimbingan['nama_mahasiswa']; ?></h1>
        <p>Are you sure you want to delete this bimbingan?</p>
        <p>Nama Mahasiswa: <?php echo $bimbingan['nama_mahasiswa']; ?></p>
        <p>Tanggal Bimbingan: <?php echo $bimbingan['tanggal_bimbingan']; ?></p>
        <p>Jam Bimbingan: <?php echo $bimbingan['jam_bimbingan']; ?></p>
        <p>Keterangan: <?php echo $bimbingan['keterangan']; ?></p>
        <form action="" method="post">
            <input type="hidden" name="id_bimbingan" value="<?php echo $bimbingan['id_bimbingan']; ?>">
            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
            <a href="bimbingan_list.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html> 