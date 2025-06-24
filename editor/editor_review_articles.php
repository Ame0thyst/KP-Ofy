<?php
session_start();
include '../includes/header.php';
include '../includes/db_connect.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'editor') {
    header("Location: ../login.php");
    exit;
}

// Simpan komentar editor
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review_article'])) {
    $article_id = $_POST['article_id'];
    $editor_comment = $_POST['editor_comment'];
    $reviewed_at = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("UPDATE articles SET editor_comment = ?, reviewed_at = ? WHERE id = ?");
    $stmt->bind_param('ssi', $editor_comment, $reviewed_at, $article_id);
    $stmt->execute();

    header("Location: editor_review_articles.php?success=Komentar berhasil disimpan");
    exit;
}

// Ambil artikel yang statusnya 'Pending'
$query = "SELECT a.*, c.name AS category_name, au.name AS author_name 
          FROM articles a 
          JOIN categories c ON a.category_id = c.id 
          JOIN authors au ON a.author_id = au.id 
          WHERE a.status = 'Pending' 
          ORDER BY a.created_at DESC";
$result = $conn->query($query);
?>

<div class="container mt-5">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <h2 class="text-center mb-4">Review Artikel oleh Editor</h2>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-hover">
        <thead class="table-success">
            <tr>
                <th>Judul</th>
                <th>Author</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Waktu Submit</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['author_name']) ?></td>
                    <td><?= htmlspecialchars($row['category_name']) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                    <td>
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalView<?= $row['id'] ?>">Lihat</button>
                    </td>
                </tr>

                <!-- Modal Lihat Artikel -->
                <div class="modal fade" id="modalView<?= $row['id'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <form method="POST">
                                <input type="hidden" name="article_id" value="<?= $row['id'] ?>">
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title">Review Artikel: <?= htmlspecialchars($row['title']) ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal">X</button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3 text-center">
                                        <img src="../uploads/<?= htmlspecialchars($row['thumbnail']) ?>" class="img-thumbnail" style="max-width: 250px;" onerror="this.onerror=null;this.src='../uploads/default.jpg';">
                                        <div class="mt-2">
                                            <small><strong>Caption:</strong> <?= htmlspecialchars($row['caption_thumbnail']) ?></small><br>
                                            <small><strong>Sumber Foto:</strong> <?= htmlspecialchars($row['source_thumbnail']) ?></small>
                                        </div>
                                    </div>

                                    <p><strong>Deskripsi:</strong><br><?= nl2br(htmlspecialchars($row['summary'])) ?></p>
                                    <p><strong>Kata Kunci:</strong> <?= htmlspecialchars($row['keywords']) ?></p>
                                    <p><strong>Isi Artikel:</strong><br><?= nl2br(htmlspecialchars($row['content'])) ?></p>
                                    <p><strong>Sumber Artikel:</strong> <?= htmlspecialchars($row['source_article']) ?></p>
                                    <p><strong>Tag:</strong> <?= htmlspecialchars($row['tags']) ?></p>

                                    <hr>
                                    <div class="mb-3">
                                        <label for="editor_comment" class="form-label">Komentar untuk Penulis:</label>
                                        <textarea class="form-control" name="editor_comment" rows="4" required><?= htmlspecialchars($row['editor_comment'] ?? '') ?></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="review_article" class="btn btn-primary">Simpan Komentar</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>

            <?php if ($result->num_rows === 0): ?>
                <tr>
                    <td colspan="6" class="text-center">Tidak ada artikel dengan status <strong>Pending</strong>.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include '../includes/footer.php'; ?>