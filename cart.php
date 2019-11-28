<?php

session_name('store');
session_start();

include('config.php');
include('template.php');
include('library.php');

$cart_items = "<h1>Няма продукти в количката</h1>";

if (isset($_SESSION['cart'])) { 
    $cart = unserialize($_SESSION['cart']);
    $cart_items  = '';
    
    foreach ($cart as $id => $qty) {
    
        $product_name = get_product_name($id);
        $image = "products/$id/1.jpg";
        
        $cart_items  .= "			 <div class=\"cart-header\">
				 <a href=cart_delete.php?id=$id><div class=\"close1\"> </div></a>
				   <div class=\"cart-sec simpleCart_shelfItem\">
						<div class=\"cart-item cyc\">
							 <img src=\"$image\" class=\"img-responsive\" alt=\"product_name\"/>
						</div>
					   <div class=\"cart-item-info\">
						<h3><a href=\"product.php?id=$id\">$product_name</h3>
						<ul class=\"qty\">
							
							<li><p>Количество : $qty</p></li>
						</ul>
						<div class=\"delivery\">
							 <p>Service Charges : Rs.100.00</p>
							 <span>Доставка в рамките на 3 работни дни</span>
							 <div class=\"clearfix\"></div>
				        </div>	
					   </div>
					   <div class=\"clearfix\"></div>
				    </div>
			 </div>";
    
    }
}

$delivery = get_delivery();

$sum = get_cart_sum();                    // total sum of cart
$items = get_cart_num_items();            // num of items

$total2 = $sum + $delivery;

$tpl->get_tpl('templates/checkout.html');

$tpl->set_value('TITLE', $title=$title.' Продукти в количката');          
$tpl->set_value('SUM',$sum);      
$tpl->set_value('ITEMS',$items);  
$tpl->set_value('CARTITEMS',$cart_items);
$tpl->set_value('TOTAL1',$sum);
$tpl->set_value('TOTAL2',$total2);
$tpl->set_value('DELIVERY',$delivery);

$tpl->tpl_parse();
echo $tpl->html;



?>