<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urban Media Redaksi</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="../index.php">Urban Media Redaksi</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <?php if (isset($_SESSION['user_role'])): ?>
                    <?php if ($_SESSION['user_role'] === 'admin'): ?>
                        <li class="nav-item"><a class="nav-link" href="admin_editors.php">Editors</a></li>
                        <li class="nav-item"><a class="nav-link" href="admin_authors.php">Authors</a></li>
                        <li class="nav-item"><a class="nav-link" href="admin_categories.php">Categories</a></li>
                        <li class="nav-item"><a class="nav-link" href="admin_articles.php">Articles</a></li>
                    <?php elseif ($_SESSION['user_role'] === 'editor'): ?>
                        <li class="nav-item"><a class="nav-link" href="editor_profile.php">Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="editor_articles.php">Articles</a></li>
                    <?php elseif ($_SESSION['user_role'] === 'author'): ?>
                        <li class="nav-item"><a class="nav-link" href="author_profile.php">Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="author_articles.php">Articles</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="btn btn-danger btn-sm" href="../logout.php">Logout</a></li>
                    <!-- <li class="nav-item" ><a class="nav-link" href="../logout.php">Logout</a></li> -->
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<main class="flex-fill">
    <div class="container mt-4">
