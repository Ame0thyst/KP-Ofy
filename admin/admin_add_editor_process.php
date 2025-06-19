<?php
session_start();
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_editor'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];

    // Cek apakah username/email sudah ada
    $check = $conn->prepare("SELECT id FROM editor_login WHERE username = ? OR email = ?");
    $check->bind_param("ss", $username, $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        die("Username atau email sudah digunakan.");
    }

    // Simpan ke editor_login
    $stmt = $conn->prepare("INSERT INTO editor_login (username, password, name, email, phone) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $password, $name, $email, $phone);

    if ($stmt->execute()) {
        header("Location: admin_editors.php?success=Editor berhasil ditambahkan!");
        exit;
    } else {
        die("Gagal menambahkan data editor.");
    }
} else {
    die("Akses tidak sah.");
}
?>