<?php
include '../includes/header.php';
include '../includes/auth.php';
if ($_SESSION['role'] !== 'employer') { header('Location: ../index.php'); exit(); }
require_once '../config/db.php';

$job_id = isset($_GET['job_id']) ? intval($_GET['job_id']) : 0;
$employer_id = $_SESSION['user_id'];
$error = '';
$success = '';

// Fetch job info
$stmt = $conn->prepare('SELECT * FROM jobs WHERE id = ? AND employer_id = ?');
$stmt->bind_param('ii', $job_id, $employer_id);
$stmt->execute();
$job = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$job) { header('Location: dashboard.php'); exit(); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $desc = trim($_POST['description']);
    $location = trim($_POST['location']);
    $stmt = $conn->prepare('UPDATE jobs SET title = ?, description = ?, location = ? WHERE id = ? AND employer_id = ?');
    $stmt->bind_param('sssii', $title, $desc, $location, $job_id, $employer_id);
    if ($stmt->execute()) {
        $success = 'Job updated successfully!';
    } else {
        $error = 'Update failed.';
    }
    $stmt->close();
}
?>
<div class="container">
    <h2>Edit Job</h2>
    <?php if ($error): ?><div class="alert"><?php echo $error; ?></div><?php endif; ?>
    <?php if ($success): ?><div class="success"><?php echo $success; ?></div><?php endif; ?>
    <form method="post">
        <label>Job Title</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($job['title']); ?>" required>
        <label>Description</label>
        <textarea name="description" required><?php echo htmlspecialchars($job['description']); ?></textarea>
        <label>Location</label>
        <input type="text" name="location" value="<?php echo htmlspecialchars($job['location']); ?>">
        <button type="submit">Save Changes</button>
    </form>
    <a href="dashboard.php"><button type="button">Back to Dashboard</button></a>
</div>
<?php include '../includes/footer.php'; ?>
