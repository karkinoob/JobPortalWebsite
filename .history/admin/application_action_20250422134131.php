<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

$application_id = $_GET['id'] ?? 0;
$action = $_GET['action'] ?? '';

if ($application_id && in_array($action, ['approved', 'rejected'])) {
    $stmt = $conn->prepare("UPDATE applications SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $action, $application_id);
    $stmt->execute();
}

header("Location: {$_SERVER['HTTP_REFERER']}");
exit();
