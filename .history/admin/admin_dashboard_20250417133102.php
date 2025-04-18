<?php
session_start();
if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Welcome, <?= $_SESSION["admin_name"] ?> (Admin)</h2>
        <a href="admin_logout.php" class="btn btn-danger float-end">Logout</a>

        <h4 class="mt-4">Dashboard Options</h4>
        <ul>
            <li><a href="admin_post_job.php">Post New Job</a></li>
            <li><a href="admin_view_jobs.php">View All Job Vacancies</a></li>
            <li><a href="admin_view_users.php">View Users</a></li>
            <li><a href="admin_view_applications.php">View Applications</a></li>
        </ul>
    </div>
</body>
</html>
