<?php
include 'includes/header.php';
?>

<div class="jumbotron text-center bg-primary text-white">
    <div class="container">
        <h1 class="display-4">Welcome to Urban Media Redaksi</h1>
        <p class="lead">A robust platform for managing news articles with ease and efficiency.</p>
        <?php if (!isset($_SESSION['user_role'])): ?>
            <a href="login.php" class="btn btn-light btn-lg">Login</a>
        <?php endif; ?>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <img src="images/admin_dashboard.jpg" class="card-img-top" alt="Admin Dashboard">
                <div class="card-body">
                    <h5 class="card-title">Admin Panel</h5>
                    <p class="card-text">Manage editors, authors, categories, and articles from a centralized dashboard.</p>
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <a href="admin/admin_dashboard.php" class="btn btn-primary">Go to Dashboard</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <img src="images/editor_tools.jpg" class="card-img-top" alt="Editor Tools">
                <div class="card-body">
                    <h5 class="card-title">Editor Tools</h5>
                    <p class="card-text">Edit, review, and manage articles for publication efficiently.</p>
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'editor'): ?>
                        <a href="editor/editor_dashboard.php" class="btn btn-primary">Access Tools</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <img src="images/author_portal.jpg" class="card-img-top" alt="Author Portal">
                <div class="card-body">
                    <h5 class="card-title">Author Portal</h5>
                    <p class="card-text">Create and submit news articles directly for editorial review.</p>
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'author'): ?>
                        <a href="author/author_articles.php" class="btn btn-primary">Open Portal</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
?>
