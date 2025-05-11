<?php
include '../includes/header.php';
include '../includes/auth.php';
if ($_SESSION['role'] !== 'employer') { header('Location: ../index.php'); exit(); }
require_once '../config/db.php';

$job_id = isset($_GET['job_id']) ? intval($_GET['job_id']) : 0;
$stmt = $conn->prepare('SELECT a.*, u.username, u.email, f.filename FROM applications a JOIN users u ON a.seeker_id = u.id LEFT JOIN files f ON f.user_id = u.id WHERE a.job_id = ?');
$stmt->bind_param('i', $job_id);
$stmt->execute();
$applicants = $stmt->get_result();
?>
<div class="container">
    <h2>Applicants for Job #<?php echo $job_id; ?></h2>
    <ul>
    <?php while ($row = $applicants->fetch_assoc()):
        $status = $row['status'] ?? 'pending';
        $status_class = 'status-pending';
        if ($status == 'shortlisted') $status_class = 'status-shortlisted';
        if ($status == 'rejected') $status_class = 'status-rejected';
    ?>
        <li>
            <strong><?php echo htmlspecialchars($row['username']); ?></strong> (<?php echo htmlspecialchars($row['email']); ?>)
            <?php if ($row['filename']): ?>
                | <a href="../assets/uploads/<?php echo urlencode($row['filename']); ?>" target="_blank">View CV</a>
            <?php endif; ?>
            <br>Applied at: <?php echo $row['applied_at']; ?>
            <br>Status: <span class="<?php echo $status_class; ?>"><?php echo ucfirst($status); ?></span>
            <form method="post" action="applicant_status.php" style="display:inline;margin-left:1em;">
                <input type="hidden" name="application_id" value="<?php echo $row['id']; ?>">
                <select name="status">
                    <option value="pending" <?php if($status=='pending') echo 'selected'; ?>>Pending</option>
                    <option value="shortlisted" <?php if($status=='shortlisted') echo 'selected'; ?>>Shortlisted</option>
                    <option value="rejected" <?php if($status=='rejected') echo 'selected'; ?>>Rejected</option>
                </select>
                <button type="submit" class="btn-secondary">Update</button>
            </form>
        </li>
    <?php endwhile; ?>
    </ul>
    <a href="dashboard.php"><button>Back to Dashboard</button></a>
</div>
<?php include '../includes/footer.php'; ?>
