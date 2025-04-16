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
</html>
