<?php
session_start();

$islogin = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

?>
<!DOCTYPE html>
<html>
<head>
    <title>Job Portal</title>
</head>
<body>

<?php if ($islogin): ?>
    <a href="user/dashboard.php">Go to Dashboard</a>
<?php else: ?>
    <a href="login.php">Login</a>
<?php endif; ?>

<h2>Available Jobs</h2>
<a href="apply_job.php?job_id=123">Apply Now</a> 

</body>
</html>
