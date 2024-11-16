<?php
require 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data kegiatan berdasarkan ID
    $stmt = $conn->prepare("SELECT * FROM jadwal_kegiatan WHERE id = ?");
    $stmt->execute([$id]);
    $kegiatan = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$kegiatan) {
        echo "Kegiatan tidak ditemukan!";
        exit();
    }
} else {
    header("Location: setting.php");
    exit();
}

// Update data kegiatan
if (isset($_POST['update'])) {
    $judul = $_POST['judul'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];

    $stmt = $conn->prepare("UPDATE jadwal_kegiatan SET judul = ?, tanggal_mulai = ?, tanggal_selesai = ? WHERE id = ?");
    $stmt->execute([$judul, $tanggal_mulai, $tanggal_selesai, $id]);

    header("Location: setting.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="setting.css">
</head>

<body>

    <h2>Edit Jadwal Kegiatan</h2>

    <form method="POST">
        <input type="text" name="judul" value="<?php echo htmlspecialchars($kegiatan['judul']); ?>" required>
        <input type="date" name="tanggal_mulai" value="<?php echo $kegiatan['tanggal_mulai']; ?>" required>
        <input type="date" name="tanggal_selesai" value="<?php echo $kegiatan['tanggal_selesai']; ?>" required>
        <button type="submit" name="update">Update Kegiatan</button>
    </form>

    <a href="setting.php"><button>Kembali ke Setting</button></a>
</body>

</html>