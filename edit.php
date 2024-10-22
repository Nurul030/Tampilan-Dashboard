<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

include 'config.php';
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM kliniks WHERE id=$id");
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_klinik = $_POST['nama_klinik'];
    $nama_dokter = $_POST['nama_dokter'];
    $waktu = $_POST['waktu'];
    $hari = $_POST['hari'];

    $sql = "UPDATE kliniks SET nama_klinik='$nama_klinik', nama_dokter='$nama_dokter', waktu='$waktu', Hari='$hari' WHERE id=$id";

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
    <title>Edit Klinik</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <form method="post">
            <label>Nama Klinik</label>
            <input type="text" name="nama_klinik" value="<?php echo $row['nama_klinik']; ?>" required><br>
            <label>Nama Dokter</label>
            <input type="text" name="nama_dokter" value="<?php echo $row['nama_dokter']; ?>" required><br>
            <label>Waktu</label>
            <input type="text" name="waktu" value="<?php echo $row['waktu']; ?>" required><br>
            <label>Hari</label>
            <select name="hari" required>
                <option value="Senin" <?php if(isset($row['Hari']) && $row['Hari'] == 'Senin') echo 'selected'; ?>>Senin</option>
                <option value="Selasa" <?php if(isset($row['Hari']) && $row['Hari'] == 'Selasa') echo 'selected'; ?>>Selasa</option>
                <option value="Rabu" <?php if(isset($row['Hari']) && $row['Hari'] == 'Rabu') echo 'selected'; ?>>Rabu</option>
                <option value="Kamis" <?php if(isset($row['Hari']) && $row['Hari'] == 'Kamis') echo 'selected'; ?>>Kamis</option>
                <option value="Jumat" <?php if(isset($row['Hari']) && $row['Hari'] == 'Jumat') echo 'selected'; ?>>Jumat</option>
                <option value="Sabtu" <?php if(isset($row['Hari']) && $row['Hari'] == 'Sabtu') echo 'selected'; ?>>Sabtu</option>
                <option value="Minggu" <?php if(isset($row['Hari']) && $row['Hari'] == 'Minggu') echo 'selected'; ?>>Minggu</option>
            </select><br>
            <button type="submit">Simpan</button>
        </form>
    </div>
</body>
</html>
