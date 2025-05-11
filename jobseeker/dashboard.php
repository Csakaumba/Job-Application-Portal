<?php
include '../includes/header.php';
include '../includes/auth.php';
if ($_SESSION['role'] !== 'jobseeker') { header('Location: ../index.php'); exit(); }
require_once '../config/db.php';

// Fetch available jobs
$jobs = $conn->query("SELECT jobs.*, users.username AS employer FROM jobs JOIN users ON jobs.employer_id = users.id ORDER BY posted_at DESC");
// Fetch user's applications
$seeker_id = $_SESSION['user_id'];
$applications = $conn->query("SELECT a.*, j.title FROM applications a JOIN jobs j ON a.job_id = j.id WHERE a.seeker_id = $seeker_id ORDER BY a.applied_at DESC");
// Stats for application statuses
$stats = ['pending'=>0,'shortlisted'=>0,'rejected'=>0];
$apps_stats = $conn->query("SELECT status FROM applications WHERE seeker_id = $seeker_id");
while ($row = $apps_stats->fetch_assoc()) {
    $st = $row['status'] ?? 'pending';
    if (!array_key_exists($st, $stats)) $st = 'pending';
    $stats[$st]++;
}
?>
<div class="container jobseeker-dashboard shadow-lg rounded-4 bg-white">
    <h1 class="text-center mb-4 mt-3 fade-in">Job Seeker Dashboard</h1>
    <div class="row row-cols-1 row-cols-md-4 g-4 mb-4 dashboard-stats">
        <div class="col fade-in-up" style="animation-delay: 0.1s">
            <div class="card text-white bg-primary h-100 stat-card rounded-4 shadow">
                <div class="card-body text-center">
                    <i class="bi bi-briefcase-fill mb-3" style="font-size: 2rem;"></i>
                    <h5 class="card-title fw-bold">Jobs Available</h5>
                    <p class="card-text display-4" id="jobsCounter"><?php echo $jobs->num_rows; ?></p>
                </div>
            </div>
        </div>
        <div class="col fade-in-up" style="animation-delay: 0.2s">
            <div class="card text-white bg-success h-100 stat-card rounded-4 shadow">
                <div class="card-body text-center">
                    <i class="bi bi-file-earmark-text-fill mb-3" style="font-size: 2rem;"></i>
                    <h5 class="card-title fw-bold">Your Applications</h5>
                    <p class="card-text display-4" id="applicationsCounter"><?php echo $applications->num_rows; ?></p>
                </div>
            </div>
        </div>
        <div class="col fade-in-up" style="animation-delay: 0.3s">
            <div class="card text-white bg-info h-100 stat-card rounded-4 shadow">
                <div class="card-body text-center">
                    <i class="bi bi-person-badge-fill mb-3" style="font-size: 2rem;"></i>
                    <h5 class="card-title fw-bold">Profile & CV</h5>
                    <a href="profile.php" class="btn btn-light btn-lg mt-2 fw-bold">View <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col fade-in-up" style="animation-delay: 0.4s">
            <div class="card h-100 stat-card rounded-4 shadow">
                <div class="card-body text-center">
                    <i class="bi bi-pie-chart-fill mb-3 text-primary" style="font-size: 2rem;"></i>
                    <h5 class="card-title fw-bold">Application Status</h5>
                    <div class="chart-container" style="position:relative; height:150px;">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Chart.js initialization
        const statusData = {
            labels: ['Pending', 'Shortlisted', 'Rejected'],
            datasets: [{ 
                data: [<?php echo $stats['pending']; ?>, <?php echo $stats['shortlisted']; ?>, <?php echo $stats['rejected']; ?>], 
                backgroundColor: ['#ffc107', '#17a2b8', '#dc3545'],
                borderWidth: 0
            }]
        };
        
        new Chart(document.getElementById('statusChart').getContext('2d'), { 
            type: 'doughnut', 
            data: statusData, 
            options: { 
                responsive: true, 
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: {
                                size: 12
                            }
                        }
                    }
                },
                cutout: '65%',
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            } 
        });
        
        // Initialize counter animations
        document.addEventListener('DOMContentLoaded', function() {
            const jobsCounter = new CountUp('jobsCounter', 0, <?php echo $jobs->num_rows; ?>, 0, 2.5, {useEasing: true});
            const applicationsCounter = new CountUp('applicationsCounter', 0, <?php echo $applications->num_rows; ?>, 0, 2.5, {useEasing: true});
            jobsCounter.start();
            applicationsCounter.start();
            
            // Initialize AOS
            AOS.init({
                duration: 800,
                once: true
            });
        });
    </script>
    
    <div class="search-filter bg-white rounded-4 shadow-sm p-4 mb-4 fade-in-up" style="animation-delay: 0.5s">
        <form method="get">
            <div class="row g-3 align-items-center">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text bg-primary text-white"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control form-control-lg" name="search" placeholder="Search jobs by title, location, or employer..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-lg w-100" type="submit">Search</button>
                </div>
            </div>
        </form>
    </div>
    
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in-up" style="animation-delay: 0.6s">
        <h3 class="mb-0"><i class="bi bi-briefcase me-2"></i>Available Jobs</h3>
        <div class="dropdown">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-sort-down me-1"></i> Sort by
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="sortDropdown">
                <li><a class="dropdown-item" href="?sort=newest">Newest First</a></li>
                <li><a class="dropdown-item" href="?sort=oldest">Oldest First</a></li>
            </ul>
        </div>
    </div>
    
    <div class="job-list">
    <?php
    // Filter jobs if search is set
    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
    
    $jobs_query = "SELECT jobs.*, users.username AS employer FROM jobs JOIN users ON jobs.employer_id = users.id";
    if ($search) {
        $jobs_query .= " WHERE jobs.title LIKE '%$search%' OR jobs.location LIKE '%$search%' OR users.username LIKE '%$search%'";
    }
    
    // Add sorting logic
    if ($sort == 'oldest') {
        $jobs_query .= " ORDER BY posted_at ASC";
    } else {
        $jobs_query .= " ORDER BY posted_at DESC";
    }
    
    $jobs = $conn->query($jobs_query);
    $count = 0;
    while ($job = $jobs->fetch_assoc()): 
        $count++;
        $delay = 0.1 * $count;
    ?>
        <div class="col fade-in-up" style="animation-delay: <?php echo $delay; ?>s" data-aos="fade-up" data-aos-delay="<?php echo $delay * 100; ?>">
            <div class="card h-100 shadow-sm job-card-modern rounded-3 border-0">
                <div class="card-body d-flex flex-column p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge bg-primary-subtle text-primary rounded-pill fw-normal px-3 py-2">
                            <i class="bi bi-building me-1"></i><?php echo htmlspecialchars($job['employer']); ?>
                        </span>
                        <span class="badge bg-light text-secondary rounded-pill fw-normal px-3 py-2">
                            <i class="bi bi-geo-alt me-1"></i><?php echo htmlspecialchars($job['location']); ?>
                        </span>
                    </div>
                    <h5 class="card-title fw-bold mb-3"><?php echo htmlspecialchars($job['title']); ?></h5>
                    <p class="card-text flex-grow-1 mb-4" style="overflow:hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                        <?php echo htmlspecialchars($job['description']); ?>
                    </p>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <span class="text-muted small">
                            <i class="bi bi-clock me-1"></i> Posted <?php echo date('M d', strtotime($job['posted_at'])); ?>
                        </span>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 d-flex justify-content-between p-4 pt-0">
                    <form method="post" action="apply.php" class="m-0">
                        <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold">
                            <i class="bi bi-send me-1"></i> Apply
                        </button>
                    </form>
                    <a href="job_detail.php?job_id=<?php echo $job['id']; ?>" class="btn btn-outline-secondary px-4 py-2">
                        <i class="bi bi-info-circle me-1"></i> Details
                    </a>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
    </div>
    <div class="d-flex justify-content-between align-items-center my-5 fade-in-up" style="animation-delay: 0.7s">
        <h3 class="mb-0"><i class="bi bi-file-earmark-check me-2"></i>Your Applications</h3>
        <div class="dropdown">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="appFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-funnel me-1"></i> Filter by
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="appFilterDropdown">
                <li><a class="dropdown-item" href="?filter=all">All Applications</a></li>
                <li><a class="dropdown-item" href="?filter=pending">Pending</a></li>
                <li><a class="dropdown-item" href="?filter=shortlisted">Shortlisted</a></li>
                <li><a class="dropdown-item" href="?filter=rejected">Rejected</a></li>
            </ul>
        </div>
    </div>
    
    <?php
    // Show messages for withdraw with animation
    if (isset($_GET['msg'])) {
        if ($_GET['msg'] === 'withdrawn') {
            echo '<div class="alert alert-success slide-in-right shadow-sm"><i class="bi bi-check-circle me-2"></i>Application withdrawn successfully.</div>';
        } elseif ($_GET['msg'] === 'error') {
            echo '<div class="alert alert-danger slide-in-right shadow-sm"><i class="bi bi-exclamation-triangle me-2"></i>Could not withdraw application.</div>';
        }
    }
    ?>
    
    <div class="card rounded-4 shadow-sm mb-5 fade-in-up" style="animation-delay: 0.8s">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover application-list mb-0">
                    <thead class="bg-light">
                        <tr class="text-center">
                            <th class="rounded-top-start border-0 px-4 py-3">Job</th>
                            <th class="border-0 px-4 py-3">Applied At</th>
                            <th class="border-0 px-4 py-3">Status</th>
                            <th class="rounded-top-end border-0 px-4 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Apply filter if set
                    $filter = isset($_GET['filter']) ? $conn->real_escape_string($_GET['filter']) : '';
                    $filter_query = "";
                    if ($filter && $filter != 'all') {
                        $filter_query = " AND a.status = '$filter'";
                    }
                    
                    $applications = $conn->query("SELECT a.*, j.title, j.location FROM applications a JOIN jobs j ON a.job_id = j.id WHERE a.seeker_id = $seeker_id $filter_query ORDER BY a.applied_at DESC");
                    
                    if ($applications->num_rows == 0) {
                        echo '<tr><td colspan="4" class="text-center py-5"><i class="bi bi-inbox text-muted" style="font-size: 2rem;"></i><p class="mt-3 text-muted">No applications found</p></td></tr>';
                    }
                    
                    $count = 0;
                    while ($app = $applications->fetch_assoc()):
                        $count++;
                        $delay = 0.1 * $count;
                        $status = $app['status'] ?? 'pending';
                        $status_class = 'badge bg-warning';
                        $status_icon = 'bi bi-hourglass-split';
                        
                        if ($status == 'shortlisted') {
                            $status_class = 'badge bg-info';
                            $status_icon = 'bi bi-check-circle';
                        }
                        if ($status == 'rejected') {
                            $status_class = 'badge bg-danger';
                            $status_icon = 'bi bi-x-circle';
                        }
                    ?>
                        <tr class="text-center" data-aos="fade-up" data-aos-delay="<?php echo $delay * 50; ?>">
                            <td class="px-4 py-3 align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-light me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; border-radius: 50%;">
                                        <i class="bi bi-briefcase text-primary"></i>
                                    </div>
                                    <div class="text-start">
                                        <p class="mb-0 fw-bold"><?php echo htmlspecialchars($app['title']); ?></p>
                                        <p class="text-muted small mb-0">
                                            <i class="bi bi-geo-alt me-1"></i><?php echo htmlspecialchars($app['location']); ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 align-middle text-nowrap">
                                <i class="bi bi-calendar-date me-1 text-muted"></i>
                                <?php echo date('M d, Y', strtotime($app['applied_at'])); ?>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <span class="<?php echo $status_class; ?> px-3 py-2">
                                    <i class="<?php echo $status_icon; ?> me-1"></i>
                                    <?php echo ucfirst($status); ?>
                                </span>
                            </td>
                            <td class="px-4 py-3 align-middle">
                                <form method="post" action="withdraw.php" class="d-inline">
                                    <input type="hidden" name="application_id" value="<?php echo $app['id']; ?>">
                                    <button type="submit" class="btn btn-outline-danger btn-sm px-3 py-2">
                                        <i class="bi bi-trash me-1"></i> Withdraw
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
