<?php

session_name('store');
session_start();

include('config.php');
include('template.php');
include('library.php');

$tpl->get_tpl('templates/main.html');

$sum= get_cart_sum();                    // total sum of cart
$items = get_cart_num_items();            // num of items

$tpl->set_value('TITLE', $title=$title.' Начало');    
$tpl->set_value('SUM',$sum);      
$tpl->set_value('ITEMS',$items);    
$tpl->tpl_parse();
echo $tpl->html;

?>
