<?php 
function test_input($data) {
    $data = trim(stripslashes()$data);
    // $data = stripslashes($data);
    // $data = htmlspecialchars($data);
    return $data;
}