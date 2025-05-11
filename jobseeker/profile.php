<?php
include '../includes/header.php';
include '../includes/auth.php';
if ($_SESSION['role'] !== 'jobseeker') { header('Location: ../index.php'); exit(); }
require_once '../config/db.php';

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';

// Handle CV upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['cv'])) {
    $cv = $_FILES['cv'];
    $ext = strtolower(pathinfo($cv['name'], PATHINFO_EXTENSION));
    if ($cv['error'] === 0 && in_array($ext, ['pdf', 'doc', 'docx'])) {
        $filename = 'cv_' . $user_id . '_' . time() . '.' . $ext;
        $target = '../assets/uploads/' . $filename;
        if (move_uploaded_file($cv['tmp_name'], $target)) {
            // Save file info
            $stmt = $conn->prepare('INSERT INTO files (user_id, filename) VALUES (?, ?)');
            $stmt->bind_param('is', $user_id, $filename);
            $stmt->execute();
            $stmt->close();
            $success = 'CV uploaded successfully!';
        } else {
            $error = 'Failed to upload CV.';
        }
    } else {
        $error = 'Invalid file type or upload error.';
    }
}
// Get latest CV
$stmt = $conn->prepare('SELECT filename FROM files WHERE user_id = ? ORDER BY uploaded_at DESC LIMIT 1');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($cv_file);
$stmt->fetch();
$stmt->close();
?>
<div class="container">
    <h2>Your Profile & CV</h2>
    <?php if ($error): ?><div class="alert"><?php echo $error; ?></div><?php endif; ?>
    <?php if ($success): ?><div class="success"><?php echo $success; ?></div><?php endif; ?>
    <form method="post" enctype="multipart/form-data">
        <label>Upload/Update CV (PDF/DOC/DOCX)</label>
        <input type="file" name="cv" accept=".pdf,.doc,.docx" required>
        <button type="submit">Upload</button>
    </form>
    <?php if (!empty($cv_file)): ?>
        <p>Current CV: <a href="../assets/uploads/<?php echo urlencode($cv_file); ?>" target="_blank">View CV</a></p>
    <?php endif; ?>
    <a href="dashboard.php"><button>Back to Dashboard</button></a>
</div>
<?php include '../includes/footer.php'; ?>
