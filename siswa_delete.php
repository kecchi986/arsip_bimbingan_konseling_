<?php
require 'functions.php';
require_login();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    redirect('siswa.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Siswa - <?php echo $siswa['nama']; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Delete Siswa - <?php echo $siswa['nama']; ?></h1>
        <p>Are you sure you want to delete this siswa?</p>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $siswa['id']; ?>">
            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
            <a href="siswa.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html> 