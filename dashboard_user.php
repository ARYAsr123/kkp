<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <link rel="stylesheet" href="dashboard_user.css">
</head>

<body class="dashboard">

    <!-- Navigasi -->
    <nav>
        <div class="menu">
            <a href="jadwal_kegiatan_user.php">Jadwal Kegiatan</a>
            <a href="hasil_pengumuman_user.php">Pengumuman</a>
            <a href="tentang.php">Tentang PPDB</a>
        </div>
        <button class="logout-btn" onclick="window.location.href='login.php'">Logout</button>
    </nav>

    <!-- Konten Utama -->
    <div class="dashboard-container">
        <h2>Selamat Datang Di PPDB Online</h2>
        <p>Sekolah SDN Sukamanah 01</p>
        <p>Halo, <?php echo $_SESSION['username']; ?>! Selamat datang di sistem pendaftaran kami.</p>
        <a class="daftar-btn" href="form_pendaftaran.php">Daftar</a>
    </div>

</body>

</html>