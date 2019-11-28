<?php

session_name('store');
session_start();

include('config.php');
include('connect.php');
include('template.php');
include('library.php');

$rel_N = 4;     // qty of related products

$tpl->get_tpl('templates/brands.html');

$sum = get_cart_sum();                    // total sum of cart
$items = get_cart_num_items();            // num of items


$brands = '<table class=table>';

$q = "select * from brands order by bname asc";
$res = $conn->query($q);
$nbrands = $res->num_rows;

while ($brand = $res->fetch_assoc()) {

$clothes_qty = get_brand_qty_by_category($brand['bid'], 'clothes');
if ($clothes_qty > 0)
$brands .= "<tr>
            <td>$brand[bname]</td>
            <td><a href=clothes.php?brand=$brand[bid]>Разгледай подробно тук</a></td>
            </tr>";  
            
$shoes_qty = get_brand_qty_by_category($brand['bid'], 'shoes');
if ($shoes_qty > 0)
$brands .= "<tr>
            <td>$brand[bname]</td>
            <td><a href=shoes.php?brand=$brand[bid]>Разгледай подробно тук</a></td>
            </tr>";  
            
$accessories_qty = get_brand_qty_by_category($brand['bid'], 'accessories');
if ($accessories_qty > 0)
$brands .= "<tr>
            <td>$brand[bname]</td>
            <td><a href=accessories.php?brand=$brand[bid]>Разгледай подробно тук</a></td>
            </tr>";                   
}

$brands .= "</table>";

$related = get_rand_products($rel_N);


$tpl->set_value('TITLE', $title=$title.' Браншове');  
$tpl->set_value('SUM',$sum);  
$tpl->set_value('ITEMS',$items);  
$tpl->set_value('NBRANDS',$nbrands);  
$tpl->set_value('BRANDS',$brands); 
$tpl->set_value('RELATED',$related); 

$tpl->tpl_parse();
echo $tpl->html;

?>