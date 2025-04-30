<?php
session_start();

if (!isset($_SESSION["user_type"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["user_type"] === "admin") {
    header("Location: ../admin/admin_dashboard.php");
    exit();
}

include '../db.php';

$user_id = $_SESSION["user_id"];
$user_name = $_SESSION["user_name"];
$user_email = $_SESSION["user_email"];

$stmt = $conn->prepare("SELECT id, job_title, job_description FROM jobs WHERE job_title LIKE CONCAT('%', ?, '%') OR job_description LIKE CONCAT('%', ?, '%') ORDER BY id DESC");
$stmt->bind_param("ss", $search, $search);$stmt->execute();
$stmt->store_result();
$stmt->bind_result($job_id, $job_title, $job_description);
$search = isset($_GET['q']) ? trim($_GET['q']) : '';

$jobList = [];
while ($stmt->fetch()) {
    $jobList[] = [
        'id' => $job_id,
        'title' => $job_title,
        'description' => $job_description
    ];
}
$stmt->close();
?>
<?php if (!empty($jobList)): ?>
    <div class="list-group">
        <?php foreach ($jobList as $job): ?>
            <div class="list-group-item">
                <h5 class="mb-1"><?= htmlspecialchars($job['title']) ?></h5>
                <p class="mb-1"><?= htmlspecialchars($job['description']) ?></p>
                <div class="d-flex">
                    <a href="job_detail.php?id=<?= $job['id'] ?>" class="btn btn-sm btn-primary me-2">View Details</a>
                    <a href="apply_job.php?id=<?= $job['id'] ?>" class="btn btn-sm btn-success">Apply</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p class="text-muted">No jobs listed yet.</p>
<?php endif; ?>