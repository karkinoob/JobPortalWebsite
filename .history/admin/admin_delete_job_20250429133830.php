<?php
include '../db.php';
session_start();

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

// Check if job id is passed
if (isset($_GET['id'])) {
    $job_id = $_GET['id'];

    // Delete job from the database
    $delete_sql = "DELETE FROM jobs WHERE id = $job_id";
    if (mysqli_query($conn, $delete_sql)) {
        $_SESSION['success'] = "Job deleted successfully.";
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error deleting job: " . mysqli_error($conn);
    }
} else {
    echo "Invalidequest.";
}
