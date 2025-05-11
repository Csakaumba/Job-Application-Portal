<?php
include '../includes/auth.php';
require_once '../config/db.php';
if ($_SESSION['role'] !== 'employer') { header('Location: ../index.php'); exit(); }
$job_id = isset($_GET['job_id']) ? intval($_GET['job_id']) : 0;
$employer_id = $_SESSION['user_id'];
$stmt = $conn->prepare('DELETE FROM jobs WHERE id = ? AND employer_id = ?');
$stmt->bind_param('ii', $job_id, $employer_id);
$stmt->execute();
$stmt->close();
header('Location: dashboard.php');
exit();
