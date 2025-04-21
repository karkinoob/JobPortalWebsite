<?php
include '../db.php';
session_start();

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

// Get job details
if (isset($_GET['id'])) {
    $job_id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM jobs WHERE id = $job_id");
    $job = mysqli_fetch_assoc($result);

    if (!$job) {
        die("Job not found.");
    }
} else {
    die("Invalid request.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission to update job
    $company = mysqli_real_escape_string($conn, $_POST['company_name']);
    $title = mysqli_real_escape_string($conn, $_POST['job_title']);
    $desc = mysqli_real_escape_string($conn, $_POST['job_description']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $valid_till = mysqli_real_escape_string($conn, $_POST['valid_till']);

    $update_sql = "UPDATE jobs SET 
                   company_name = '$company', 
                   job_title = '$title', 
                   description = '$desc', 
                   address = '$address', 
                   job_category = '$category', 
                   valid_till = '$valid_till'
                   WHERE id = $job_id";

    if (mysqli_query($conn, $update_sql)) {
        $_SESSION['success'] = "Job updated successfully.";
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error updating job: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Job</title>
</head>
<body>
    <h2>Edit Job</h2>
    <form action="" method="POST">
        <label>Company Name:</label>
        <input type="text" name="company_name" value="<?= $job['company_name'] ?>" required><br><br>

        <label>Job Title:</label>
        <input type="text" name="job_title" value="<?= $job['job_title'] ?>" required><br><br>

        <label>Job Description:</label>
        <textarea name="job_description" rows="5" required><?= $job['job_description'] ?></textarea><br><br>

        <label>Address:</label>
        <input type="text" name="address" value="<?= $job['address'] ?>" required><br><br>

        <label>Category:</label>
        <select name="category" required>
            <option value="IT" <?= $job['job_category'] == 'IT' ? 'selected' : '' ?>>IT</option>
            <option value="AI" <?= $job['job_category'] == 'AI' ? 'selected' : '' ?>>AI</option>
            <option value="Design" <?= $job['job_category'] == 'Design' ? 'selected' : '' ?>>Design</option>
            <option value="Sales" <?= $job['job_category'] == 'Sales' ? 'selected' : '' ?>>Sales</option>
            <option value="Support" <?= $job['job_category'] == 'Support' ? 'selected' : '' ?>>Support</option>
        </select><br><br>

        <label>Valid Till:</label>
        <input type="date" name="valid_till" value="<?= $job['valid_till'] ?>" required><br><br>

        <input type="submit" value="Update Job">
    </form>
</body>
</html>
