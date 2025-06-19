<?php
include '../includes/header.php';
include '../includes/db_connect.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: author_articles.php");
    exit;
}

$article_id = $_GET['id'];
$query = "SELECT * FROM articles WHERE id = ? AND author_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $article_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<div class='alert alert-danger'>Artikel tidak ditemukan atau Anda tidak memiliki akses.</div>";
    exit;
}

$article = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $keywords = $_POST['keywords'];
    $content = $_POST['content'];
    $summary = $_POST['summary'];
    $source_article = $_POST['source_article'];
    $source_thumbnail = $_POST['source_thumbnail'];
    $caption_thumbnail = $_POST['caption_thumbnail'];
    $tags = $_POST['tags'];

    $thumbnail = $article['thumbnail']; // default: tetap gunakan thumbnail lama

    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === 0) {
        $upload_dir = realpath(__DIR__ . '/../uploads/') . '/';
        $file_name = basename($_FILES['thumbnail']['name']);
        $file_tmp = $_FILES['thumbnail']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($file_ext, $allowed_extensions)) {
            echo "<div class='alert alert-danger'>Format file tidak didukung.</div>";
            exit;
        }

        if ($_FILES['thumbnail']['size'] > 2 * 1024 * 1024) {
            echo "<div class='alert alert-danger'>Ukuran file maksimal 2MB.</div>";
            exit;
        }

        // Hapus file thumbnail lama jika ada
        if (!empty($article['thumbnail'])) {
            $old_path = $upload_dir . basename($article['thumbnail']);
            if (file_exists($old_path)) {
                unlink($old_path);
            }
        }

        $new_file_name = uniqid() . '.' . $file_ext;
        $thumbnail_path = $upload_dir . $new_file_name;

        if (move_uploaded_file($file_tmp, $thumbnail_path)) {
            $thumbnail = $new_file_name; // hanya simpan nama file-nya
        } else {
            echo "<div class='alert alert-danger'>Gagal mengunggah thumbnail baru.</div>";
            exit;
        }
    }

    $update_query = "UPDATE articles 
                     SET title = ?, category_id = ?, keywords = ?, content = ?, caption_thumbnail = ?, summary = ?, source_article = ?, source_thumbnail = ?, thumbnail = ?, tags = ? 
                     WHERE id = ? AND author_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param(
        'sissssssssii',
        $title,
        $category_id,
        $keywords,
        $content,
        $caption_thumbnail,
        $summary,
        $source_article,
        $source_thumbnail,
        $thumbnail,
        $tags,
        $article_id,
        $_SESSION['user_id']
    );

    if ($update_stmt->execute()) {
        header("Location: author_articles.php?success=Artikel berhasil diperbarui!");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Gagal memperbarui artikel.</div>";
    }
}
?>

<div class="container my-5">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Edit Artikel</h3>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($article['title']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Kategori</label>
                    <select class="form-control" id="category_id" name="category_id" required>
                        <option value="">Pilih Kategori</option>
                        <?php
                        $query = "SELECT id, name FROM categories";
                        $result = $conn->query($query);
                        while ($row = $result->fetch_assoc()) {
                            $selected = ($article['category_id'] == $row['id']) ? 'selected' : '';
                            echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="keywords" class="form-label">Keyword</label>
                    <input type="text" class="form-control" id="keywords" name="keywords" value="<?php echo htmlspecialchars($article['keywords']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Konten</label>
                    <textarea class="form-control" id="content" name="content" rows="5" required><?php echo htmlspecialchars($article['content']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="summary" class="form-label">Deskripsi/Summary</label>
                    <textarea class="form-control" id="summary" name="summary" rows="3" required><?php echo htmlspecialchars($article['summary']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="source_article" class="form-label">Sumber Artikel</label>
                    <input type="text" class="form-control" id="source_article" name="source_article" value="<?php echo htmlspecialchars($article['source_article']); ?>">
                </div>

                <div class="mb-3">
                    <label for="source_thumbnail" class="form-label">Sumber Foto Thumbnail</label>
                    <input type="text" class="form-control" id="source_thumbnail" name="source_thumbnail" value="<?php echo htmlspecialchars($article['source_thumbnail']); ?>">
                </div>

                <div class="mb-3">
                    <label for="thumbnail" class="form-label">Thumbnail</label>
                    <?php
                    $thumbnail_file = htmlspecialchars($article['thumbnail'] ?? 'default.jpg');
                    ?>
                    <div class="mb-2">
                        <p class="mb-1">Thumbnail Saat Ini:</p>
                        <img src="../uploads/<?php echo $thumbnail_file; ?>" 
                             alt="Thumbnail" 
                             style="max-width: 200px; height: auto; border: 1px solid #ddd;" 
                             onerror="this.onerror=null;this.src='../uploads/default.jpg';">
                    </div>
                    <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                    <div id="previewContainer" class="mt-2">
                        <img id="previewImage" style="max-width: 200px; height: auto; border: 1px solid #ddd; display: none;">
                    </div>
                    <small class="text-muted">Hanya file JPG, JPEG, PNG, dan GIF. Maksimum ukuran 2MB.</small>
                </div>

                <div class="mb-3">
                    <label for="caption_thumbnail" class="form-label">Caption Thumbnail</label>
                    <input type="text" class="form-control" id="caption_thumbnail" name="caption_thumbnail" value="<?php echo htmlspecialchars($article['caption_thumbnail']); ?>">
                </div>

                <div class="mb-3">
                    <label for="tags" class="form-label">Tag</label>
                    <input type="text" class="form-control" id="tags" name="tags" value="<?php echo htmlspecialchars($article['tags']); ?>" required>
                </div>

                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
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

<?php include '../includes/footer.php'; ?>
