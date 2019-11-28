<?php

include('auth.php');
include('../config.php');
include('../connect.php');

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$code = filter_input(INPUT_GET, 'code', FILTER_VALIDATE_INT);

if ($id == FALSE || $id == NULL) {
    header("HTTP/1.0 404 Not Found");
    die();
    }
if ($code == FALSE || $code == NULL) {
    header("HTTP/1.0 404 Not Found");
    die();
    }    

$q = "update orders set status = $code where id = $id limit 1";    

$conn->query($q);

Header('Location: orders.php');

?>