<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

include 'config.php';
$id = $_GET['id'];
$sql = "DELETE FROM kliniks WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header('Location: admin.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
