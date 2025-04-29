<?php
include '../db.php';
include '../header.php';

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
    $company = mysqli_real_escape_string($conn, $_POST['company_name']);
    $title = mysqli_real_escape_string($conn, $_POST['job_title']);
    $desc = mysqli_real_escape_string($conn, $_POST['job_description']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $valid_till = mysqli_real_escape_string($conn, $_POST['valid_till']);

    $update_sql = "UPDATE jobs SET 
                   company_name = '$company', 
                   job_title = '$title', 
                   job_description = '$desc', 
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Job</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="mb-4 text-center">Edit Job</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label">Company Name:</label>
                <input type="text" class="form-control" name="company_name" value="<?= $job['company_name'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Job Title:</label>
                <input type="text" class="form-control" name="job_title" value="<?= $job['job_title'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Job Description:</label>
                <textarea class="form-control" name="job_description" rows="5" required><?= $job['job_description'] ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Address:</label>
                <input type="text" class="form-control" name="address" value="<?= $job['address'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Category:</label>
                <select class="form-select" name="category" required>
                    <option value="IT" <?= $job['job_category'] == 'IT' ? 'selected' : '' ?>>IT</option>
                    <option value="AI" <?= $job['job_category'] == 'AI' ? 'selected' : '' ?>>AI</option>
                    <option value="Design" <?= $job['job_category'] == 'Design' ? 'selected' : '' ?>>Design</option>
                    <option value="Sales" <?= $job['job_category'] == 'Sales' ? 'selected' : '' ?>>Sales</option>
                    <option value="Support" <?= $job['job_category'] == 'Support' ? 'selected' : '' ?>>Support</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Valid Till:</label>
                <input type="date" class="form-control" name="valid_till" value="<?= $job['valid_till'] ?>" required>
            </div>

            <div class="d-grid">
                <input type="submit" class="btn btn-primary" value="Update Job">
            </div>
        </form>
    </div>
</div>
</body>
</html>
