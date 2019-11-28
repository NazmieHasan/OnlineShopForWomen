<?php

include('auth.php');
include('../config.php');
include('../connect.php');

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id == FALSE || $id == NULL) 
    header("HTTP/1.0 404 Not Found");
    
$conn->query("delete from brands where bid = $id limit 1");

Header('Location: brands.php');

?>