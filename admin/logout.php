<?php

session_name('store-admin');
session_start();

unset($_SESSION['auth']);

Header('Location: login.html');

?>