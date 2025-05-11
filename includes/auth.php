<?php
// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: /job-application-portal/login.php');
    exit();
}
?>
