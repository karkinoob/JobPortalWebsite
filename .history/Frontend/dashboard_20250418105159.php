<?php
session_start();

$type = $_SESSION["user_type"];
if (!isset($_SESSION["user_type"])) {
    header("Location: login.php");
    exit();
}

if($type==="admin") {
    header("Location: ../admin/admin_dashboard.php");
    exit();
}

include '../db.php';

$user_id = $_SESSION["user_id"];
$user_name = $_SESSION["user_name"];
$user_email = $_SESSION["user_email"];

$stmt = $conn->prepare("SELECT job_title, job_description FROM jobs WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($job_title, $job_description);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Dashboard</span>
        <div class="d-flex ms-auto">
            <a href="edit_profile.php" class="btn btn-outline-light me-2">Edit Profile</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
</nav>


<div class="container-fluid mt-4">
    <div class="row">
        <!-- Sidebar: Job Listings -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <strong>Your Job Listings</strong>
                </div>
                <div class="card-body">
                    <?php if ($stmt->num_rows > 0): ?>
                        <ul class="list-group">
                            <?php while ($stmt->fetch()): ?>
                                <li class="list-group-item">
                                    <strong><?= htmlspecialchars($job_title) ?>:</strong><br>
                                    <?= htmlspecialchars($job_description) ?>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted">No jobs listed yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Main Info Section -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title">Welcome, <?= htmlspecialchars($user_name) ?>!</h2>
                    <p><strong>Email:</strong> <?= htmlspecialchars($user_email) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

<?php $stmt->close(); ?>
