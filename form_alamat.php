<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

$nik = $_GET['nik'];

// Koneksi ke database
require 'config.php';

if (isset($_POST['simpan_address'])) {
    $alamat = $_POST['address'];

    // Simpan alamat ke database
    $stmt = $conn->prepare("UPDATE pendaftaran SET alamat = ? WHERE nik = ?");
    if ($stmt->execute([$alamat, $nik])) {
        echo "Alamat berhasil disimpan!";
        header("Location: hasil_pendaftaran.php?nik=$nik");
        exit();
    } else {
        echo "Terjadi kesalahan saat menyimpan alamat.";
    }
}

$alamat = isset($_POST['address']) ? $_POST['address'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Pendaftaran</title>
    <link rel="stylesheet" href="form_alamat.css">
</head>

<body>

    <header style="background-color: #004d00; color: white; padding: 20px; text-align: center;">
        <h3>Halaman Pendaftaran</h3>
    </header>

    <div style="background-color: #ccffcc; padding: 20px; max-width: 600px; margin: 20px auto; border-radius: 10px; text-align: center;">
        <form method="POST">
            <label for="address" class="label-alamat">Alamat</label><br>
            <input type="text" name="address" placeholder="Masukkan Alamat" value="<?php echo htmlspecialchars($alamat); ?>" required style="width: 100%; padding: 10px; margin-top: 10px; border-radius: 5px; border: 1px solid #ccc;"><br><br>

            <?php if (isset($_POST["cari_address"]) && !empty($alamat)): ?>
                <div style="border: 1px solid #ddd; margin-bottom: 10px;">
                    <iframe width="100%" height="300" src="https://maps.google.com/maps?q=<?php echo urlencode($alamat); ?>&output=embed"></iframe>
                </div>
            <?php endif; ?>

            <button type="submit" name="cari_address" class="full-width-btn">Cari</button>
            <button type="submit" name="simpan_address" class="full-width-btn">Selanjutnya</button>
        </form>
    </div>

</body>

</html>