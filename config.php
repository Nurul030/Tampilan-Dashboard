<?php
$servername = "localhost";
$username = "root";  // sesuaikan dengan username database Anda
$password = "";  // sesuaikan dengan password database Anda
$dbname = "rs_medika";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function verifyLogin($username, $password, $conn) {
    $username = $conn->real_escape_string($username);
    $password = md5($password);  // assuming passwords are stored as MD5 hashes

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}
?>
