<?php
include '../includes/header.php';
include '../includes/db_connect.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: author_articles.php");
    exit;
}

$article_id = $_GET['id'];
$query = "SELECT a.*, c.name AS category_name, u.name AS author 
          FROM articles a 
          JOIN categories c ON a.category_id = c.id
          JOIN authors u ON a.author_id = u.id
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

<div class="container mt-5 mb-5">
    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <div class="card shadow-lg">
        <img src="../uploads/<?php echo htmlspecialchars($thumbnail_file); ?>" class="card-img-top" alt="Thumbnail">

        <div class="card-body">
            <h2 class="card-title"><?php echo htmlspecialchars($article['title']); ?></h2>

            <div class="mb-3 text-muted">
                <span class="badge bg-secondary"><?php echo htmlspecialchars($article['category_name']); ?></span>
                <span class="ms-2"><i class="bi bi-person"></i> <?php echo htmlspecialchars($article['author']); ?></span>
            </div>

            <p class="card-text">
                <strong>Sumber Artikel:</strong> <?php echo htmlspecialchars($article['source_article']); ?><br>
                <strong>Sumber Foto Thumbnail:</strong> <?php echo htmlspecialchars($article['source_thumbnail']); ?>
            </p>

            <div class="mb-3">
                <strong>Tag:</strong><br>
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

            <hr>

            <div class="article-content" style="line-height: 1.8; font-size: 1.1em;">
                <?php echo nl2br(htmlspecialchars($article['content'])); ?>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
