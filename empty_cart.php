<?php

session_name('store');
session_start();

unset($_SESSION['sum']);
unset($_SESSION['cart']);

Header('Location: index.php');

?>