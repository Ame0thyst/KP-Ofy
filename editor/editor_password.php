<?php
session_start();
include '../includes/header.php';
include '../includes/db_connect.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'editor') {
    header("Location: ../login.php");
    exit;
}

$editor_id = $_SESSION['user_id'];

// Proses ubah password
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Ambil password lama
    $query = $conn->prepare("SELECT password FROM editor_login WHERE id = ?");
    $query->bind_param("i", $editor_id);
    $query->execute();
    $result = $query->get_result();
    $editor = $result->fetch_assoc();

    if (md5($old_password) !== $editor['password']) {
        $message = '<div class="alert alert-danger">Password lama salah!</div>';
    } elseif ($new_password !== $confirm_password) {
        $message = '<div class="alert alert-danger">Konfirmasi password tidak cocok!</div>';
    } else {
        $hashed = md5($new_password);
        $update = $conn->prepare("UPDATE editor_login SET password=? WHERE id=?");
        $update->bind_param("si", $hashed, $editor_id);
        $update->execute();
        $message = '<div class="alert alert-success">Password berhasil diubah!</div>';
    }
}
?>

<div class="container mt-5">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <h2>Ubah Password</h2>
    <?= $message ?>
    <form method="POST">
        <input type="hidden" name="change_password" value="1">
        <div class="mb-3">
            <label>Password Lama</label>
            <input type="password" name="old_password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password Baru</label>
            <input type="password" name="new_password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Ubah Password</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include '../includes/footer.php'; ?>