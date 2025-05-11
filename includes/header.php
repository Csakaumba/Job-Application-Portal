<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application Portal</title>
    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- JavaScript Libraries -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {},
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.0.7/countUp.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <!-- Custom CSS (override Bootstrap) -->
    <link rel="stylesheet" href="/job-application-portal/assets/css/style.css">
    <link rel="stylesheet" href="/job-application-portal/assets/css/animations.css">
</head>
<body class="custom-body-bg">
<header class="main-header">
    <div class="header-content">
        <div class="logo-tagline">
            <span class="logo-circle">JAP</span>
            <div>
                <span class="site-title">Job Application Portal</span>
                <span class="site-tagline">Your Path to Professional Success</span>
            </div>
        </div>
        <nav>
            <a href="/job-application-portal/index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Home</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/job-application-portal/logout.php">Logout</a>
            <?php else: ?>
                <a href="/job-application-portal/login.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'login.php' ? 'active' : ''; ?>">Login</a>
                <a href="/job-application-portal/register.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'register.php' ? 'active' : ''; ?>">Register</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main>
