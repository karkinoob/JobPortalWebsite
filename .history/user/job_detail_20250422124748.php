<?php
session_start();
include '../db.php';

// Check if job ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Job ID not specified.";
    exit();
}

$job_id = intval($_GET['id']); // Ensure it's an integer
$sql = "SELECT * FROM jobs WHERE id = $job_id";
$result = mysqli_query($conn, $sql);

// Check if job exists
if (mysqli_num_rows($result) == 0) {
    echo "Job not found.";
    exit();
}

$job = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Job Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-3"><?= htmlspecialchars($job['job_title']) ?></h2>

    <p><strong>Company:</strong> <?= htmlspecialchars($job['company_name']) ?></p>
    <p><strong>Location:</strong> <?= htmlspecialchars($job['address']) ?></p>
    <p><strong>Category:</strong> <?= htmlspecialchars($job['job_category']) ?></p>
    <p><strong>Deadline:</strong> <?= htmlspecialchars($job['valid_till']) ?></p>
    <p><strong>Description:</strong><br> <?= nl2br(htmlspecialchars($job['job_description'])) ?></p>

    <hr>

    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] == 'user'): ?>
        <a href="apply_job.php?id=<?= $job['id'] ?>" class="btn btn-primary">Apply Now</a>
    <?php else: ?>
        <p><a href="../login.php" class="btn btn-warning">Login</a> to apply for this job.</p>
    <?php endif; ?>
</div>
</body>
</html>
