<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $company = $_POST['company'];
    $address = $_POST['address'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $valid_till = $_POST['valid_till'];

    $sql = "INSERT INTO jobs (title, company, address, description, category, valid_till)
            VALUES ('$title', '$company', '$address', '$description', '$category', '$valid_till')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Job posted successfully!'); window.location.href='admin_dashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
