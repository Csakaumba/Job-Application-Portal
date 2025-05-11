<?php
include '../includes/auth.php';
require_once '../config/db.php';
if ($_SESSION['role'] !== 'employer') { header('Location: ../index.php'); exit(); }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['application_id'], $_POST['status'])) {
    $application_id = intval($_POST['application_id']);
    $status = $_POST['status'];
    if (!in_array($status, ['pending', 'shortlisted', 'rejected'])) {
        header('Location: dashboard.php'); exit();
    }
    // Update application status
    $stmt = $conn->prepare('UPDATE applications SET status = ? WHERE id = ?');
    $stmt->bind_param('si', $status, $application_id);
    $stmt->execute();
    $stmt->close();
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
header('Location: dashboard.php');
exit();
