<?php
session_start();
include '../includes/header.php';
include '../includes/db_connect.php';

// Cek login admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Proses hapus kategori
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $category_id = $_GET['delete'];

    $icon_query = $conn->prepare("SELECT icon FROM categories WHERE id = ?");
    $icon_query->bind_param('i', $category_id);
    $icon_query->execute();
    $icon_result = $icon_query->get_result()->fetch_assoc();

    if (!empty($icon_result['icon']) && file_exists('../uploads/' . $icon_result['icon'])) {
        unlink('../uploads/' . $icon_result['icon']);
    }

    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();

    header("Location: admin_categories.php?success=Kategori berhasil dihapus!");
    exit;
}

// Cek apakah sedang edit
$edit_data = null;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $edit_data = $stmt->get_result()->fetch_assoc();
}

// Ambil semua kategori
$result = $conn->query("SELECT * FROM categories ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Kategori</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Manajemen Kategori</h2>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>

    <!-- Tombol Tambah/Edit Kategori -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalKategori">
        <?= $edit_data ? 'Edit Kategori' : 'Tambah Kategori' ?>
    </button>

    <!-- Modal Form Tambah/Edit -->
    <div class="modal fade <?= $edit_data ? 'show' : '' ?>" id="modalKategori" tabindex="-1" aria-labelledby="modalLabel" <?= $edit_data ? 'style="display:block;"' : '' ?> aria-hidden="<?= $edit_data ? 'false' : 'true' ?>">
        <div class="modal-dialog">
            <form action="<?= $edit_data ? 'admin_edit_category_process.php' : 'admin_add_category_process.php' ?>" method="POST" enctype="multipart/form-data" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel"><?= $edit_data ? 'Edit Kategori' : 'Tambah Kategori Baru' ?></h5>
                    <a href="admin_categories.php" class="btn-close"></a>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $edit_data['id'] ?? '' ?>">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Kategori</label>
                        <input type="text" name="name" class="form-control" required value="<?= $edit_data['name'] ?? '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="icon" class="form-label">Ikon</label>
                        <?php if (!empty($edit_data['icon'])): ?>
                            <div>
                                <img src="../uploads/<?= htmlspecialchars($edit_data['icon']) ?>" width="40" class="img-thumbnail mb-1">
                            </div>
                        <?php endif; ?>
                        <input type="file" name="icon" class="form-control" accept="image/*">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah ikon.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="<?= $edit_data ? 'edit_category' : 'add_category' ?>" class="btn btn-success">
                        <?= $edit_data ? 'Simpan Perubahan' : 'Tambah Kategori' ?>
                    </button>
                    <a href="admin_categories.php" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Kategori -->
    <div class="card">
        <div class="card-header bg-success text-white">Daftar Kategori</div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Ikon</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?php if ($row['icon']): ?>
                                <img src="../uploads/<?= htmlspecialchars($row['icon']) ?>" width="40" height="40" class="img-thumbnail" alt="Icon">
                            <?php else: ?>
                                <span class="text-muted">Tidak ada</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td>
                            <a href="admin_categories.php?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="admin_categories.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus kategori ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                <?php if ($result->num_rows === 0): ?>
                    <tr>
                        <td colspan="3" class="text-center">Belum ada kategori</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php if ($edit_data): ?>
<script>
// Auto show modal saat edit
var myModal = new bootstrap.Modal(document.getElementById('modalKategori'));
myModal.show();
</script>
<?php endif; ?>
</body>
</html>

<?php include '../includes/footer.php'; ?>