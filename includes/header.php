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
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                            <?php
                            include_once 'db_connect.php';
                            $editor_id = $_SESSION['user_id'];
                            $result = $conn->query("SELECT avatar FROM editors WHERE id = $editor_id");
                            $editor = $result->fetch_assoc();
                            $avatar = $editor['avatar'] ? '../uploads/' . $editor['avatar'] : 'https://cdn-icons-png.flaticon.com/512/149/149071.png';
                            ?>
                            <li class="nav-item dropdown ms-auto">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="editorDropdown"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="<?= $avatar ?>" class="rounded-circle me-1" width="32" height="32"
                                        style="object-fit: cover;">
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="editorDropdown">
                                    <li><a class="dropdown-item" href="editor_profile.php">Ubah Profile</a></li>
                                    <li><a class="dropdown-item" href="editor_password.php">Ubah Password</a></li>
                                </ul>
                            </li>
                        <?php elseif ($_SESSION['user_role'] === 'author'): ?>
                            <?php
                            include_once 'db_connect.php';
                            $author_id = $_SESSION['user_id'];
                            $result = $conn->query("SELECT avatar FROM authors WHERE id = $author_id");
                            $author = $result->fetch_assoc();
                            $avatar = $author['avatar'] ? '../uploads/' . $author['avatar'] : 'https://cdn-icons-png.flaticon.com/512/149/149071.png';
                            ?>
                            <li class="nav-item dropdown ms-auto">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="authorDropdown"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="<?= $avatar ?>" class="rounded-circle me-1" width="32" height="32"
                                        style="object-fit: cover;">
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="authorDropdown">
                                    <li><a class="dropdown-item" href="../author/author_profile.php">Ubah Profil</a></li>
                                    <li><a class="dropdown-item" href="../author/author_change_password.php">Ubah Password</a>
                                    </li>

                                </ul>
                            </li>
                        <?php endif; ?>
                        <a href="../logout.php" class="btn btn-outline-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z">
                                </path>
                                <path fill-rule="evenodd"
                                    d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z">
                                </path>
                            </svg>
                            Logout
                        </a>
                        <!-- <li class="nav-item"><a class="btn btn-danger btn-sm" href="../logout.php">Logout</a></li> -->
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