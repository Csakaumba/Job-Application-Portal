<?php
include '../includes/header.php';
include '../includes/auth.php';
require_once '../config/db.php';
$job_id = isset($_GET['job_id']) ? intval($_GET['job_id']) : 0;
$stmt = $conn->prepare('SELECT jobs.*, users.username AS employer FROM jobs JOIN users ON jobs.employer_id = users.id WHERE jobs.id = ?');
$stmt->bind_param('i', $job_id);
$stmt->execute();
$job = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$job) { echo '<div class="alert">Job not found.</div>'; include '../includes/footer.php'; exit(); }
?>
<div class="container">
    <h2><?php echo htmlspecialchars($job['title']); ?></h2>
    <div class="job-meta">at <?php echo htmlspecialchars($job['employer']); ?> | <?php echo htmlspecialchars($job['location']); ?> | Posted: <?php echo $job['posted_at']; ?></div>
    <div class="job-desc" style="margin:1em 0;"> <?php echo nl2br(htmlspecialchars($job['description'])); ?> </div>
    <form method="post" action="apply.php">
        <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
        <button type="submit">Apply for this Job</button>
    </form>
    <a href="dashboard.php"><button type="button">Back to Dashboard</button></a>
</div>
<?php include '../includes/footer.php'; ?>
