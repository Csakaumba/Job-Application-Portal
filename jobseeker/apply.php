<?php
include '../includes/header.php';
include '../includes/auth.php';
if ($_SESSION['role'] !== 'jobseeker') { header('Location: ../index.php'); exit(); }
require_once '../config/db.php';

$seeker_id = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['job_id'])) {
    $job_id = intval($_POST['job_id']);
    // Get latest CV file
    $stmt = $conn->prepare('SELECT filename FROM files WHERE user_id = ? ORDER BY uploaded_at DESC LIMIT 1');
    $stmt->bind_param('i', $seeker_id);
    $stmt->execute();
    $stmt->bind_result($cv_file);
    $stmt->fetch();
    $stmt->close();
    if (!$cv_file) {
        echo '<div class="alert">Please upload your CV before applying.</div>';
        echo '<a href="profile.php"><button>Go to Profile</button></a>';
        include '../includes/footer.php';
        exit();
    }
    // Prevent duplicate applications
    $stmt = $conn->prepare('SELECT id FROM applications WHERE job_id = ? AND seeker_id = ?');
    $stmt->bind_param('ii', $job_id, $seeker_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->close();
        echo '<div class="alert">You have already applied for this job.</div>';
        echo '<a href="dashboard.php"><button>Back to Dashboard</button></a>';
        include '../includes/footer.php';
        exit();
    }
    $stmt->close();
    // Insert application
    $stmt = $conn->prepare('INSERT INTO applications (job_id, seeker_id, cv_file) VALUES (?, ?, ?)');
    $stmt->bind_param('iis', $job_id, $seeker_id, $cv_file);
    if ($stmt->execute()) {
        echo '<div class="success">Application submitted successfully!</div>';
    } else {
        echo '<div class="alert">Failed to apply.</div>';
    }
    $stmt->close();
    echo '<a href="dashboard.php"><button>Back to Dashboard</button></a>';
    include '../includes/footer.php';
    exit();
} else {
    header('Location: dashboard.php');
    exit();
}
?>


