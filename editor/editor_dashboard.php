<?php
session_start();

// Validasi apakah user sudah login sebagai editor
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'editor') {
    header("Location: ../login.php");
    exit;
}

include '../includes/header.php';
?>

<!-- Logout Button -->
<div class="text-end mt-3">
    <a href="../logout.php" class="btn btn-danger btn-sm">Logout</a>
</div>

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
                    <a href="editor_articles.php" class="btn btn-primary btn-sm">View Articles</a>
                </div>
            </div>
        </div>

        <!-- Section: Article Reviews -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm border-success">
                <div class="card-body text-center">
                    <h5 class="card-title">Article Reviews</h5>
                    <p class="card-text">Review articles submitted by authors.</p>
                    <a href="editor_reviews.php" class="btn btn-success btn-sm">Review Articles</a>
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

<?php
include '../includes/footer.php';
?>
