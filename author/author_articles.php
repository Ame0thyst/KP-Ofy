<?php
session_start();
include '../includes/header.php';
include '../includes/db_connect.php';

// Cek apakah pengguna sudah login dan memiliki peran author
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'author') {
    header("Location: ../login.php");
    exit;
}

// Hapus artikel
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $article_id = $_GET['delete'];
    $query = "DELETE FROM articles WHERE id = ? AND author_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $article_id, $_SESSION['user_id']);
    $stmt->execute();
    header("Location: author_articles.php");
    exit;
}

$notifQuery = $conn->prepare("SELECT COUNT(*) AS notif FROM articles WHERE author_id = ? AND status != 'Pending' AND reviewed_at >= DATE_SUB(NOW(), INTERVAL 1 DAY)");
$notifQuery->bind_param('i', $_SESSION['user_id']);
$notifQuery->execute();
$notifResult = $notifQuery->get_result()->fetch_assoc();
$showNotif = $notifResult['notif'] > 0;
?>

<div class="container mt-5">

    <?php if ($showNotif): ?>
        <div class="alert alert-success">Beberapa artikel Anda telah ditinjau oleh editor. Silakan periksa status dan komentar.</div>
    <?php endif; ?>

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <h1 class="text-center mb-4">Artikel Berita Anda</h1>

    <!-- Notifikasi -->
    <?php if (isset($message)): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <!-- Form Tambah Artikel -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahArtikel">
        Tambah Artikel
    </button>
    <div class="modal fade" id="modalTambahArtikel" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="author_add_article_process.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="add_article" value="1">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Tambah Artikel Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Masukkan judul artikel" required>
                        </div>
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategori</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                <?php
                                // Ambil data kategori dari database
                                $query = "SELECT id, name FROM categories";
                                $result = $conn->query($query);
                                
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                    }
                                } else {
                                    echo "<option value=''>Tidak ada kategori tersedia</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="keywords" class="form-label">Keyword</label>
                            <input type="text" class="form-control" id="keywords" name="keywords" placeholder="Masukkan kata kunci" required>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Body</label>
                            <textarea class="form-control" id="content" name="content" rows="5" placeholder="Masukkan isi content artikel" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="summary" class="form-label">Deskripsi/Summary</label>
                            <textarea class="form-control" id="summary" name="summary" rows="3" placeholder="Masukkan deskripsi artikel" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="source_article" class="form-label">Sumber Artikel</label>
                            <input type="text" class="form-control" id="source_article" name="source_article" placeholder="Masukkan sumber artikel">
                        </div>
                        <div class="mb-3">
                            <label for="source_thumbnail" class="form-label">Sumber Foto Thumbnail</label>
                            <input type="text" class="form-control" id="source_thumbnail" name="source_thumbnail" placeholder="Masukkan sumber foto">
                        </div>
                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">Thumbnail</label>
                            <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*" required>
                            <small class="text-muted">Hanya file JPG, JPEG, PNG, dan GIF. Maksimum ukuran 2MB.</small>
                        </div>
                        <!-- Preview akan ditambahkan dengan JavaScript -->

                        <div class="mb-3">
                            <label for="caption_thumbnail" class="form-label">Caption Thumbnail</label>
                            <input type="text" class="form-control" id="caption_thumbnail" name="caption_thumbnail" placeholder="Masukkan caption thumbnail">
                        </div>
                        <div class="mb-3">
                            <label for="tags" class="form-label">Tag</label>
                            <input type="text" class="form-control" id="tags" name="tags" placeholder="Masukkan minimal 3 tag" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Submit Artikel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel Artikel -->
    <div class="card">
        <div class="card-header bg-success text-white">Daftar Artikel Anda</div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Thumbnail</th>
                        <th>Judul</th>
                        <th>Keyword</th>
                        <th>Kategori</th>
                        <th>Deskripsi/Summary</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT a.*, c.name AS category_name 
                              FROM articles a 
                              JOIN categories c ON a.category_id = c.id 
                              WHERE a.author_id = ? 
                              ORDER BY a.created_at DESC";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('i', $_SESSION['user_id']);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($row = $result->fetch_assoc()):
                    ?>
                        <tr>
                            <td>
                                <?php
                                echo '<img src="../uploads/' . htmlspecialchars($row['thumbnail'] ?? 'default.jpg') . '" 
                                        alt="Thumbnail" 
                                        class="img-thumbnail" 
                                        width="100" 
                                        onerror="this.onerror=null;this.src=\'../uploads/default.jpg\';">';                    
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo htmlspecialchars($row['keywords']); ?></td>
                            <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['summary']); ?></td>
                            <td>
                                <strong><?php echo ucfirst($row['status']); ?></strong><br>
                                <?php if (!empty($row['editor_comment'])): ?>
                                    <small class="text-muted">Komentar Editor: <?= htmlspecialchars($row['editor_comment']) ?></small><br>
                                    <small class="text-muted">Ditinjau: <?= date('d M Y, H:i', strtotime($row['reviewed_at'])) ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="author_view_article.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">Lihat</a>
                                <a href="author_edit_article.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="author_articles.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus artikel ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    <?php if ($result->num_rows === 0): ?>
                        <tr>
                            <td colspan="7" class="text-center">Belum ada artikel yang ditambahkan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const thumbnailInput = document.getElementById("thumbnail");

    if (thumbnailInput) {
        const previewContainer = document.createElement("div");
        previewContainer.id = "previewContainer";
        previewContainer.className = "mt-3";

        const previewImage = document.createElement("img");
        previewImage.id = "previewImage";
        previewImage.style.maxWidth = "200px";
        previewImage.style.height = "auto";
        previewImage.style.border = "1px solid #ddd";
        previewImage.style.display = "none";

        previewContainer.appendChild(previewImage);
        thumbnailInput.parentNode.appendChild(previewContainer);

        thumbnailInput.addEventListener("change", function (event) {
            const file = event.target.files[0];
            if (file && file.type.startsWith("image/")) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = "block";
                };
                reader.readAsDataURL(file);
            } else {
                previewImage.src = "";
                previewImage.style.display = "none";
            }
        });
    }
});
</script>

<?php
include '../includes/footer.php';
?>
