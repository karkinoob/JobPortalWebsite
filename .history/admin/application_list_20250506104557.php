<?php
session_start();
if ($_SESSION["user_type"] !== "admin") {
    header("Location: login.php");
    exit();
}

include '../db.php';

// Fetch applications with job and user details
$sql = "SELECT a.id AS application_id, a.status AS application_status, a.applied_at, 
            j.job_title, j.company_name, u.user_name, u.user_email
        FROM applications a
        JOIN jobs j ON a.job_id = j.id
        JOIN users u ON a.user_id = u.id
        ORDER BY a.applied_at DESC";
$result = mysqli_query($conn, $sql); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Application List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Admin Dashboard</span>
        <div class="d-flex ms-auto">
            <a href="admin_dashboard.php" class="btn btn-outline-light me-2">Back to Dashboard</a>
            <a href="../logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h2 class="mb-4">Job Applications</h2>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Applicant Name</th>
                    <th>Job Title</th>
                    <th>Email</th>
                    <th>Applied On</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['job_title']); ?></td>
                        <td><?php echo htmlspecialchars($row['user_email']); ?></td>
                        <td><?php echo htmlspecialchars($row['applied_at']); ?></td>
                        <td>
                            <?php
                            if ($row['application_status'] === 'pending') {
                                echo '<span class="badge bg-warning">Pending</span>';
                            } elseif ($row['application_status'] === 'approved') {
                                echo '<span class="badge bg-success">Approved</span>';
                            } else {
                                echo '<span class="badge bg-danger">Rejected</span>';
                            }
                            ?>
                        </td>
                        <td>
                            <?php if ($row['application_status'] === 'pending'): ?>
                                <a href="approve_application.php?id=<?php echo $row['application_id']; ?>" class="btn btn-success btn-sm">Approve</a>
                                <a href="reject_application.php?id=<?php echo $row['application_id']; ?>" class="btn btn-danger btn-sm">Reject</a>
                            <?php else: ?>
                                <span class="text-muted">Action completed</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No applications found.</p>
    <?php endif; ?>
</div>

</body>
</html>
