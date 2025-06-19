<?php
session_start();
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_category'])) {
    $id   = $_POST['id'];
    $name = trim($_POST['name']);
    $icon = null;

    // Ambil icon lama
    $stmt = $conn->prepare("SELECT icon FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $old = $stmt->get_result()->fetch_assoc();
    $old_icon = $old['icon'];

    // Proses upload jika ada file baru
    if (isset($_FILES['icon']) && $_FILES['icon']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($_FILES['icon']['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            if ($_FILES['icon']['size'] <= 200 * 1024) {
                $new_icon = uniqid('cat_') . '.' . $ext;
                $target = realpath(__DIR__ . '/../uploads') . '/' . $new_icon;

                if (move_uploaded_file($_FILES['icon']['tmp_name'], $target)) {
                    $icon = $new_icon;

                    // Hapus icon lama jika ada
                    if (!empty($old_icon) && file_exists("../uploads/" . $old_icon)) {
                        unlink("../uploads/" . $old_icon);
                    }
                } else {
                    die("Gagal mengunggah ikon.");
                }
            } else {
                die("Ukuran file terlalu besar.");
            }
        } else {
            die("Format file tidak didukung.");
        }
    } else {
        $icon = $old_icon; // Gunakan icon lama jika tidak diubah
    }

    // Update kategori
    $stmt = $conn->prepare("UPDATE categories SET name = ?, icon = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $icon, $id);

    if ($stmt->execute()) {
        header("Location: admin_categories.php?success=Kategori berhasil diperbarui!");
        exit;
    } else {
        die("Gagal memperbarui kategori.");
    }
} else {
    die("Akses tidak sah.");
}
?>