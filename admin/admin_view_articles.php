<?php
include '../includes/header.php';
include '../includes/db_connect.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: admin_articles.php");
    exit;
}

$article_id = $_GET['id'];
$query = "SELECT a.*, c.name AS category_name, c.icon AS category_icon, au.name AS author_name, ed.name AS editor_name
          FROM articles a
          JOIN categories c ON a.category_id = c.id
          JOIN authors au ON a.author_id = au.id
          LEFT JOIN editors ed ON a.editor_id = ed.id
          WHERE a.id = ? AND a.status = 'Published'";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $article_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<div class='container mt-5 alert alert-danger'>Artikel tidak ditemukan.</div>";
    exit;
}

$article = $result->fetch_assoc();
?>

<div class="container mt-5 mb-5">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <div class="card shadow-lg">
        <div class="card-body">

            <!-- Kategori -->
            <h6 class="text-muted">
                <img src="../uploads/<?= htmlspecialchars($article['category_icon']) ?>" width="25" height="25">
                <?= htmlspecialchars($article['category_name']) ?>
            </h6>

            <!-- Judul -->
            <h2 class="mt-2"><?= htmlspecialchars($article['title']) ?></h2>

            <!-- Author dan waktu -->
            <div class="text-muted mb-3">
                Ditulis oleh <strong><?= htmlspecialchars($article['author_name']) ?></strong>
                pada <?= date('d M Y H:i', strtotime($article['published_at'])) ?>
            </div>

            <!-- Thumbnail -->
            <img src="../uploads/<?= htmlspecialchars($article['thumbnail']) ?>" class="img-fluid mb-3" alt="Thumbnail">

            <!-- Caption thumbnail -->
            <p class="fst-italic">
                <?= htmlspecialchars($article['caption_thumbnail']) ?>
                (<?= htmlspecialchars($article['source_thumbnail']) ?>)
            </p>

            <!-- Konten Artikel -->
            <div class="content mb-4" style="line-height: 1.8; font-size: 1.1em;">
                <?= nl2br(htmlspecialchars($article['content'])) ?>
            </div>

            <!-- Editor -->
            <p><strong>Dipublikasikan oleh:</strong> <?= htmlspecialchars($article['editor_name']) ?></p>

            <!-- Sumber artikel -->
            <p><strong>Sumber Artikel:</strong> <?= htmlspecialchars($article['source_article']) ?></p>

            <!-- Tags -->
            <p><strong>Tags:</strong><br>
                <?php
                $tags = explode('#', $article['tags']);
                foreach ($tags as $tag) {
                    $trimmed = trim($tag);
                    if ($trimmed !== '') {
                        echo '<span class="badge bg-info text-dark me-1">#' . htmlspecialchars($trimmed) . '</span>';
                    }
                }
                ?>
            </p>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include '../includes/footer.php'; ?>