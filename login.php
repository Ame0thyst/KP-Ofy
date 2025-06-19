<?php
session_start();
include 'includes/header.php';
include 'includes/db_connect.php';

$error = "";
$username = "";
$role = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    error_log("POST request received. Username: $username, Role: $role");

    if (empty($username) || empty($password) || empty($role)) {
        $error = "Semua field harus diisi.";
        error_log("Error: $error");
    } else {
        // Determine the table based on role
        $table = "";
        if ($role === 'admin') {
            $table = "admin_login";
        } elseif ($role === 'editor') {
            $table = "editor_login";
        } elseif ($role === 'author') {
            $table = "author_login";
        }

        if ($table) {
            // Query to check user credentials
            $stmt = $conn->prepare("SELECT * FROM $table WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            error_log("Query executed. Number of rows: " . $result->num_rows);

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                // Verify password using password_verify
                if (md5($password) === $user['password']) {
                    error_log("Password verified for user: $username");
                    // Set session variables
                    $_SESSION['user_role'] = $role;
                    $_SESSION['user_id'] = $user['id']; // Simpan ID pengguna untuk identifikasi lebih lanjut
                    $_SESSION['user_name'] = $username;

                    // Redirect based on role
                    if ($role === 'admin') {
                        header("Location: admin/admin_dashboard.php");
                    } elseif ($role === 'editor') {
                        header("Location: editor/editor_dashboard.php");
                    } elseif ($role === 'author') {
                        header("Location: author/author_dashboard.php");
                    }
                    exit();
                } else {
                    $error = "Username atau password salah.";
                    error_log("Error: $error");
                }
            } else {
                $error = "Pengguna tidak ditemukan.";
                error_log("Error: $error");
            }
        } else {
            $error = "Role tidak valid.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Urban Media Redaksi</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white text-center">
                        <h4>Login to Urban Media Redaksi</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($error)) : ?>
                            <div class="alert alert-danger"> <?= $error ?> </div>
                        <?php endif; ?>
                        <form method="POST" action="">
                             <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="editor">Editor</option>
                                    <option value="author">Author</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-dark btn-block">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php 
include 'includes/footer.php'; 
?>
