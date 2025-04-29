<?php
session_start();

//admin login chec
$type = $_SESSION["user_type"] ?? null;
if (!isset($type)) {
    header("Location: login.php");
    exit();
}

if($type === "user") {
    header("Location: user/dashboard.php");
    exit();
}

$user_name = $_SESSION["user_name"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom CSS for Navbar */
        .navbar {
            background-color: #343a40; /* Dark background color */
        }
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: white !important; /* Ensures the brand text is white */
        }
        .navbar .btn-danger {
            font-size: 1rem;
            padding: 8px 15px;
            background-color: #dc3545; /* Red color for the logout button */
            border: none;
        }
        .navbar .btn-danger:hover {
            background-color: #c82333; /* Darker red on hover */
        }
    </style>
</head>
<body>

<!-- Navbar Section -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark"> 
    <div class="container-fluid">
        <span class="navbar-brand">Admin Dashboard</span>
        <div class="d-flex ms-auto">
            <a href="../admin/admin_dashboard.php" class="btn btn-primary me-2">Back to Dashboard</a>
            <a href="../logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
</nav>

</body>
</html>
