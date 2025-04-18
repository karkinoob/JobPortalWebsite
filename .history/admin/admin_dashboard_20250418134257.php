<?php
session_start();
include '../config.php'; // DB connection

// Only allow admins to access this page
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

// Fetch all jobs
$result = mysqli_query($conn, "SELECT * FROM jobs ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJt3WvLJgxeuIzvx6p27c9jAKfO6NlggH7F8eZqjf5jw6jGlt5CYPbOdj3a0" crossorigin="anonymous">
    <style>
        .dashboard-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .job-item {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .job-item a {
            margin-right: 10px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <div class="d-flex">
                <a href="../logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="dashboard-header">Welcome to Admin Dashboard!</h2>

        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
                <div class="job-item">
                    <h3><?php echo $row['job_title']; ?></h3>
                    <p><strong>Company:</strong> <?php echo $row['company_name']; ?></p>
                    <p><strong>Category:</strong> <?php echo $row['job_category']; ?></p>
                    <p><strong>Description:</strong> <?php echo $row['description']; ?></p>
                    <p><strong>Valid Till:</strong> <?php echo $row['valid_till']; ?></p>
                    <p><strong>Posted on:</strong> <?php echo $row['created_at']; ?></p>

                    <!-- Edit and Delete Links -->
                    <a href="admin_edit_job.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="admin_delete_job.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this job?')">Delete</a>
                </div>
        <?php
            }
        } else {
            echo "<p>No jobs posted yet.</p>";
        }
        ?>

    </div>

    <!-- Bootstrap JS (optional, for interactivity like modals, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0dH6sZqpe/JyIY1Fz98b6bFJlkszcnfvErbIpG5g7ml6wVmr" crossorigin="anonymous"></script>
</body>

</html>
