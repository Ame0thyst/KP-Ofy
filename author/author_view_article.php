<?php
include '../includes/header.php';
include '../includes/db_connect.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: author_articles.php");
    exit;
}

$article_id = $_GET['id'];

$query = "SELECT a.*, c.name AS category_name, au.name AS author, ed.name AS editor_name
          FROM articles a
          JOIN categories c ON a.category_id = c.id
          JOIN authors au ON a.author_id = au.id
          LEFT JOIN editors ed ON a.editor_id = ed.id
          WHERE a.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $article_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Artikel tidak ditemukan.";
    exit;
}

$article = $result->fetch_assoc();
$thumbnail_file = !empty($article['thumbnail']) ? $article['thumbnail'] : 'default.jpg';
?>

<link rel="stylesheet" href="../css/bootstrap.min.css">

<div class="container mt-5 mb-5">
    <div class="card shadow-lg">
        <!-- Gambar Thumbnail -->
        <img src="../uploads/<?php echo htmlspecialchars($thumbnail_file); ?>" class="card-img-top" alt="Thumbnail">

        <div class="card-body">
            <!-- Judul dan Kategori -->
            <h2 class="card-title mb-3"><?php echo htmlspecialchars($article['title']); ?></h2>
            <div class="mb-2 text-muted">
                <span class="badge bg-secondary"><?php echo htmlspecialchars($article['category_name']); ?></span>
                <span class="ms-2">Ditulis oleh <strong><?php echo htmlspecialchars($article['author']); ?></strong> pada 
                    <?php echo date('d M Y, H:i', strtotime($article['published_at'])); ?>
                </span>
            </div>

            <!-- Caption Thumbnail dan Sumber -->
            <p class="mt-3">
                <strong>Caption Thumbnail:</strong> <?php echo htmlspecialchars($article['caption_thumbnail']); ?><br>
                <strong>Sumber Thumbnail:</strong> <?php echo htmlspecialchars($article['source_thumbnail']); ?>
            </p>

            <!-- Konten Artikel -->
            <hr>
            <div class="article-content mb-4" style="line-height: 1.8; font-size: 1.1em;">
                <?php echo nl2br(htmlspecialchars($article['content'])); ?>
            </div>

            <!-- Editor yang mempublikasikan (hanya jika Published) -->
            <?php if ($article['status'] === 'Published' && !empty($article['editor_name'])): ?>
                <p><strong>Dipublikasikan oleh:</strong> <?php echo htmlspecialchars($article['editor_name']); ?></p>
            <?php endif; ?>

            <!-- Sumber Artikel -->
            <p class="mt-3"><strong>Sumber Artikel:</strong> <?php echo htmlspecialchars($article['source_article']); ?></p>

            <!-- Tags -->
            <div class="mt-2">
                <strong>Tags:</strong><br>
                <?php
                $tags = explode('#', $article['tags']);
                foreach ($tags as $tag) {
                    $trimmed = trim($tag);
                    if ($trimmed !== '') {
                        echo '<span class="badge bg-info text-dark me-1">#' . htmlspecialchars($trimmed) . '</span>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>