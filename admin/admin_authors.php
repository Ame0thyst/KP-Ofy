<?php
session_start();
include '../includes/header.php';
include '../includes/db_connect.php';

// Cek jika admin belum login
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Hapus author
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $author_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM author_login WHERE id = ?");
    $stmt->bind_param("i", $author_id);
    $stmt->execute();
    header("Location: admin_authors.php?success=Author berhasil dihapus!");
    exit;
}

// Ambil data authors
$result = $conn->query("SELECT * FROM author_login ORDER BY id DESC");
?>

<link rel="stylesheet" href="../css/bootstrap.min.css">
<div class="container mt-5">
    <h1 class="text-center mb-4">Manajemen Data Author</h1>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_GET['success']) ?>  
        </div>
    <?php endif; ?>

    <!-- Tombol Tambah Author -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahAuthor">
        Tambah Author
    </button>

    <!-- Modal Form Tambah Author -->
    <div class="modal fade" id="modalTambahAuthor" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="admin_add_author_process.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahLabel">Tambah Author Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">X</button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Nomor Handphone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success" name="add_author">Simpan Author</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Author -->
    <div class="card">
        <div class="card-header bg-success text-white">Daftar Author</div>
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
                            <a href="admin_authors.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                               onclick="return confirm('Yakin ingin menghapus author ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php if ($result->num_rows === 0): ?>
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data author.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include '../includes/footer.php'; ?>