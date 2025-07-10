<?php
// config.php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'arsip_bk';

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die('Koneksi gagal: ' . mysqli_connect_error());
}
?> 