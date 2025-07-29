<?php
// db_connect.php - Database Connection File

$host = "localhost";
$user = "root";
$password = "";
$database = "urban_media_redaksi";

// $conn = new mysqli($host, $user, $password, $database);

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {}
?>