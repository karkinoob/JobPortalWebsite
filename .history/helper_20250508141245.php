<?php 
function test_input($data) {
    $data = trim(stripslashes(htmlspecialchars())$data);
    // $data = stripslashes($data);
    // $data = htmlspecialchars($data);
    return $data;
}