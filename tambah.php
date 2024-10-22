<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_klinik = $_POST['nama_klinik'];
    $nama_dokter = $_POST['nama_dokter'];
    $waktu = $_POST['waktu'];
    $hari = $_POST['hari'];

    $sql = "INSERT INTO kliniks (nama_klinik, nama_dokter, waktu, Hari) VALUES ('$nama_klinik', '$nama_dokter', '$waktu', '$hari')";

    if ($conn->query($sql) === TRUE) {
        header('Location: admin.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Klinik</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <form method="post">
            <label>Nama Klinik</label>
            <input type="text" name="nama_klinik" required><br>
            <label>Nama Dokter</label>
            <input type="text" name="nama_dokter" required><br>
            <label>Waktu</label>
            <input type="text" name="waktu" required><br>
            <label>Hari</label>
            <select name="hari" required>
                <option value="Senin">Senin</option>
                <option value="Selasa">Selasa</option>
                <option value="Rabu">Rabu</option>
                <option value="Kamis">Kamis</option>
                <option value="Jumat">Jumat</option>
                <option value="Sabtu">Sabtu</option>
                <option value="Minggu">Minggu</option>
            </select><br>
            <button type="submit">Simpan</button>
        </form>
    </div>
</body>
</html>
