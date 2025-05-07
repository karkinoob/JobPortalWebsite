<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $islogin = $_SESSION['user_id'];
} else {
    $islogin = null;
}

header("Location: user/dashboard.php");
exit;

if ($islogin) {
    header("Location: user/dashboard.php");
    exit;
} else {
    header("Location:login.php");
    exit;
}