<?php
session_start();
include '../db.php';

if (!isset($_GET['id'])) {
    echo "Job ID not found.";
    exit();
}

$job_id = intval($_GET['id']); 

$sql = "SELECT * FROM jobs WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $job_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Job not found.";
    exit();
}

$job = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($job['job_title']); ?> - Job Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <a href="dashboard.php" class="btn btn-secondary mb-3">← Back to Dashboard</a>

    <h2><?php echo htmlspecialchars($job['job_title']); ?></h2>
    <p><strong>Company:</strong> <?= echo htmlspecialchars($job['company_name']); ?></p>
    <p><strong>Location:</strong> <?php echo htmlspecialchars($job['address']); ?></p>
    <p><strong>Category:</strong> <?php echo htmlspecialchars($job['job_category']); ?></p>
    <p><strong>Deadline:</strong> <?php echo htmlspecialchars($job['valid_till']); ?></p>
    <p><strong>Description:</strong><br><?php echo nl2br(htmlspecialchars($job['job_description'])); ?></p>

    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="apply_job.php?id=<?php echo $job['id']; ?>" class="btn btn-success">Apply Now</a>
    <?php else: ?>
        <p class="text-danger">You must <a href="../login.php">login</a> to apply.</p>
    <?php endif; ?>

</body>
</html>
