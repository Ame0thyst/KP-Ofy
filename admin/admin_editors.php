<?php
session_start();
include '../includes/header.php';
include '../includes/db_connect.php';

// Cek jika admin belum login
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Hapus editor
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $editor_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM editor_login WHERE id = ?");
    $stmt->bind_param("i", $editor_id);
    $stmt->execute();
    header("Location: admin_editors.php?success=Editor berhasil dihapus!");
    exit;
}

// Ambil data editors
$result = $conn->query("SELECT * FROM editor_login ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Editor - Admin</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Manajemen Data Editor</h1>

    <!-- Notifikasi -->
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>

    <!-- Tombol Modal -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahEditor">Tambah Editor</button>

    <!-- Modal Form Tambah Editor -->
    <div class="modal fade" id="modalTambahEditor" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="admin_add_editor_process.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Editor Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>No. HP</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="add_editor" class="btn btn-success">Tambah Editor</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel Editor -->
    <div class="card">
        <div class="card-header bg-dark text-white">Daftar Editor</div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td>
                            <a href="admin_editors.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus editor ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php if ($result->num_rows === 0): ?>
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data editor.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include '../includes/footer.php'; ?>