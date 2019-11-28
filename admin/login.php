<?php

include('../config.php');

$login = $_POST['login'];
$password = $_POST['password'];

if ($login !== $admin)
    die('Login Incorrect');
    
if ($password !== $passwd)
    die('Password Incorrect');
    
session_name('store-admin');
session_start();  

$_SESSION['auth'] = "yes";
$_SESSION['login'] = $login;  
    
Header('Location: index.php');

?>
