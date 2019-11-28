<?php

session_name('store');
session_start();

include('config.php');
include('template.php');
include('library.php');


$sum = get_cart_sum();                    // total sum of cart
$items = get_cart_num_items();            // num of items


$tpl->get_tpl('templates/contacts.html');
$tpl->set_value('TITLE', $title=$title.' Контакти');
$tpl->set_value('SUM',$sum);  
$tpl->set_value('ITEMS',$items);  


$tpl->tpl_parse();
echo $tpl->html;

?>