<?php
// Database connection settings
$host = 'localhost';
$db   = 'job_application_portal';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}
?>
