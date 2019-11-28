<?php

session_name('store-admin');
session_start();

include('../config.php');

if (!isset($_SESSION['auth']))
   Header('Location: login.html');
   
?>
