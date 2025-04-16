<!-- <?php
include '../db.php'; 
session_start();


$user_id = 1; 
$title = $description = "";
$titleErr = $descErr = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["job_title"])) {
        $titleErr = "Job title is required";
    } else {
        $title = htmlspecialchars(trim($_POST["job_title"]));
    }

    if (empty($_POST["job_description"])) {
        $descErr = "Job description is required";
    } else {
        $description = htmlspecialchars(trim($_POST["job_description"]));
    }

    if (!$titleErr && !$descErr) {
        $stmt = $conn->prepare("INSERT INTO jobs (user_id, job_title, job_description) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $title, $description);
        if ($stmt->execute()) {
            $success = "Job posted successfully!";
            $title = $description = ""; 
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Post Job</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5" style="max-width: 600px;">
    <h2 class="text-center mb-4">Post a Job</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="mb-3">
            <label class="form-label">Job Title</label>
            <input type="text" name="job_title" class="form-control" value="<?= $title ?>">
            <small class="text-danger"><?= $titleErr ?></small>
        </div>

        <div class="mb-3">
            <label class="form-label">Job Description</label>
            <textarea name="job_description" class="form-control"><?= $description ?></textarea>
            <small class="text-danger"><?= $descErr ?></small>
        </div>

        <button type="submit" class="btn btn-primary w-100">Post Job</button>
    </form>
</div>
</body>
</html> -->
<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!-- <!DOCTYPE html>
<html>
<head>
    <title>Post Job</title>
</head>
<body>
    <h2>Post a New Job</h2>
    <form action="handle_post_job.php" method="POST">
        <input type="text" name="title" placeholder="Job Title" required><br>
        <input type="text" name="company" placeholder="Company Name" required><br>
        <input type="text" name="address" placeholder="Job Address" required><br>
        <textarea name="description" placeholder="Job Description" required></textarea><br>
        <input type="text" name="category" placeholder="Job Category" required><br>
        <input type="date" name="valid_till" required><br>
        <button type="submit">Post Job</button>
    </form>
</body>
</html> -->

