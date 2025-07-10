<?php
require 'config.php';
require 'functions.php';
require_login();

// Query data bimbingan + siswa
$sql = "SELECT b.*, s.nama as nama_siswa FROM bimbingan b LEFT JOIN siswa s ON b.siswa_id = s.id ORDER BY b.tanggal DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Rekaman Bimbingan Konseling</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        .container {
            max-width: 1100px;
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            padding: 32px 40px 40px 40px;
        }
        .dashboard-header {
            font-size: 1.5em;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 18px;
        }
        .table-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }
        .toolbar-left {
            display: flex;
            gap: 8px;
        }
        .toolbar-right {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .btn-add {
            background: #1976d2;
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 1em;
        }
        .btn-nav {
            background: #888;
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 1em;
        }
        .btn-logout {
            background: #e53935;
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 1em;
        }
        .search-box {
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
            min-width: 220px;
        }
        .table-responsive {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }
        th, td {
            padding: 10px 12px;
            text-align: left;
        }
        th {
            background: #f5f5f5;
            color: #333;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background: #fafbfc;
        }
        .btn-view {
            background: #1976d2;
            color: #fff;
            border: none;
            padding: 4px 10px;
            border-radius: 3px;
            font-size: 0.95em;
            margin-right: 2px;
        }
        .btn-edit {
            background: #ff9800;
            color: #fff;
            border: none;
            padding: 4px 10px;
            border-radius: 3px;
            font-size: 0.95em;
            margin-right: 2px;
        }
        .btn-delete {
            background: #e53935;
            color: #fff;
            border: none;
            padding: 4px 10px;
            border-radius: 3px;
            font-size: 0.95em;
        }
        @media (max-width: 700px) {
            .container { padding: 12px; }
            .table-toolbar { flex-direction: column; align-items: flex-start; gap: 8px; }
            .toolbar-left { flex-direction: column; gap: 8px; }
            .toolbar-right { flex-direction: column; gap: 8px; }
        }
    </style>
    <script>
    function filterTable() {
        var input = document.getElementById('searchInput');
        var filter = input.value.toLowerCase();
        var table = document.getElementById('bimbinganTable');
        var trs = table.getElementsByTagName('tr');
        for (var i = 1; i < trs.length; i++) {
            var tds = trs[i].getElementsByTagName('td');
            var show = false;
            for (var j = 0; j < tds.length-1; j++) { // exclude action column
                if (tds[j].innerText.toLowerCase().indexOf(filter) > -1) {
                    show = true;
                    break;
                }
            }
            trs[i].style.display = show ? '' : 'none';
        }
    }
    </script>
</head>
<body>
    <div class="container">
        <div class="dashboard-header">Bimbingan</div>
        <div class="table-toolbar">
            <div class="toolbar-left">
                <a href="siswa.php" class="btn-nav">Siswa</a>
                <a href="layanan.php" class="btn-nav">Layanan</a>
                <a href="bimbingan_add.php" class="btn-add">Tambah Bimbingan</a>
            </div>
            <div class="toolbar-right">
                <input type="text" id="searchInput" class="search-box" onkeyup="filterTable()" placeholder="Search dengan isi atau nama siswa...">
                <a href="logout.php" class="btn-logout">Logout</a>
            </div>
        </div>
        <div class="table-responsive">
        <table id="bimbinganTable">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kegiatan</th>
                <th>Tempat</th>
                <th>Uraian</th>
                <th>Keterangan</th>
                <th>Siswa yang bersangkutan</th>
                <th>Aksi</th>
            </tr>
            <?php $no=1; while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($row['tanggal']) ?></td>
                <td><?= esc($row['kegiatan']) ?></td>
                <td><?= esc($row['tempat']) ?></td>
                <td><?= esc($row['uraian']) ?></td>
                <td><?= esc($row['keterangan']) ?></td>
                <td><?= esc($row['nama_siswa']) ?></td>
                <td>
                    <a href="bimbingan_view.php?id=<?= $row['id'] ?>" class="btn-view">View</a>
                    <a href="bimbingan_edit.php?id=<?= $row['id'] ?>" class="btn-edit">Edit</a>
                    <a href="bimbingan_delete.php?id=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('Hapus data ini?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        </div>
    </div>
</body>
</html> 