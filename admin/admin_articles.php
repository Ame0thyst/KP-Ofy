<?php
session_start();
include '../includes/header.php';
include '../includes/db_connect.php';

// Cek login admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Ambil semua artikel yang sudah Published
$query = "SELECT a.*, c.name AS category_name, au.name AS author_name, ed.name AS editor_name
          FROM articles a
          JOIN categories c ON a.category_id = c.id
          JOIN authors au ON a.author_id = au.id
          LEFT JOIN editors ed ON a.editor_id = ed.id
          WHERE a.status = 'Published'
          ORDER BY a.published_at DESC";
$result = $conn->query($query);
?>

<div class="container mt-5">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <h2 class="mb-4">Daftar Artikel yang Telah Dipublikasikan</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Kategori</th>
                <th>Keyword</th>
                <th>Author</th>
                <th>Editor</th>
                <th>Waktu Published</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['summary']) ?></td>
                <td><?= htmlspecialchars($row['category_name']) ?></td>
                <td><?= htmlspecialchars($row['keywords']) ?></td>
                <td><?= htmlspecialchars($row['author_name']) ?> (<?= $row['author_id'] ?>)</td>
                <td><?= htmlspecialchars($row['editor_name']) ?></td>
                <td><?= date('d M Y H:i', strtotime($row['published_at'])) ?></td>
                <td>
                    <a href="admin_view_articles.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">Lihat</a>
                </td>
            </tr>
        <?php endwhile; ?>
        <?php if ($result->num_rows === 0): ?>
            <tr><td colspan="8" class="text-center">Belum ada artikel yang dipublikasikan.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include '../includes/footer.php'; ?>