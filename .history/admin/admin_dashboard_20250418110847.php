<?php
session_start();
// if (!isset($_SESSION["admin_id"])) {
//     header("Location: admin_login.php");
//     exit();
// }
// print_r($_SESSION);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Welcome!</h2>
    <p>This is the admin dashboard.</p>
    <a href="../Frontend/">Logout</a>
</body>
</html>
