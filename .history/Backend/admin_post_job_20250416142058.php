<?php
session_start();
include("db.php");

// Check if the logged-in user is admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    die("Access denied. Only admin can access this page.");
}

// If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get values from form
    $company_name = $_POST['company_name'];
    $job_title = $_POST['job_title'];
    $job_category = $_POST['job_category'];
    $address = $_POST['address'];
    $description = $_POST['description'];
    $valid_till = $_POST['valid_till'];

    // SQL to insert job post
    $stmt = $conn->prepare("INSERT INTO jobs (company_name, job_title, job_category, address, description, valid_till, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssssss", $company_name, $job_title, $job_category, $address, $description, $valid_till);

    if ($stmt->execute()) {
        $success = "Job posted successfully!";
    } else {
        $error = "Something went wrong. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Post a Job</title>
</head>
<body>
    <h2>Post a New Job</h2>

    <?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="POST" action="">
        <label>Company Name:</label><br>
        <input type="text" name="company_name" required><br><br>

        <label>Job Title:</label><br>
        <input type="text" name="job_title" required><br><br>

        <label>Job Category:</label><br>
        <select name="job_category" required>
            <option value="IT">IT</option>
            <option value="AI">AI</option>
            <option value="Design">Design</option>
            <option value="Sales">Sales</option>
            <option value="Support">Support</option>
        </select><br><br>

        <label>Address:</label><br>
        <input type="text" name="address" required><br><br>

        <label>Description:</label><br>
        <textarea name="description" required></textarea><br><br>

        <label>Valid Till:</label><br>
        <input type="date" name="valid_till" required><br><br>

        <input type="submit" value="Post Job">
    </form>
</body>
</html>
