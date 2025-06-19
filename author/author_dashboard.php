<?php
session_start();
include '../includes/header.php';

// Cek apakah pengguna sudah login dan memiliki peran author
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'author') {
    header("Location: ../login.php");
    exit;
}
?>

<!-- Logout Button -->
<div class="text-end mt-3">
    <a href="../logout.php" class="btn btn-danger btn-sm">Logout</a>
</div>

<main class="flex-fill">
<div class="container mt-5">
<link rel="stylesheet" href="../css/bootstrap.min.css">
    <h1 class="text-center mb-4">Author Dashboard</h1>
    <div class="row">
        <div class="col-md-6 col-lg-6 mb-4">
            <div class="card shadow-sm border-primary">
                <div class="card-body text-center">
                    <h5 class="card-title">Profile</h5>
                    <p class="card-text">View and update your profile information.</p>
                    <a href="author_profile.php" class="btn btn-primary btn-sm">View Profile</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 mb-4">
            <div class="card shadow-sm border-success">
                <div class="card-body text-center">
                    <h5 class="card-title">Tabel Artikel Berita</h5>
                    <p class="card-text">View and manage your articles.</p>
                    <a href="author_articles.php" class="btn btn-success btn-sm">View Articles</a>
                </div>
            </div>
        </div>
    </div>
</div>
</main>

<?php
include '../includes/footer.php';
?>
