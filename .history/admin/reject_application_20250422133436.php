<?php
session_start();
if ($_SESSION["user_type"] !== "admin") {
    header("Location: login.php");
    exit();
}

include '../db.php';

// Get the application ID
$application_id = $_GET['id'];

// Update application status to "rejected"
$sql = "UPDATE applications SET status = 'rejected' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $application_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    header("Location: application_list.php?status=rejected");
} else {
    echo "Error: Could not reject application.";
}

$stmt->close();
$conn->close();
?>
