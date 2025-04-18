<?php
session_start();
$islogin = $_SESSION['user_id'] ?? null;
if($islogin){
    header("Location: user/dashboard.php");
    exit;
}else{
    header("Location:login.php");
    exit;
}