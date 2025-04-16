<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Welcome Admin</h2>
    <a href="post_job.php">Post New Job</a><br>
    <a href="logout.php">Logout</a>
</body>
</html>
