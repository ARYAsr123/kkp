<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

require 'config.php';

$id = $_GET['id'] ?? null;

if ($id) {
    // Ambil data siswa dari database berdasarkan ID
    $stmt = $conn->prepare("SELECT * FROM pendaftaran WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $siswa = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$siswa) {
        echo "Data siswa tidak ditemukan.";
        exit();
    }
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $tempat_tanggal_lahir = $_POST['tempat_tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $status_seleksi = $_POST['status_seleksi'];
    $nama_ayah = $_POST['nama_ayah'];
    $nik_ayah = $_POST['nik_ayah'];
    $pekerjaan_ayah = $_POST['pekerjaan_ayah'];
    $pendidikan_ayah = $_POST['pendidikan_ayah'];
    $no_hp_ayah = $_POST['no_hp_ayah'];
    $tempat_tanggal_lahir_ayah = $_POST['tempat_tanggal_lahir_ayah'];
    $nama_ibu = $_POST['nama_ibu'];
    $nik_ibu = $_POST['nik_ibu'];
    $pekerjaan_ibu = $_POST['pekerjaan_ibu'];
    $pendidikan_ibu = $_POST['pendidikan_ibu'];
    $no_hp_ibu = $_POST['no_hp_ibu'];
    $tempat_tanggal_lahir_ibu = $_POST['tempat_tanggal_lahir_ibu'];

    // Update data siswa
    $stmt = $conn->prepare("UPDATE pendaftaran 
        SET nama = :nama, nik = :nik, tempat_tanggal_lahir = :tempat_tanggal_lahir, 
            jenis_kelamin = :jenis_kelamin, agama = :agama, status_seleksi = :status_seleksi, 
            nama_ayah = :nama_ayah, nik_ayah = :nik_ayah, pekerjaan_ayah = :pekerjaan_ayah, 
            pendidikan_ayah = :pendidikan_ayah, nomor_hp_ayah = :nomor_hp_ayah, 
            tempat_tanggal_lahir_ayah = :tempat_tanggal_lahir_ayah, 
            nama_ibu = :nama_ibu, nik_ibu = :nik_ibu, pekerjaan_ibu = :pekerjaan_ibu, 
            pendidikan_ibu = :pendidikan_ibu, nomor_hp_ibu = :nomor_hp_ibu, 
            tempat_tanggal_lahir_ibu = :tempat_tanggal_lahir_ibu
        WHERE id = :id");

    $stmt->bindParam(':nama', $nama);
    $stmt->bindParam(':nik', $nik);
    $stmt->bindParam(':tempat_tanggal_lahir', $tempat_tanggal_lahir);
    $stmt->bindParam(':jenis_kelamin', $jenis_kelamin);
    $stmt->bindParam(':agama', $agama);
    $stmt->bindParam(':status_seleksi', $status_seleksi);
    $stmt->bindParam(':nama_ayah', $nama_ayah);
    $stmt->bindParam(':nik_ayah', $nik_ayah);
    $stmt->bindParam(':pekerjaan_ayah', $pekerjaan_ayah);
    $stmt->bindParam(':pendidikan_ayah', $pendidikan_ayah);
    $stmt->bindParam(':nomor_hp_ayah', $no_hp_ayah);
    $stmt->bindParam(':tempat_tanggal_lahir_ayah', $tempat_tanggal_lahir_ayah);
    $stmt->bindParam(':nama_ibu', $nama_ibu);
    $stmt->bindParam(':nik_ibu', $nik_ibu);
    $stmt->bindParam(':pekerjaan_ibu', $pekerjaan_ibu);
    $stmt->bindParam(':pendidikan_ibu', $pendidikan_ibu);
    $stmt->bindParam(':nomor_hp_ibu', $no_hp_ibu);
    $stmt->bindParam(':tempat_tanggal_lahir_ibu', $tempat_tanggal_lahir_ibu);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "<script>
            alert('Data siswa berhasil diperbarui.');
            window.location.href = 'kelola_siswa.php'; // Redirect ke halaman kelola_siswa.php
        </script>";
    } else {
        echo "<script>
            alert('Gagal memperbarui data.');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="edit_siswa.css">
</head>

<body>

    <h2>Edit Data Siswa</h2>

    <form method="POST">
        <label for="nama">Nama Lengkap:</label>
        <input type="text" name="nama" value="<?php echo htmlspecialchars($siswa['nama']); ?>" required><br><br>

        <label for="nik">NIK:</label>
        <input type="text" name="nik" value="<?php echo htmlspecialchars($siswa['nik']); ?>" required><br><br>

        <label for="tempat_tanggal_lahir">Tempat Tanggal Lahir:</label>
        <input type="text" name="tempat_tanggal_lahir" value="<?php echo htmlspecialchars($siswa['tempat_tanggal_lahir']); ?>" required><br><br>

        <label for="jenis_kelamin">Jenis Kelamin:</label>
        <select name="jenis_kelamin" required>
            <option value="Laki-laki" <?php echo $siswa['jenis_kelamin'] == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
            <option value="Perempuan" <?php echo $siswa['jenis_kelamin'] == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
        </select><br><br>

        <label for="agama">Agama:</label>
        <input type="text" name="agama" value="<?php echo htmlspecialchars($siswa['agama']); ?>" required><br><br>

        <label for="status_seleksi">Status Seleksi:</label>
        <select name="status_seleksi" required>
            <option value="Belum Diseleksi" <?php echo $siswa['status_seleksi'] == 'Belum Diseleksi' ? 'selected' : ''; ?>>Belum Diseleksi</option>
            <option value="Lolos" <?php echo $siswa['status_seleksi'] == 'Lolos' ? 'selected' : ''; ?>>Lolos</option>
            <option value="Tidak Lolos" <?php echo $siswa['status_seleksi'] == 'Tidak Lolos' ? 'selected' : ''; ?>>Tidak Lolos</option>
        </select><br><br>

        <!-- Data Ayah -->
        <h3>Data Ayah</h3>
        <label for="nama_ayah">Nama Ayah:</label>
        <input type="text" name="nama_ayah" value="<?php echo htmlspecialchars($siswa['nama_ayah']); ?>" required><br><br>

        <label for="nik_ayah">NIK Ayah:</label>
        <input type="text" name="nik_ayah" value="<?php echo htmlspecialchars($siswa['nik_ayah']); ?>" required><br><br>

        <label for="pekerjaan_ayah">Pekerjaan Ayah:</label>
        <input type="text" name="pekerjaan_ayah" value="<?php echo htmlspecialchars($siswa['pekerjaan_ayah']); ?>" required><br><br>

        <label for="pendidikan_ayah">Pendidikan Ayah:</label>
        <input type="text" name="pendidikan_ayah" value="<?php echo htmlspecialchars($siswa['pendidikan_ayah']); ?>" required><br><br>

        <label for="no_hp_ayah">No HP Ayah:</label>
        <input type="text" name="no_hp_ayah" value="<?php echo htmlspecialchars($siswa['nomor_hp_ayah']); ?>" required><br><br>

        <label for="tempat_tanggal_lahir_ayah">Tempat Tanggal Lahir Ayah:</label>
        <input type="text" name="tempat_tanggal_lahir_ayah" value="<?php echo htmlspecialchars($siswa['tempat_tanggal_lahir_ayah']); ?>" required><br><br>

        <!-- Data Ibu -->
        <h3>Data Ibu</h3>
        <label for="nama_ibu">Nama Ibu:</label>
        <input type="text" name="nama_ibu" value="<?php echo htmlspecialchars($siswa['nama_ibu']); ?>" required><br><br>

        <label for="nik_ibu">NIK Ibu:</label>
        <input type="text" name="nik_ibu" value="<?php echo htmlspecialchars($siswa['nik_ibu']); ?>" required><br><br>

        <label for="pekerjaan_ibu">Pekerjaan Ibu:</label>
        <input type="text" name="pekerjaan_ibu" value="<?php echo htmlspecialchars($siswa['pekerjaan_ibu']); ?>" required><br><br>

        <label for="pendidikan_ibu">Pendidikan Ibu:</label>
        <input type="text" name="pendidikan_ibu" value="<?php echo htmlspecialchars($siswa['pendidikan_ibu']); ?>" required><br><br>

        <label for="no_hp_ibu">No HP Ibu:</label>
        <input type="text" name="no_hp_ibu" value="<?php echo htmlspecialchars($siswa['nomor_hp_ibu']); ?>" required><br><br>

        <label for="tempat_tanggal_lahir_ibu">Tempat Tanggal Lahir Ibu:</label>
        <input type="text" name="tempat_tanggal_lahir_ibu" value="<?php echo htmlspecialchars($siswa['tempat_tanggal_lahir_ibu']); ?>" required><br><br>

        <input type="submit" value="Simpan Perubahan">

        <a href="kelola_siswa.php"><button type="button">Kembali ke Kelola Siswa</button></a>
    </form>
</body>

</html>