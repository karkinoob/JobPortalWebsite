<?php
session_start();

$type = $_SESSION["user_type"];
if (!isset($_SESSION["user_type"])) {
    header("Location: login.php");
    exit();
}

if($type === "admin") {
    header("Location: ../admin/admin_dashboard.php");
    exit();
}

include '../db.php';

$user_id = $_SESSION["user_id"];
$user_name = $_SESSION["user_name"];
$user_email = $_SESSION["user_email"];

// Fetch user applications and statuses
$appStmt = $conn->prepare("
    SELECT applications.id, jobs.job_title, applications.status
    FROM applications 
    JOIN jobs ON applications.job_id = jobs.id 
    WHERE applications.user_id = ?
    ORDER BY applications.id DESC
");
$appStmt->bind_param("i", $user_id);
$appStmt->execute();
$appStmt->store_result();
$appStmt->bind_result($application_id, $applied_job_title, $application_status);

// Profile Update Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update the profile details (name, email)
    $new_name = $_POST['name'];
    $new_email = $_POST['email'];

    // Update query for profile
    $updateStmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $updateStmt->bind_param("ssi", $new_name, $new_email, $user_id);
    if ($updateStmt->execute()) {
        // Update session data if profile updated successfully
        $_SESSION["user_name"] = $new_name;
        $_SESSION["user_email"] = $new_email;
        echo "<div class='alert alert-success'>Profile updated successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Failed to update profile.</div>";
    }
    $updateStmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Edit Profile</span>
        <div class="d-flex ms-auto">
            <a href="dashboard.php" class="btn btn-outline-light me-2">Back to Dashboard</a>
            <a href="../logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
</nav>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-8">
            <!-- Profile Form -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="card-title">Edit Your Profile</h2>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user_name) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user_email) ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>

            <!-- Application Status Section -->
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <strong>My Applications</strong>
                </div>
                <div class="card-body">
                    <?php if ($appStmt->num_rows > 0): ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Job Title</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($appStmt->fetch()): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($applied_job_title) ?></td>
                                        <td>
                                            <?php
                                                if ($application_status == "pending") {
                                                    echo "<span class='badge bg-warning'>Pending</span>";
                                                } elseif ($application_status == "approved") {
                                                    echo "<span class='badge bg-success'>Approved</span>";
                                                } elseif ($application_status == "rejected") {
                                                    echo "<span class='badge bg-danger'>Rejected</span>";
                                                } else {
                                                    echo "<span class='badge bg-secondary'>" . htmlspecialchars(ucfirst($application_status)) . "</span>";
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="text-muted">You have not applied for any jobs yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

<?php
$appStmt->close();
?>