<?php
session_start();
include '../db.php'; 

// Only allowing admins to access this page
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

// Fetching all the jobs
$result = mysqli_query($conn, "SELECT * FROM jobs ORDER BY created_at DESC");
$job_count = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .dashboard-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .job-card {
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }
        .btn-action {
            margin-right: 10px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid justify-content-between">
        <a class="navbar-brand fw-bold" href="#">Admin Dashboard</a>
        <a href="../logout.php" class="btn btn-danger">Logout</a>
    </div>
</nav>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="dashboard-header mb-0">Posted Jobs (<?php echo $job_count; ?>)</h2>
        <a href="admin_post_job.php" class="btn btn-success btn-lg">➕ Post New Job</a> 
    </div>

    <?php
    if ($job_count > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

            $job_id = $row['id'];
            $app_sql = "SELECT COUNT(*) AS total_applications FROM applications WHERE job_id = $job_id";
            $app_result = mysqli_query($conn, $app_sql);
            $app_row = mysqli_fetch_assoc($app_result);
            $total_applications = $app_row['total_applications'];


    ?>
        <div class="card mb-4 job-card">
            <div class="card-body">
                <h4 class="card-title text-primary"><?php echo $row['job_title']; ?></h4>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo $row['company_name']; ?> - <?php echo $row['job_category']; ?></h6>
                <p class="card-text"><?php echo $row['job_description']; ?></p>
                <p class="mb-1"><strong>Location:</strong> <?php echo $row['address']; ?></p>
                <p class="mb-1"><strong>Valid Till:</strong> <?php echo $row['valid_till']; ?></p>
                <p class="mb-3"><strong>Posted on:</strong> <?php echo date("F j, Y", strtotime($row['created_at'])); ?></p>


                <!-- SHOW number of applications -->
            <p class="mb-3"><strong>Applications Received:</strong> <?php echo $total_applications; ?></p>

                <!-- Buttons -->
                <a href="admin_edit_job.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm btn-action">✏️ Edit</a>
                <a href="admin_view_applications.php?job_id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">📄 View Applications</a>
                <a href="admin_delete_job.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm btn-action" onclick="return confirm('Are you sure you want to delete this job?')">🗑 Delete</a
            </div>
        </div>
    <?php
        }
    } else {
        echo "<div class='alert alert-info'>No jobs posted yet.</div>";
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
