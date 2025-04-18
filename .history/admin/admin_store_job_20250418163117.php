<?php
include '../db.php'; // Your DB connection file
session_start();

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = $_SESSION['user_id'];
    $company = mysqli_real_escape_string($conn, $_POST['company_name']);
    $title = mysqli_real_escape_string($conn, $_POST['job_title']);
    $desc = mysqli_real_escape_string($conn, $_POST['job_description']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $valid_till = mysqli_real_escape_string($conn, $_POST['valid_till']);

    $sql = "INSERT INTO jobs (user_id, company_name, job_title, job_description, address, job_category, valid_till, created_at)
            VALUES ('$company', '$title', '$desc', '$address', '$category', '$valid_till', NOW())";
            echo $sql;

    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "Job posted successfully.";
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>
