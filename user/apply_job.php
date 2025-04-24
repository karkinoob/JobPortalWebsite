<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    echo "Job ID not found.";
    exit();
}

$job_id = intval($_GET['id']);
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cover_letter = mysqli_real_escape_string($conn, $_POST["cover_letter"]);

    // File upload
    $resume_name = $_FILES['resume']['name'];
    $resume_tmp = $_FILES['resume']['tmp_name'];
    $resume_ext = pathinfo($resume_name, PATHINFO_EXTENSION);
    $allowed = ['pdf', 'doc', 'docx'];

    if (!in_array($resume_ext, $allowed)) {
        $errors[] = "Only PDF, DOC, or DOCX files allowed.";
    }

    $new_name = uniqid() . "." . $resume_ext;
    $upload_path = "../uploads/" . $new_name;

    if (empty($errors)) {
        move_uploaded_file($resume_tmp, $upload_path);

        $stmt = $conn->prepare("INSERT INTO applications (user_id, job_id, cover_letter, resume) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $user_id, $job_id, $cover_letter, $new_name);
        $stmt->execute();

        echo "<div class='alert alert-success'>Application submitted successfully.</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Apply to Job</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Apply for Job ID: <?= $job_id ?></h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $err) echo "<li>$err</li>"; ?>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Cover Letter</label>
            <textarea name="cover_letter" class="form-control" rows="5" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Upload Resume (PDF/DOC)</label>
            <input type="file" name="resume" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit Application</button>
    </form>
</body>
</html>
