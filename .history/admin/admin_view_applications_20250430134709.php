<?php
include '../db.php';
include '../header.php';

// Only allow admins
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

$job_id = $_GET['job_id'] ?? 0;

// Fetch job info
$job_query = mysqli_query($conn, "SELECT job_title FROM jobs WHERE id = $job_id");
$job = mysqli_fetch_assoc($job_query);

// Fetch applications
$sql = "SELECT a.id as application_id, a.cover_letter, a.resume, a.status, a.created_at,
               u.name as applicant_name, u.email as applicant_email
        FROM applications a
        JOIN users u ON a.user_id = u.id
        WHERE a.job_id = $job_id
        ORDER BY a.created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Applications for <?php echo $job['job_title']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2>Applications for <span class="text-primary"><?php echo $job['job_title']; ?></span></h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Applicant Name</th>
                        <th>Email</th>
                        <th>Cover Letter</th>
                        <th>Resume</th>
                        <th>Status</th>
                        <th>Submitted On</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 1; while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= htmlspecialchars($row['applicant_name']); ?></td>
                        <td><?= htmlspecialchars($row['applicant_email']); ?></td>
                        <td><?= nl2br(($row['cover_letter'])); ?></td>
                        <td><a href="../uploads/<?= $row['resume']; ?>" target="_blank">Download</a></td>
                        <td><strong class="text-uppercase"><?= $row['status']; ?></strong></td>
                        <td><?= date("F j, Y, g:i A", strtotime($row['created_at'])); ?></td>
                        <td>
                            <?php if ($row['status'] == 'pending'): ?>
                                <a href="application_action.php?id=<?= $row['application_id']; ?>&action=approved" class="btn btn-success btn-sm">Approve</a>
                                <a href="application_action.php?id=<?= $row['application_id']; ?>&action=rejected" class="btn btn-danger btn-sm">Reject</a>
                            <?php else: ?>
                                <span class="badge bg-info">Already <?= ucfirst($row['status']); ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No applications submitted yet for this job.</div>
    <?php endif; ?>
</div>

</body>
</html>
