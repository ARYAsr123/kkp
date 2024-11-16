<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
require 'config.php';

// Ambil semua jadwal kegiatan dari database
$stmt = $conn->prepare("SELECT * FROM jadwal_kegiatan ORDER BY tanggal_mulai ASC");
$stmt->execute();
$kegiatan = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="jadwal.css">
</head>

<body>
    <h2>Jadwal Kegiatan</h2>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th> <!-- Menambahkan kolom nomor urut -->
            <th>Judul Kegiatan</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
        </tr>

        <?php
        $no = 1; // Inisialisasi nomor urut
        foreach ($kegiatan as $data): ?>
            <tr>
                <td><?php echo $no++; ?></td> <!-- Menampilkan nomor urut -->
                <td><?php echo htmlspecialchars($data['judul']); ?></td>
                <td><?php echo htmlspecialchars($data['tanggal_mulai']); ?></td>
                <td><?php echo htmlspecialchars($data['tanggal_selesai']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="dashboard_user.php"><button>Kembali ke Dashboard</button></a>
</body>

</html>