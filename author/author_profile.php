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

// Proses update profil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Upload foto jika ada
    if (!empty($_FILES['avatar']['name'])) {
        $avatar_name = time() . '_' . $_FILES['avatar']['name'];
        $avatar_tmp = $_FILES['avatar']['tmp_name'];
        move_uploaded_file($avatar_tmp, '../uploads/' . $avatar_name);

        $stmt = $conn->prepare("UPDATE authors SET name=?, email=?, phone=?, avatar=? WHERE id=?");
        $stmt->bind_param("ssssi", $name, $email, $phone, $avatar_name, $author_id);
    } else {
        $stmt = $conn->prepare("UPDATE authors SET name=?, email=?, phone=? WHERE id=?");
        $stmt->bind_param("sssi", $name, $email, $phone, $author_id);
    }

    if ($stmt->execute()) {
        $success_msg = "Profil berhasil diperbarui.";
    } else {
        $error_msg = "Terjadi kesalahan saat memperbarui profil.";
    }
}

// Ambil data author
$stmt = $conn->prepare("SELECT * FROM authors WHERE id=?");
$stmt->bind_param("i", $author_id);
$stmt->execute();
$author = $stmt->get_result()->fetch_assoc();
?>

<div class="container mt-5">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <h3>Ubah Profil</h3>

    <?php if ($success_msg): ?>
        <div class="alert alert-success"><?= $success_msg ?></div>
    <?php elseif ($error_msg): ?>
        <div class="alert alert-danger"><?= $error_msg ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Foto Profil</label><br>
            <?php if (!empty($author['avatar'])): ?>
                <img src="../uploads/<?= $author['avatar'] ?>" width="100" class="rounded-circle">
            <?php else: ?>
                <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" width="100" class="rounded-circle">
            <?php endif; ?>
            <input type="file" name="avatar" class="form-control mt-2">
        </div>

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($author['name']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($author['email']) ?>" required>
        </div>

        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($author['phone']) ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include '../includes/footer.php'; ?>