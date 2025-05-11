<?php
include '../includes/auth.php';
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['application_id'])) {
    $application_id = intval($_POST['application_id']);
    $seeker_id = $_SESSION['user_id'];
    // Ensure the application belongs to the logged-in user
    $stmt = $conn->prepare('DELETE FROM applications WHERE id = ? AND seeker_id = ?');
    $stmt->bind_param('ii', $application_id, $seeker_id);
    if ($stmt->execute() && $stmt->affected_rows > 0) {
        header('Location: dashboard.php?msg=withdrawn');
        exit();
    } else {
        header('Location: dashboard.php?msg=error');
        exit();
    }
}
header('Location: dashboard.php');
exit();
