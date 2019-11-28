<?php

session_name('store');
session_start();

include('config.php');
include('connect.php');
include('template.php');
include('library.php');

$rel_N = 4;     // qty of related products

$tpl->get_tpl('templates/product.html');

$sum = get_cart_sum();                    // total sum of cart
$items = get_cart_num_items();            // num of items

$id= filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id == FALSE || $id == NULL) $id = 1;

$q = "select * from products where id = $id limit 1";
$res = $conn->query($q);

if ($res->num_rows > 0) {

    $product = $res->fetch_assoc();
    $model = $product['model'];
    $qty = $product['qty'];
    
    if ($qty > 0) 
        $aval = 'Да';
    else 
        $aval = 'Изчерпан';
    
    $price = $product['price'];
    $size = "<li><a href=#>$product[size]</a></li>";
    
    $searchString = $product['info'];
    $findString = '.';
    $position =strpos($searchString, $findString);
    $overview = strip_tags(substr($product['info'], 0, $position));
    $overview = $overview.'.';
    
    $descr = $product['info'];
    
    $slides = '';
    for ($i = 1; $i <=4; $i++) {
    
       $image = "products/$id/$i.jpg";
       if (file_exists($image)) 
           $slides .= "<li data-thumb=\"$image\">
							<img src=\"$image\" />
						</li>";
    
    }
    
    $other = '';
    $sql = "select * from products order by rand() limit $rel_N";
    $res2 = $conn->query($sql);
    
    while ($related = $res2->fetch_assoc()) {
       $rid = $related['id'];
       
      $other .= "		
      <ul class=\"product\">
	      	<li class=\"product_img\"><img src=\"products/" . $rid . "/1.jpg\" class=\"img-responsive\" /></li>
	      	<li class=\"product_desc\">
	      	<h4><a href=\"product.php?id=$rid\">$related[model]</a></h4>
	      	<p class=\"single_price\">$related[price] лв.</p>
	        	<a href=\"cart_add.php?id=$rid\" class=\"link-cart\">Добави в количката</a>
	        </li>
	      	<div class=\"clearfix\"> </div>
	      </ul>"; 
  
    }
   

}
else die('DB error');


$tpl->set_value('TITLE',$model);          
$tpl->set_value('SUM',$sum);      
$tpl->set_value('ITEMS',$items);    

$tpl->set_value('MODEL',$model);   
$tpl->set_value('ID',$id);  
$tpl->set_value('OVERVIEW',$overview);  
$tpl->set_value('SLIDES',$slides);  
$tpl->set_value('PRICE',$price);
$tpl->set_value('DESCR',$descr);   
$tpl->set_value('INFOLIST','Няма допълнителна информация');   
$tpl->set_value('OVERVIEW',$overview);   
$tpl->set_value('AVAL',$aval);   
$tpl->set_value('SIZE',$size);   

$tpl->set_value('OTHER',$other);  

$tpl->tpl_parse();
echo $tpl->html;


?>
