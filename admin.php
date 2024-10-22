<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

include 'config.php';

// Handle search query
$search_query = '';
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
    $result = $conn->query("SELECT * FROM kliniks WHERE nama_klinik LIKE '%$search_query%'");
} else {
    $result = $conn->query("SELECT * FROM kliniks");
}

// Get all clinic names for autocomplete
$clinic_names = [];
$all_clinics = $conn->query("SELECT DISTINCT nama_klinik FROM kliniks");
while ($row = $all_clinics->fetch_assoc()) {
    $clinic_names[] = $row['nama_klinik'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="header">
        <h1>Admin Panel</h1>
    </div>
    <div class="container">
        <a href="tambah.php">Tambah Klinik</a>
        <form method="get" action="">
            <input type="text" id="search" name="search" placeholder="Cari Nama Klinik" value="<?php echo htmlspecialchars($search_query); ?>">
            <input type="submit" value="Cari">
            <div id="suggestions"></div>
        </form>
        <div class="table-container">
            <table border="1">
                <tr>
                    <th>Nama Klinik</th>
                    <th>Nama Dokter</th>
                    <th>Waktu</th>
                    <th>Hari</th>
                    <th>Aksi</th>
                </tr>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['nama_klinik']; ?></td>
                    <td><?php echo $row['nama_dokter']; ?></td>
                    <td><?php echo $row['waktu']; ?></td>
                    <td><?php echo $row['Hari']; ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                        <a href="hapus.php?id=<?php echo $row['id']; ?>">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>

    <script>
        const clinicNames = <?php echo json_encode($clinic_names); ?>;
        const searchInput = document.getElementById('search');
        const suggestions = document.getElementById('suggestions');

        searchInput.addEventListener('input', function() {
            const input = searchInput.value.toLowerCase();
            suggestions.innerHTML = '';
            if (input.length > 0) {
                const filteredNames = clinicNames.filter(name => name.toLowerCase().includes(input));
                filteredNames.forEach(name => {
                    const div = document.createElement('div');
                    div.textContent = name;
                    div.classList.add('suggestion');
                    div.addEventListener('click', function() {
                        searchInput.value = name;
                        suggestions.innerHTML = '';
                    });
                    suggestions.appendChild(div);
                });
            }
        });

        document.addEventListener('click', function(event) {
            if (!suggestions.contains(event.target) && event.target !== searchInput) {
                suggestions.innerHTML = '';
            }
        });
    </script>
</body>
</html>
