<?php
session_start();
include '../db.php'; // DB connection

// Only allow admins to access this page
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

// Fetch all jobs
$result = mysqli_query($conn, "SELECT * FROM jobs ORDER BY created_at DESC");

if (mysqli_num_rows($result) > 0) {
    echo "<h2>Posted Jobs</h2>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div>";
        echo "<h3>" . $row['job_title'] . "</h3>";
        echo "<p>Company: " . $row['company_name'] . "</p>";
        echo "<p>Category: " . $row['job_category'] . "</p>";
        echo "<p>Description: " . $row['description'] . "</p>";
        echo "<p>Valid Till: " . $row['valid_till'] . "</p>";
        echo "<p>Posted on: " . $row['created_at'] . "</p>";

        echo "<a href='admin_edit_job.php?id=" . $row['id'] . "'>Edit</a> | ";
        echo "<a href='admin_delete_job.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this job?\")'>Delete</a>";

        echo "</div><hr>";
    }
} else {
    echo "No jobs posted yet.";
}
?>

