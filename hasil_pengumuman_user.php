<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
require 'config.php';

// Ambil data siswa yang lolos seleksi dari database
$stmt = $conn->prepare("SELECT nama, jenis_kelamin FROM pendaftaran WHERE status_seleksi = 'Lolos' ORDER BY id ASC");
$stmt->execute();
$siswa_lolos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="hasil.css">
</head>

<body>
    <h2>Hasil Pengumuman - Siswa Lolos</h2>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Nama Lengkap</th>
            <th>Jenis Kelamin</th>
        </tr>

        <?php $no = 1; // Inisialisasi nomor urut 
        ?>
        <?php foreach ($siswa_lolos as $data): ?>
            <tr>
                <td><?php echo $no++; ?></td> <!-- Nomor urut -->
                <td><?php echo htmlspecialchars($data['nama']); ?></td>
                <td><?php echo htmlspecialchars($data['jenis_kelamin']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="dashboard_user.php"><button>Kembali ke Dashboard</button></a>
</body>

</html>