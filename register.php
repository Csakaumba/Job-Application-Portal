<?php
include 'includes/header.php';
require_once 'config/db.php';

$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];
    if (!in_array($role, ['jobseeker', 'employer'])) {
        $error = 'Invalid role selected.';
    } else {
        $stmt = $conn->prepare('SELECT id FROM users WHERE email = ? OR username = ?');
        $stmt->bind_param('ss', $email, $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = 'Email or username already exists.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt2 = $conn->prepare('INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)');
            $stmt2->bind_param('ssss', $username, $email, $hash, $role);
            if ($stmt2->execute()) {
                $success = 'Registration successful! You can now <a href="login.php">login</a>.';
            } else {
                $error = 'Registration failed. Please try again.';
            }
            $stmt2->close();
        }
        $stmt->close();
    }
}
?>
<div class="container d-flex align-items-center justify-content-center min-vh-75 py-5">
    <div class="card shadow-lg rounded-3 p-4 mx-auto bg-white bg-opacity-90" style="max-width:500px; width:100%;">
        <div class="text-center mb-4">
            <div class="d-inline-block rounded-circle bg-primary text-white p-3 mb-3">
                <i class="bi bi-person-plus-fill" style="font-size: 2rem;"></i>
            </div>
            <h2 class="fw-bold text-primary mb-2">Create Account</h2>
            <p class="text-muted">Join Job Application Portal and start your journey</p>
        </div>
        
        <?php if ($error): ?>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div><?php echo $error; ?></div>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div><?php echo $success; ?></div>
            </div>
        <?php endif; ?>
        
        <form method="post">
            <div class="mb-3">
                <label for="username" class="form-label fw-medium">Username</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Choose a username" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label fw-medium">Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                    <input type="email" id="email" name="email" class="form-control" placeholder="name@example.com" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label fw-medium">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Create a strong password" required>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="role" class="form-label fw-medium">Role</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-briefcase"></i></span>
                    <select id="role" name="role" class="form-select" required>
                        <option value="" disabled selected>Select your role</option>
                        <option value="jobseeker">Job Seeker</option>
                        <option value="employer">Employer</option>
                    </select>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary w-100 py-2 fw-medium rounded-pill shadow-sm">Register</button>
        </form>
        
        <div class="mt-4 text-center">
            <p class="mb-0">Already have an account? <a href="login.php" class="text-primary fw-medium">Sign In</a></p>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
