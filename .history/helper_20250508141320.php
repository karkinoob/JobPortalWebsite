<?php 
function test_input($data) {
    $data = trim(stripslashes(htmlspecialchars($data)));
    return $data;
}