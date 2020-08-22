<?php

session_name('store');
session_start();

include('config.php');
include('connect.php');
include('template.php');
include('library.php');

$MSG = "<h2>Успешна поръчка!</h2>
			  <p>Мениджърът ще се свърже с Вас, за да уточните детайлите на поръчката!</p>";

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_MAGIC_QUOTES);
$family = filter_input(INPUT_POST, 'family', FILTER_SANITIZE_MAGIC_QUOTES);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_MAGIC_QUOTES);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_MAGIC_QUOTES);


if ($email == NULL || $email == FALSE) 
    $MSG = "<h1>Грешка!</h1> <p>Проверете имейла!</p>";
else 
if (isset($_SESSION['cart'])) {

    $sum = $_SESSION['sum'];
    $items = $_SESSION['cart'];
    
    $dt = date('Y-m-d H-i-s');
    $q = "insert into orders values(0, \"$name\", \"$family\",  \"$email\", \"$address\", \"$phone\", \"$items\", $sum, 0, \"$dt\")";
    
    $conn->query($q);
    
    unset($_SESSION['cart']);
    unset($_SESSION['sum']);

}
else 
    $MSG = "<h1>Грешка!</h1> <p>Количката е празна!</p>";

$tpl->get_tpl('templates/order.html');
$tpl->set_value('TITLE', $title=$title.' Поръчки');          // this var defined in config.php
$tpl->set_value('SUM',0);      
$tpl->set_value('ITEMS',0); 
$tpl->set_value('MSG',$MSG); 

$tpl->tpl_parse();
echo $tpl->html;

?>