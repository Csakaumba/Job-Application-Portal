<?php
require_once __DIR__ . '/config/db.php';

// Find an employer user
$res = $conn->query("SELECT id FROM users WHERE role='employer' LIMIT 1");
if ($res->num_rows === 0) {
    echo "No employer found. Please create an employer user first.\n";
    exit;
}
$employer = $res->fetch_assoc();
$employer_id = $employer['id'];

// Sample jobs to insert
$sampleJobs = [
    ['Software Engineer', 'Develop and maintain web applications using PHP and JavaScript.', 'Remote'],
    ['Data Analyst', 'Analyze data sets and produce actionable insights.', 'New York, NY'],
    ['UX Designer', 'Design intuitive user interfaces and experiences.', 'San Francisco, CA'],
    ['Project Manager', 'Lead project teams to deliver business solutions on time.', 'Chicago, IL'],
    ['DevOps Engineer', 'Manage CI/CD pipelines and cloud infrastructure.', 'Austin, TX']
];

$stmt = $conn->prepare("INSERT INTO jobs (title, description, location, employer_id, posted_at) VALUES (?, ?, ?, ?, NOW())");
$stmt->bind_param('sssi', $title, $description, $location, $employer_id);

$inserted = 0;
foreach ($sampleJobs as $job) {
    list($title, $description, $location) = $job;
    $stmt->execute();
    $inserted += $stmt->affected_rows;
}
echo "Inserted {$inserted} sample jobs for employer ID {$employer_id}.\n";
