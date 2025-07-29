<?php
session_start();
include '../includes/header.php';

// Cek apakah pengguna sudah login dan memiliki peran admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>

<div class="container mt-5">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <h1 class="text-center mb-4">Admin Dashboard</h1>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card shadow-sm border-primary">
                <div class="card-body text-center">
                    <h5 class="card-title">Editors</h5>
                    <p class="card-text">Manage editors in the system.</p>
                    <a href="admin_editors.php" class="btn btn-primary btn-sm">Manage Editors</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card shadow-sm border-success">
                <div class="card-body text-center">
                    <h5 class="card-title">Authors</h5>
                    <p class="card-text">View and manage authors.</p>
                    <a href="admin_authors.php" class="btn btn-success btn-sm">Manage Authors</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card shadow-sm border-warning">
                <div class="card-body text-center">
                    <h5 class="card-title">Categories</h5>
                    <p class="card-text">Create and organize news categories.</p>
                    <a href="admin_categories.php" class="btn btn-warning btn-sm">Manage Categories</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card shadow-sm border-danger">
                <div class="card-body text-center">
                    <h5 class="card-title">Articles</h5>
                    <p class="card-text">View and manage news articles.</p>
                    <a href="admin_articles.php" class="btn btn-danger btn-sm">Manage Articles</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include '../includes/footer.php';
?> 