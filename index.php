<?php
include 'config.php';

// Ambil hari dari parameter URL atau gunakan hari default
$hari = isset($_GET['hari']) ? $_GET['hari'] : 'Senin'; // Default to 'Senin' if no day is set
$tanggal = date('Y-m-d'); // Mengatur tanggal secara manual

// Pastikan fungsi formatTanggal didefinisikan sebelum digunakan
function formatTanggal($tanggal) {
    $bulanIndo = array(
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    );

    $tanggalArr = explode('-', $tanggal);
    $bulan = $bulanIndo[$tanggalArr[1]];
    $tgl = $tanggalArr[2];
    $tahun = $tanggalArr[0];

    return $tgl . ' ' . $bulan . ' ' . $tahun;
}

// Set $formattedDate setelah $tanggal didefinisikan
$formattedDate = $hari . ', ' . formatTanggal($tanggal);

$result = $conn->query("SELECT * FROM kliniks WHERE Hari='$hari' ORDER BY nama_klinik");

$klinik_data = [];
while ($row = $result->fetch_assoc()) {
    $klinik_data[$row['nama_klinik']][] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Instalasi Rawat Jalan RS Medika Mulia Tuban</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="header">
        <div class="logo-container">
            <img src="logo1.png" alt="Logo 1" class="logo">
            <img src="logo2.png" alt="Logo 2" class="logo logo-large">
            <img src="logo3.png" alt="Logo 3" class="logo">
            <img src="logo4.png" alt="Logo 4" class="logo logo-large">
        </div>
        <h1 class="blue-bold">JADWAL INSTALASI RAWAT JALAN</h1>
        <h1 class="blue-bold">RUMAH SAKIT MEDIKA MULIA TUBAN</h1>
        <h2 class="yellow-bold"><?php echo $formattedDate; ?></h2>
    </div>
    <div class="navigation">
        <a href="index.php?hari=Senin">Senin</a>
        <a href="index.php?hari=Selasa">Selasa</a>
        <a href="index.php?hari=Rabu">Rabu</a>
        <a href="index.php?hari=Kamis">Kamis</a>
        <a href="index.php?hari=Jumat">Jumat</a>
        <a href="index.php?hari=Sabtu">Sabtu</a>
        <a href="index.php?hari=Minggu">Minggu</a>
    </div>
    <div class="container">
        <?php if (!empty($klinik_data)): ?>
            <?php foreach($klinik_data as $nama_klinik => $data): ?>
                <div class="klinik">
                    <h2 class="klinik-nama"><?php echo $nama_klinik; ?></h2>
                    <?php foreach($data as $detail): ?>
                        <div class="jadwal">
                            <div class="dokter"><?php echo $detail['nama_dokter']; ?></div>
                            <div class="waktu"><?php echo $detail['waktu']; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Tidak ada data klinik untuk hari ini.</p>
        <?php endif; ?>
    </div>
    <div class="footer">
        <p class="contact-info blue-shadow-text">Yuk, Daftar Online Sekarang! | Aplikasi Mobile JKN | Pendaftaran Online: 0896-2447-3000 | Customer Service: 0859-6711-7588</p>
        <p class="address blue-shadow-text">Jl. Majapahit No. 699, Sidorejo, Kabupaten Tuban, Jawa Timur 62315</p>
        <p class="website"><a href="https://www.rsmedikamuliaiuban.com" target="_blank" class="blue-shadow-text">www.rsmedikamuliaiuban.com</a></p>
    </div>

    <button onclick="openFullscreen()" style="position:fixed;bottom:10px;right:10px;">Full Screen</button>

    <script>
        function openFullscreen() {
            const elem = document.documentElement;
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.mozRequestFullScreen) { // Firefox
                elem.mozRequestFullScreen();
            } else if (elem.webkitRequestFullscreen) { // Chrome, Safari and Opera
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) { // IE/Edge
                elem.msRequestFullscreen();
            }
        }

        // Automatically request fullscreen on page load
        document.addEventListener("DOMContentLoaded", function() {
            openFullscreen();
        });
    </script>
</body>
</html>
