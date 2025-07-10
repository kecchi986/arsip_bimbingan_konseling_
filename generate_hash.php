<?php
// Jalankan file ini di browser untuk mendapatkan hash password admin123
$hash = password_hash('admin123', PASSWORD_DEFAULT);
echo "Hash untuk password admin123:<br><textarea cols=80 rows=2>" . $hash . "</textarea>";
?> 