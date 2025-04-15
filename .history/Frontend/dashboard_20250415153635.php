<?php
session_start(); // Start session to access user data

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php"); 
    exit();
}


include 'db.php';


$user_id = $_SESSION["user_id"];
$user_name = $_SESSION["user_name"];
$user_email = $_SESSION["user_email"];

$stmt = $conn->prepare("SELECT job_title, job_description FROM jobs WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($job_title, $job_description);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 600px;">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Welcome, <?= htmlspecialchars($user_name) ?>!</h2>
            <p class="text-center">Email: <?= htmlspecialchars($user_email) ?></p>
            <h4 class="mt-4">Your Job Listings:</h4>
            
            <?php if ($stmt->num_rows > 0): ?>
                <ul>
                    <?php while ($stmt->fetch()): ?>
                        <li>
                            <strong><?= htmlspecialchars($job_title) ?>:</strong> <?= htmlspecialchars($job_description) ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No jobs listed yet.</p>
            <?php endif; ?>

            <div class="d-flex justify-content-between mt-4">
                <a href="logout.php" class="btn btn-danger">Logout</a>
                <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<?php
$stmt->close();
?>
