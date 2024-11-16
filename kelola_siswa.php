<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
require 'config.php';

// Ambil data siswa yang statusnya 'aktif'
$stmt = $conn->prepare("SELECT * FROM pendaftaran WHERE status = 'aktif' ORDER BY id ASC");
$stmt->execute();
$siswa = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="kelola_siswa.css">
</head>

<body>
    <h2>Kelola Data Siswa</h2>
    <div class="table-wrapper">
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>No</th> <!-- Menambahkan kolom untuk nomor urut -->
                <th>Nama</th>
                <th>NIK</th>
                <th>TTL</th>
                <th>Jenis Kelamin</th>
                <th>Agama</th>
                <th>Status Seleksi</th>
                <th>Aksi</th>
            </tr>

            <?php
            $no = 1; // Inisialisasi nomor urut
            foreach ($siswa as $data): ?>
                <tr>
                    <td><?php echo $no++; ?></td> <!-- Menampilkan nomor urut -->
                    <td><?php echo htmlspecialchars($data['nama']); ?></td>
                    <td><?php echo htmlspecialchars($data['nik']); ?></td>
                    <td><?php echo htmlspecialchars($data['tempat_tanggal_lahir']); ?></td>
                    <td><?php echo htmlspecialchars($data['jenis_kelamin']); ?></td>
                    <td><?php echo htmlspecialchars($data['agama']); ?></td>
                    <td><?php echo htmlspecialchars($data['status_seleksi']); ?></td>
                    <td>
                        <a href="edit_siswa.php?id=<?php echo $data['id']; ?>">Edit</a> |
                        <a href="hapus_siswa.php?id=<?php echo $data['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <a href="dashboard_admin.php"><button>Kembali ke Dashboard</button></a>
    <a href="tempat_sampah.php"><button>Tempat Sampah</button></a>
</body>

</html>