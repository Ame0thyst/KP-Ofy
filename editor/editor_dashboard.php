<?php
session_start();

// Validasi apakah user sudah login sebagai editor
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'editor') {
    header("Location: ../login.php");
    exit;
}

include '../includes/header.php';
?>

<div class="container mt-5">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <h1 class="text-center mb-4">Editor Dashboard</h1>
    <div class="row">
        <!-- Section: Manage Articles -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm border-primary">
                <div class="card-body text-center">
                    <h5 class="card-title">Manage Articles</h5>
                    <p class="card-text">Edit and review articles before publishing.</p>
                    <a href="editor_manage_articles.php" class="btn btn-primary btn-sm">View Articles</a>
                </div>
            </div>
        </div>

        <!-- Section: Article Reviews -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm border-success">
                <div class="card-body text-center">
                    <h5 class="card-title">Article Reviews</h5>
                    <p class="card-text">Review articles submitted by authors.</p>
                    <a href="editor_review_articles.php" class="btn btn-success btn-sm">Review Articles</a>
                </div>
            </div>
        </div>

        <!-- Section: Profile -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm border-warning">
                <div class="card-body text-center">
                    <h5 class="card-title">Profile</h5>
                    <p class="card-text">View and edit your profile information.</p>
                    <a href="profile.php" class="btn btn-warning btn-sm">View Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php
include '../includes/footer.php';
?>