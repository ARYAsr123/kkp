<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
require 'config.php';

// Tambah Jadwal Kegiatan
if (isset($_POST['add'])) {
    $judul = $_POST['judul'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];

    $stmt = $conn->prepare("INSERT INTO jadwal_kegiatan (judul, tanggal_mulai, tanggal_selesai) VALUES (?, ?, ?)");
    $stmt->execute([$judul, $tanggal_mulai, $tanggal_selesai]);

    header("Location: setting.php");
    exit();
}

// Ambil semua jadwal kegiatan
$stmt = $conn->prepare("SELECT * FROM jadwal_kegiatan ORDER BY tanggal_mulai ASC");
$stmt->execute();
$kegiatan = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Setting Jadwal Kegiatan</h2>

<!-- Form untuk menambahkan kegiatan baru -->
<form method="POST">
    <input type="text" name="judul" placeholder="Judul Kegiatan" required>
    <input type="date" name="tanggal_mulai" required>
    <input type="date" name="tanggal_selesai" required>
    <button type="submit" name="add">Tambah Kegiatan</button>
</form>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="setting.css">
</head>

<body>
    <h3>Daftar Jadwal Kegiatan</h3>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Judul Kegiatan</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1; // Inisialisasi nomor urut
        foreach ($kegiatan as $data): ?>
            <tr>
                <td><?php echo $no++; ?></td> <!-- Menampilkan nomor urut -->
                <td><?php echo htmlspecialchars($data['judul']); ?></td>
                <td><?php echo date('d-m-Y', strtotime($data['tanggal_mulai'])); ?></td> <!-- Format tanggal mulai -->
                <td><?php echo date('d-m-Y', strtotime($data['tanggal_selesai'])); ?></td> <!-- Format tanggal selesai -->
                <td>
                    <a href="edit_kegiatan.php?id=<?php echo $data['id']; ?>">Edit</a> |
                    <a href="hapus_kegiatan.php?id=<?php echo $data['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="dashboard_admin.php"><button>Kembali ke Dashboard</button></a>
</body>

</html>