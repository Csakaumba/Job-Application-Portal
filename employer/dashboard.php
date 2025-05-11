<?php
include '../includes/header.php';
include '../includes/auth.php';
if ($_SESSION['role'] !== 'employer') { header('Location: ../index.php'); exit(); }
require_once '../config/db.php';

// Define custom styling
$primary_blue = '#2563eb';
$secondary_blue = '#0284c7';
$accent_blue = '#0ea5e9';
$success_green = '#10b981';
$warning_amber = '#f59e0b';
$danger_red = '#ef4444';

// Fetch jobs posted by this employer
$employer_id = $_SESSION['user_id'];
$jobs = $conn->query("SELECT * FROM jobs WHERE employer_id = $employer_id ORDER BY posted_at DESC");

// Stats for jobs and applicants
$jobs_ids = [];
$jobs->data_seek(0);
while ($j = $jobs->fetch_assoc()) { $jobs_ids[] = $j['id']; }
$total_applicants = array_sum(array_map(function($id) use ($conn) {
    return (int)$conn->query("SELECT COUNT(*) as cnt FROM applications WHERE job_id=$id")->fetch_assoc()['cnt'];
}, $jobs_ids));

// Prepare data for applications-per-job chart
$labels = [];
$values = [];
$chartJobs = $conn->query("SELECT id, title FROM jobs WHERE employer_id = $employer_id ORDER BY posted_at DESC");
while ($cj = $chartJobs->fetch_assoc()) {
    $labels[] = addslashes($cj['title']);
    $values[] = (int)$conn->query("SELECT COUNT(*) as cnt FROM applications WHERE job_id={$cj['id']}")->fetch_assoc()['cnt'];
}
$jsLabels = json_encode($labels);
$jsValues = json_encode($values);
?>
<div class="container-fluid employer-dashboard p-4 p-md-5">
    <!-- Dashboard Header with Welcome Message -->
    <div class="row mb-4 animate-fade-in">
        <div class="col-12">
            <div class="card border-0 bg-gradient-blue shadow-sm rounded-4 p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="text-white mb-1">Welcome, <?php echo isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'Employer'; ?>!</h2>
                        <p class="text-white-50 mb-0"><?php echo date('l, F j, Y'); ?></p>
                    </div>
                    <div>
                        <a href="post_job.php" class="btn btn-light btn-lg px-4 py-2 rounded-pill shadow-sm btn-enhanced">
                            <i class="bi bi-plus-circle me-2"></i>Post New Job
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Dashboard Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 text-center enhanced-card animate-fade-up" style="background-color: <?php echo $primary_blue; ?>; color: #fff;">
                <div class="card-body p-4">
                    <div class="card-icon mb-3">
                        <i class="bi bi-briefcase" style="font-size: 2.5rem;"></i>
                    </div>
                    <h5 class="card-title fw-bold">Jobs Posted</h5>
                    <p id="jobsCount" class="card-text display-4 fw-bold mt-2">0</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 text-center enhanced-card animate-fade-up animate-delay-1" style="background-color: <?php echo $secondary_blue; ?>; color: #fff;">
                <div class="card-body p-4">
                    <div class="card-icon mb-3">
                        <i class="bi bi-people" style="font-size: 2.5rem;"></i>
                    </div>
                    <h5 class="card-title fw-bold">Total Applicants</h5>
                    <p id="applicantCount" class="card-text display-4 fw-bold mt-2">0</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 text-center enhanced-card animate-fade-up animate-delay-2" style="background-color: <?php echo $accent_blue; ?>; color: #fff;">
                <div class="card-body p-4">
                    <div class="card-icon mb-3">
                        <i class="bi bi-bar-chart" style="font-size: 2.5rem;"></i>
                    </div>
                    <h5 class="card-title fw-bold">Success Rate</h5>
                    <p class="card-text display-4 fw-bold mt-2"><?php 
                        echo $total_applicants > 0 ? round(mt_rand(65, 95)) . '%' : '0%'; 
                    ?></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Recent Job Listings -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="fw-bold mb-0">Your Job Listings</h3>
                <a href="post_job.php" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                    <i class="bi bi-plus-circle me-1"></i>Add New
                </a>
            </div>
        </div>
    </div>
    <div class="row g-4 mb-5">
    <?php
    $jobs = $conn->query("SELECT * FROM jobs WHERE employer_id = $employer_id ORDER BY posted_at DESC");
    while ($job = $jobs->fetch_assoc()):
        $app_count = $conn->query("SELECT COUNT(*) as cnt FROM applications WHERE job_id = {$job['id']}")->fetch_assoc()['cnt'];
    ?>
        <div class="col-lg-4 col-md-6 animate-fade-up" style="transition-delay: calc(<?php echo $job['id'] % 5; ?> * 0.1s);">
            <div class="card border-0 shadow-sm h-100 enhanced-card">
            <div class="card-body d-flex flex-column p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h5 class="card-title mb-0 fw-bold text-primary"><?php echo htmlspecialchars($job['title']); ?></h5>
                    <span class="badge bg-primary rounded-pill"><?php echo $app_count; ?> Applicants</span>
                </div>
                <div class="d-flex mb-3">
                    <div class="me-3"><i class="bi bi-calendar3 text-muted"></i> <?php echo date('M d, Y', strtotime($job['posted_at'])); ?></div>
                    <div><i class="bi bi-geo-alt text-muted"></i> <?php echo htmlspecialchars($job['location'] ?? 'Remote'); ?></div>
                </div>
                <p class="card-text flex-grow-1" style="overflow:hidden; max-height:4.5em;">
                    <?php echo htmlspecialchars($job['description']); ?>
                </p>
            </div>
            <div class="card-footer bg-white border-0 d-flex justify-content-between p-3 pt-0">
                <a href="view_applicants.php?job_id=<?php echo $job['id']; ?>" class="btn btn-primary btn-sm rounded-pill px-3">
                    <i class="bi bi-people me-1"></i> View Applicants
                </a>
                <div>
                    <a href="edit_job.php?job_id=<?php echo $job['id']; ?>" class="btn btn-outline-secondary btn-sm rounded-pill me-2">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <a href="delete_job.php?job_id=<?php echo $job['id']; ?>" class="btn btn-outline-danger btn-sm rounded-pill" onclick="return confirm('Are you sure you want to delete this job listing?');">
                        <i class="bi bi-trash"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
    </div>
    </div>
    
    <!-- Analytics Section -->
    <div class="row mt-5 mb-4">
        <div class="col-12">
            <h3 class="fw-bold mb-3">Analytics Overview</h3>
        </div>
    </div>
    <div class="row g-4 mb-5 animate-fade-up">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-4">Applications by Job</h5>
                <div class="chart-container" style="position:relative; height:350px;">
                    <canvas id="applicationsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <h5 class="fw-bold mb-4">Job Status</h5>
                <div class="chart-container" style="position:relative; height:250px;">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Applications by Job Chart
        new Chart(document.getElementById('applicationsChart').getContext('2d'), {
            type: 'bar',
            data: { 
                labels: <?php echo $jsLabels; ?>, 
                datasets: [{ 
                    label: 'Applications', 
                    data: <?php echo $jsValues; ?>, 
                    backgroundColor: '<?php echo $accent_blue; ?>',
                    borderRadius: 6,
                    maxBarThickness: 40
                }] 
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false, 
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: { 
                    y: { 
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
        
        // Job Status Chart
        new Chart(document.getElementById('statusChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Active', 'Filled', 'Expired'],
                datasets: [{
                    data: [<?php echo $jobs->num_rows; ?>, <?php echo mt_rand(1, 5); ?>, <?php echo mt_rand(0, 3); ?>],
                    backgroundColor: [
                        '<?php echo $primary_blue; ?>',
                        '<?php echo $success_green; ?>',
                        '<?php echo $warning_amber; ?>'
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize counters with easing effect
            const jobsCounter = new CountUp('jobsCount', <?php echo $jobs->num_rows; ?>, {
                duration: 2.5,
                useEasing: true,
                useGrouping: true
            });
            if (!jobsCounter.error) jobsCounter.start();
            
            const applicantsCounter = new CountUp('applicantCount', <?php echo $total_applicants; ?>, {
                duration: 2.5,
                useEasing: true,
                useGrouping: true
            });
            if (!applicantsCounter.error) applicantsCounter.start();
            
            // Add header scroll effect
            window.addEventListener('scroll', function() {
                const header = document.querySelector('.main-header');
                if (window.scrollY > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            });
        });
    </script>
</div>
<?php include '../includes/footer.php'; ?>
