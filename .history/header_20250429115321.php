<?php
session_start();

//admin login checking  
if (isset($_SESSION["user_type"])) {
    $type = $_SESSION["user_type"]; 
} else {
    $type = null; 
}

if ($type === null) {
    header("Location: login.php");
    exit();
}
if ($type === "user") {
    header("Location: user/dashboard.php");
    exit();
}
$user_name 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        
        .navbar {
            background-color: #343a40; 
        }
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: white !important; 
        }
        .navbar .btn-danger {
            font-size: 1rem;
            padding: 8px 15px;
            background-color: #dc3545; 
            border: none;
        }
        .navbar .btn-danger:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>


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
