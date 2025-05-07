<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $islogin = $_SESSION['user_id'];
} else {
    $islogin = null;
}

if ($islogin) {
    header("Location: user/dashboard.php");
    exit;
} else {
    header("Location:../user/dashboard.php");
    exit;
}