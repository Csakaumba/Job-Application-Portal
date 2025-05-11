<?php
include 'includes/header.php';
require_once 'config/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare('SELECT id, password, role FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $hash, $role);
        $stmt->fetch();
        if (password_verify($password, $hash)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['role'] = $role;
            if ($role === 'employer') {
                header('Location: employer/dashboard.php');
            } else {
                header('Location: jobseeker/dashboard.php');
            }
            exit();
        } else {
            $error = 'Invalid credentials.';
        }
    } else {
        $error = 'Invalid credentials.';
    }
    $stmt->close();
}
?>
<div class="container d-flex align-items-center justify-content-center min-vh-75 py-5">
    <div class="card shadow-lg rounded-3 p-4 mx-auto bg-white bg-opacity-90" style="max-width:450px; width:100%;">
        <div class="text-center mb-4">
            <div class="d-inline-block rounded-circle bg-primary text-white p-3 mb-3">
                <i class="bi bi-person-fill" style="font-size: 2rem;"></i>
            </div>
            <h2 class="fw-bold text-primary mb-2">Login</h2>
            <p class="text-muted">Enter your credentials to access your account</p>
        </div>
        
        <?php if ($error): ?>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div><?php echo $error; ?></div>
            </div>
        <?php endif; ?>
        
        <form method="post">
            <div class="mb-3">
                <label for="email" class="form-label fw-medium">Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                    <input type="email" id="email" name="email" class="form-control" placeholder="name@example.com" required>
                </div>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label fw-medium">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2 fw-medium rounded-pill shadow-sm">Sign In</button>
        </form>
        <div class="mt-4 text-center">
            <p class="mb-0">Don't have an account? <a href="register.php" class="text-primary fw-medium">Register</a></p>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
