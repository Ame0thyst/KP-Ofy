<?php
session_start();
include '../includes/header.php';
include '../includes/db_connect.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'author') {
    header("Location: ../login.php");
    exit;
}

$author_id = $_SESSION['user_id'];
$success_msg = $error_msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = md5($_POST['current_password']);
    $new = md5($_POST['new_password']);
    $confirm = md5($_POST['confirm_password']);

    // Ambil password lama dari tabel author_login
    $stmt = $conn->prepare("SELECT password FROM author_login WHERE id = ?");
    $stmt->bind_param("i", $author_id);
    $stmt->execute();
    $stmt->bind_result($stored_password);
    $stmt->fetch();
    $stmt->close();

    if ($current !== $stored_password) {
        $error_msg = "Password lama salah.";
    } elseif ($new !== $confirm) {
        $error_msg = "Konfirmasi password tidak sesuai.";
    } else {
        // Update password dengan MD5
        $update = $conn->prepare("UPDATE author_login SET password = ? WHERE id = ?");
        $update->bind_param("si", $new, $author_id);
        if ($update->execute()) {
            $success_msg = "Password berhasil diubah.";
        } else {
            $error_msg = "Gagal mengubah password.";
        }
    }
}
?>

<div class="container mt-5">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <h3>Ubah Password</h3>

    <?php if ($success_msg): ?>
        <div class="alert alert-success"><?= $success_msg ?></div>
    <?php elseif ($error_msg): ?>
        <div class="alert alert-danger"><?= $error_msg ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Password Lama</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password Baru</label>
            <input type="password" name="new_password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include '../includes/footer.php'; ?>