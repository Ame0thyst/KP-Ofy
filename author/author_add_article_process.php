<?php
include '../includes/db_connect.php';
session_start();

// Cek apakah form sudah dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_article'])) {
    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $keywords = $_POST['keywords'];
    $content = $_POST['content'];
    $summary = $_POST['summary'];
    $source_article = $_POST['source_article'];
    $source_thumbnail = $_POST['source_thumbnail'];
    $caption_thumbnail = $_POST['caption_thumbnail'];
    $tags = $_POST['tags'];
    $author_id = $_SESSION['user_id'];

    // Validasi category_id
    $category_check_query = "SELECT id FROM categories WHERE id = ?";
    $category_stmt = $conn->prepare($category_check_query);
    $category_stmt->bind_param('i', $category_id);
    $category_stmt->execute();
    $category_result = $category_stmt->get_result();

    if ($category_result->num_rows === 0) {
        die("Kategori tidak valid. Pilih kategori yang sesuai.");
    }

    // Proses file upload untuk thumbnail
    $thumbnail = null;
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === 0) {
        $upload_dir = realpath(__DIR__ . '/../uploads/') . '/';
        $file_name = basename($_FILES['thumbnail']['name']);
        $file_tmp = $_FILES['thumbnail']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($file_ext, $allowed_extensions)) {
            die("Format file tidak didukung.");
        }

        $max_file_size = 2 * 1024 * 1024;
        if ($_FILES['thumbnail']['size'] > $max_file_size) {
            die("Ukuran file terlalu besar.");
        }

        $new_file_name = uniqid() . '.' . $file_ext;
        $destination = $upload_dir . $new_file_name;

        if (!move_uploaded_file($file_tmp, $destination)) {
            die("Gagal mengunggah file.");
        }

        $thumbnail = $new_file_name; // hanya nama file
    }

    // Query untuk menambah artikel
    $query = "INSERT INTO articles (title, category_id, keywords, content, caption_thumbnail, summary, source_article, source_thumbnail, thumbnail, tags, author_id, status) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sissssssssi', $title, $category_id, $keywords, $content, $caption_thumbnail, $summary, $source_article, $source_thumbnail, $thumbnail, $tags, $author_id);

    if ($stmt->execute()) {
        header("Location: author_articles.php?success=Artikel berhasil ditambahkan!");
        exit;
    } else {
        header("Location: author_articles.php?error=Gagal menambahkan artikel.");
        exit;
    }
}
?>
