<?php
include '../includes/header.php';
include '../includes/auth.php';
if ($_SESSION['role'] !== 'employer') { header('Location: ../index.php'); exit(); }
require_once '../config/db.php';

$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $desc = trim($_POST['description']);
    $location = trim($_POST['location']);
    $employer_id = $_SESSION['user_id'];
    $stmt = $conn->prepare('INSERT INTO jobs (employer_id, title, description, location) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('isss', $employer_id, $title, $desc, $location);
    if ($stmt->execute()) {
        $success = 'Job posted successfully!';
    } else {
        $error = 'Failed to post job.';
    }
    $stmt->close();
}
?>
<div class="container">
    <h2>Post a Job</h2>
    <?php if ($error): ?><div class="alert"><?php echo $error; ?></div><?php endif; ?>
    <?php if ($success): ?><div class="success"><?php echo $success; ?></div><?php endif; ?>
    <form method="post">
        <label>Job Title</label>
        <input type="text" name="title" required>
        <label>Description</label>
        <textarea name="description" required></textarea>
        <label>Location</label>
        <input type="text" name="location">
        <button type="submit">Post Job</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>
