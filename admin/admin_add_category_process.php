<?php
session_start();
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $name = trim($_POST['name']);
    $icon = null;

    if (isset($_FILES['icon']) && $_FILES['icon']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($_FILES['icon']['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            if ($_FILES['icon']['size'] <= 200 * 1024) {
                $iconName = uniqid('cat_') . '.' . $ext;
                $target = realpath(__DIR__ . '/../uploads') . '/' . $iconName;
                if (move_uploaded_file($_FILES['icon']['tmp_name'], $target)) {
                    $icon = $iconName;
                } else {
                    die("Gagal upload ikon.");
                }
            } else {
                die("Ukuran ikon terlalu besar. Maksimal 200KB.");
            }
        } else {
            die("Format ikon tidak didukung.");
        }
    }

    // Simpan kategori
    $stmt = $conn->prepare("INSERT INTO categories (name, icon) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $icon);

    if ($stmt->execute()) {
        header("Location: admin_categories.php?success=Kategori berhasil ditambahkan!");
        exit;
    } else {
        die("Gagal menambahkan kategori.");
    }
} else {
    die("Akses tidak sah.");
}
?>