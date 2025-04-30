<?php
session_start();

if (!isset($_SESSION["user_type"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["user_type"] === "admin") {
    header("Location: ../admin/admin_dashboard.php");
    exit();
}

include '../db.php';

$user_id = $_SESSION["user_id"];
$user_name = $_SESSION["user_name"];
$user_email = $_SESSION["user_email"];

$stmt = $conn->prepare("SELECT id, job_title, job_description FROM jobs ORDER BY id DESC");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($job_id, $job_title, $job_description);

$jobList = [];
while ($stmt->fetch()) {
    $jobList[] = [
        'id' => $job_id,
        'title' => $job_title,
        'description' => $job_description
    ];
}
$stmt->close();
?>

<div class="card-body">
    <!-- Search bar -->
    <div class="input-group mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Search job title or description">
        <button class="btn btn-outline-primary" id="searchBtn">Search</button>
    </div>

    <!-- Results container -->
    <div id="jobResults">
        
    </div>
</div>