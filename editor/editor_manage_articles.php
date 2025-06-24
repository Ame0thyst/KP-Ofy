<?php
session_start();
include '../includes/header.php';
include '../includes/db_connect.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'editor') {
    header("Location: ../login.php");
    exit;
}

$editor_id = $_SESSION['user_id'];

// Proses update status artikel
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_article'])) {
    $article_id = $_POST['article_id'];
    $status = $_POST['status'];
    $now = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("UPDATE articles SET title=?, category_id=?, keywords=?, summary=?, content=?, source_article=?, source_thumbnail=?, caption_thumbnail=?, tags=?, status=?, reviewed_at=?, editor_id=? WHERE id=?");
    $stmt->bind_param(
        'sisssssssssii',
        $_POST['title'],
        $_POST['category_id'],
        $_POST['keywords'],
        $_POST['summary'],
        $_POST['content'],
        $_POST['source_article'],
        $_POST['source_thumbnail'],
        $_POST['caption_thumbnail'],
        $_POST['tags'],
        $status,
        $now,
        $editor_id,
        $article_id
    );
    $stmt->execute();

    if ($status === 'Published') {
        $conn->query("UPDATE editors SET articles_uploaded = articles_uploaded + 1 WHERE id = $editor_id");
        $conn->query("UPDATE authors a JOIN articles ar ON a.id = ar.author_id SET a.articles_published = a.articles_published + 1 WHERE ar.id = $article_id");
    }

    header("Location: editor_manage_articles.php?success=Artikel berhasil diperbarui dan status diubah!");
    exit;
}

// Ambil data artikel
$stmt = $conn->prepare("
    SELECT a.*, c.name AS category_name, au.name AS author_name, ed.name AS editor_name 
    FROM articles a
    JOIN categories c ON a.category_id = c.id
    JOIN authors au ON a.author_id = au.id
    LEFT JOIN editors ed ON a.editor_id = ed.id
    WHERE a.status != 'Published' OR a.editor_id = ?
    ORDER BY a.created_at DESC
");
$stmt->bind_param('i', $editor_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mt-5">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <h2 class="mb-4">Manage Articles</h2>

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
                    <td><?= $row['created_at'] ?></td>
                    <td>
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalView<?= $row['id'] ?>">Lihat</button>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id'] ?>">Edit</button>
                    </td>
                </tr>
        </tbody>
    </table>

    <!-- Modal Lihat -->
    <div class="modal fade" id="modalView<?= $row['id'] ?>" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Lihat Artikel: <?= htmlspecialchars($row['title']) ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Penulis:</strong> <?= $row['author_name'] ?></p>
                    <p><strong>Kategori:</strong> <?= $row['category_name'] ?></p>
                    <p><strong>Thumbnail:</strong><br><img src="../uploads/<?= $row['thumbnail'] ?>" width="200" class="img-thumbnail"></p>
                    <p><strong>Caption:</strong> <?= $row['caption_thumbnail'] ?></p>
                    <p><strong>Sumber Gambar:</strong> <?= $row['source_thumbnail'] ?></p>
                    <p><strong>Deskripsi:</strong> <?= nl2br($row['summary']) ?></p>
                    <p><strong>Kata Kunci:</strong> <?= $row['keywords'] ?></p>
                    <p><strong>Isi Artikel:</strong> <?= nl2br($row['content']) ?></p>
                    <p><strong>Sumber Artikel:</strong> <?= $row['source_article'] ?></p>
                    <p><strong>Tags:</strong> <?= $row['tags'] ?></p>
                    <?php if ($row['status'] === 'Published'): ?>
                        <p><strong>Dipublish oleh:</strong> <?= $row['editor_name'] ?></p>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Artikel -->
    <div class="modal fade" id="modalEdit<?= $row['id'] ?>" tabindex="-1" aria-labelledby="modalEditLabel<?= $row['id'] ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" class="modal-content">
                <input type="hidden" name="article_id" value="<?= $row['id'] ?>">
                <input type="hidden" name="update_article" value="1">
                <input type="hidden" id="statusField<?= $row['id'] ?>" name="status">

                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="modalEditLabel<?= $row['id'] ?>">Edit Artikel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-2">
                        <label>Judul</label>
                        <input type="text" class="form-control" name="title" value="<?= htmlspecialchars($row['title']) ?>" required>
                    </div>

                    <div class="mb-2">
                        <label>Kategori</label>
                        <select name="category_id" class="form-control" required>
                            <?php
                            $catResult = $conn->query("SELECT * FROM categories");
                            while ($cat = $catResult->fetch_assoc()):
                            ?>
                                <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $row['category_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['name']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label>Caption Thumbnail</label>
                        <input type="text" class="form-control" name="caption_thumbnail" value="<?= htmlspecialchars($row['caption_thumbnail']) ?>">
                    </div>

                    <div class="mb-2">
                        <label>Sumber Thumbnail</label>
                        <input type="text" class="form-control" name="source_thumbnail" value="<?= htmlspecialchars($row['source_thumbnail']) ?>">
                    </div>

                    <div class="mb-2">
                        <label>Deskripsi</label>
                        <textarea class="form-control" name="summary"><?= htmlspecialchars($row['summary']) ?></textarea>
                    </div>

                    <div class="mb-2">
                        <label>Kata Kunci</label>
                        <input type="text" class="form-control" name="keywords" value="<?= htmlspecialchars($row['keywords']) ?>">
                    </div>

                    <div class="mb-2">
                        <label>Isi Artikel</label>
                        <textarea class="form-control" name="content" rows="5"><?= htmlspecialchars($row['content']) ?></textarea>
                    </div>

                    <div class="mb-2">
                        <label>Sumber Artikel</label>
                        <input type="text" class="form-control" name="source_article" value="<?= htmlspecialchars($row['source_article']) ?>">
                    </div>

                    <div class="mb-2">
                        <label>Tags</label>
                        <input type="text" class="form-control" name="tags" value="<?= htmlspecialchars($row['tags']) ?>">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" onclick="document.getElementById('statusField<?= $row['id'] ?>').value='Published'" class="btn btn-success">Publish</button>
                    <button type="submit" onclick="document.getElementById('statusField<?= $row['id'] ?>').value='Rejected'" class="btn btn-danger">Reject</button>
                    <button type="submit" onclick="document.getElementById('statusField<?= $row['id'] ?>').value='Revised'" class="btn btn-warning">Revised</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
<?php endwhile; ?>
<?php if ($result->num_rows === 0): ?>
    <tr>
        <td colspan="6" class="text-center">Belum ada artikel</td>
    </tr>
<?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include '../includes/footer.php'; ?>