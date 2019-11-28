<?php

session_name('store');
session_start();

$category = 'shoes';
$num = 6;       // max products on the page

include('config.php');
//include('connect.php');

include('template.php');
include('library.php');

$tpl->get_tpl('templates/products.html');

$sum = get_cart_sum();                    // total sum of cart
$items = get_cart_num_items();            // num of items

$bid = filter_input(INPUT_GET, 'brand', FILTER_VALIDATE_INT);
if ($bid == FALSE || $bid == NULL) $bid = 0;

$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
if ($page == FALSE || $page == NULL) $page = 0;

$price = filter_input(INPUT_GET, 'price', FILTER_VALIDATE_INT);
if ($price == FALSE || $price == NULL) $price = 0;

// pagination
$qty = get_product_qty_by_category($category);
$pages = get_pagination($qty, $num);
  

$brands = get_brands($category);
$items_list = get_items_list($category, $bid, "price", $page, $num, $price);   

$price_filter = get_price_filter(18);

$tpl->set_value('TITLE', $title=$title.' Обувки');          // this var defined in config.php
$tpl->set_value('SUM',$sum);      
$tpl->set_value('ITEMS',$items);    
$tpl->set_value('BRANDS',$brands);   
$tpl->set_value('SECTION','Обувки');  
$tpl->set_value('ITEMLIST',$items_list); 
$tpl->set_value('PRICEFILTER',$price_filter); 
$tpl->set_value('PAGES',$pages); 
$tpl->set_value('RESET','shoes.php'); 
$tpl->tpl_parse();
echo $tpl->html;


?>