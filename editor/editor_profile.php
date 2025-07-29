<?php
session_start();
include '../includes/header.php';
include '../includes/db_connect.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'editor') {
    header("Location: ../login.php");
    exit;
}

$editor_id = $_SESSION['user_id'];

// Ambil data editor dari database
$query = $conn->prepare("SELECT * FROM editors WHERE id = ?");
$query->bind_param("i", $editor_id);
$query->execute();
$result = $query->get_result();
$editor = $result->fetch_assoc();

// Handle update profil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Upload avatar jika ada
    if (!empty($_FILES['avatar']['name'])) {
        $avatar = basename($_FILES['avatar']['name']);
        $target_path = "../uploads/" . $avatar;
        move_uploaded_file($_FILES['avatar']['tmp_name'], $target_path);
    } else {
        $avatar = $editor['avatar'];
    }

    $stmt = $conn->prepare("UPDATE editors SET name=?, email=?, phone=?, avatar=? WHERE id=?");
    $stmt->bind_param("ssssi", $name, $email, $phone, $avatar, $editor_id);
    $stmt->execute();

    header("Location: editor_profile.php?success=Profil berhasil diperbarui!");
    exit;
}
?>

<div class="container mt-5">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <h2>Ubah Profil Editor</h2>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= $_GET['success'] ?></div>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="update_profile" value="1">
        <div class="mb-3">
            <label>Foto Profil</label><br>
            <?php if (!empty($editor['avatar'])): ?>
                <img src="../uploads/<?= $editor['avatar'] ?>" width="100" class="rounded-circle mb-2">
            <?php else: ?>
                <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" width="100" class="rounded-circle mb-2">
            <?php endif; ?>
            <input type="file" name="avatar" class="form-control mt-2">
        </div>
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="<?= $editor['name'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= $editor['email'] ?>" required>
        </div>
        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="phone" class="form-control" value="<?= $editor['phone'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include '../includes/footer.php'; ?>