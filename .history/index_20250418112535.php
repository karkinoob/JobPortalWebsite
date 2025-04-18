<?php
session_start();
$islogin = $_SESSION['user_id'] ?? null;
if($islogin){
    header("Location: Frontend/dashboard.php");
    exit;
}else{
    header("Location:login.php");
    exit;
}