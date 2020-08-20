<?php 

session_name('store');
session_start();

include('config.php');
include('template.php');
include('library.php');

$email = filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL);

if ($email == NULL || $email == FALSE) 
    $MSG = "<h1>Грешка!</h1><p>Проверете имейла!</p>";
else {
    $MSG = "<h1>Благодарим Ви!</h1><p>Ще получите информация за отстъпки и промоции навреме!</p>";
    file_put_contents ('emails.txt', "$email\n", FILE_APPEND);
    
}   

$sum = get_cart_sum();                    // total sum of cart
$items = get_cart_num_items();            // num of items

$tpl->get_tpl('templates/order.html');
$tpl->set_value('TITLE', $title = $title.' Абониране');          // this var defined in config.php
$tpl->set_value('SUM',0);      
$tpl->set_value('ITEMS',0); 
$tpl->set_value('MSG',$MSG); 

$tpl->tpl_parse();
echo $tpl->html;
 
?>