<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
require 'config.php';

// Proses update status seleksi siswa
if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];

    // Update status siswa
    $stmt = $conn->prepare("UPDATE pendaftaran SET status_seleksi = ? WHERE id = ?");
    $stmt->execute([$status, $id]);

    // Menyimpan pesan untuk ditampilkan di notifikasi
    if ($status == 'Lolos') {
        $_SESSION['status_message'] = "Data Lolos untuk siswa ID $id!";
    } else {
        $_SESSION['status_message'] = "Data Tidak Lolos untuk siswa ID $id!";
    }

    header("Location: seleksi_siswa.php"); // Redirect untuk menghindari refresh yang menyebabkan duplikasi update
    exit();
}

// Menentukan filter untuk menampilkan siswa yang lolos atau tidak lolos
$filter = 'Belum Diseleksi'; // Default filter: Menampilkan siswa yang belum diseleksi
if (isset($_GET['status_filter'])) {
    $filter = $_GET['status_filter'];
}

// Ambil data siswa sesuai status seleksi
$stmt = $conn->prepare("SELECT * FROM pendaftaran WHERE status_seleksi = ? ORDER BY id ASC");
$stmt->execute([$filter]);
$siswa = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Seleksi Siswa</h2>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="seleksi_siswa.css">
    <script>
        // Fungsi untuk menampilkan notifikasi
        function showNotification(message) {
            alert(message); // Menggunakan alert untuk notifikasi sederhana
        }
    </script>
</head>

<body>
    <?php
    // Menampilkan notifikasi jika ada pesan dari session
    if (isset($_SESSION['status_message'])) {
        echo "<script>showNotification('" . $_SESSION['status_message'] . "');</script>";
        unset($_SESSION['status_message']); // Menghapus pesan setelah ditampilkan
    }
    ?>

    <form method="GET">
        <button type="submit" name="status_filter" value="Lolos">Lihat Siswa Lolos</button>
        <button type="submit" name="status_filter" value="Tidak Lolos">Lihat Siswa Tidak Lolos</button>
    </form>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th> <!-- Kolom untuk nomor urut -->
            <th>Nama Lengkap</th>
            <th>NIK</th>
            <th>TTL</th>
            <th>Jenis Kelamin</th>
            <th>Agama</th>
            <th>Status Seleksi</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; // Inisialisasi variabel untuk nomor urut 
        ?>
        <?php foreach ($siswa as $data): ?>
            <tr>
                <td><?php echo $no++; ?></td> <!-- Menampilkan nomor urut -->
                <td><?php echo htmlspecialchars($data['nama']); ?></td>
                <td><?php echo htmlspecialchars($data['nik']); ?></td>
                <td><?php echo htmlspecialchars($data['tempat_tanggal_lahir']); ?></td>
                <td><?php echo htmlspecialchars($data['jenis_kelamin']); ?></td>
                <td><?php echo htmlspecialchars($data['agama']); ?></td>
                <td><?php echo htmlspecialchars($data['status_seleksi']); ?></td>
                <td>
                    <?php if ($data['status_seleksi'] == 'Belum Diseleksi'): ?>
                        <a href="seleksi_siswa.php?id=<?php echo $data['id']; ?>&status=Lolos">Lolos</a> |
                        <a href="seleksi_siswa.php?id=<?php echo $data['id']; ?>&status=Tidak Lolos">Tidak Lolos</a>
                    <?php elseif ($data['status_seleksi'] == 'Lolos' || $data['status_seleksi'] == 'Tidak Lolos'): ?>
                        <a href="seleksi_siswa.php?id=<?php echo $data['id']; ?>&status=Belum Diseleksi">Kembalikan ke Belum Diseleksi</a>
                    <?php else: ?>
                        <span><?php echo $data['status_seleksi']; ?></span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="dashboard_admin.php"><button>Kembali ke Dashboard</button></a>
</body>

</html>