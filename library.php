<?php

include('config.php');
include('connect.php');

function get_cart_sum() {

   if (isset($_SESSION['cart'])) { 
    //$cart = unserialize($_SESSION[cart]); 
    $sum = $_SESSION['sum']; 
   }
   else 
       $sum = 0;
       
   return $sum;
    
}

function get_cart_num_items() {

   if (isset($_SESSION['cart'])) { 
    $cart = unserialize($_SESSION['cart']); 
    $c = count($cart);
    //$sum = $_SESSION[sum]; 
   }
   else 
       $c = 0;
       
   return $c;    

}

// returns a brand list and qty of each brand
function get_brands($category) {
   global $conn;

   $brand_list = '';

   $sql = "select * from brands order by bname asc";
   $result = $conn->query($sql);
   
   while ($brand = $result->fetch_assoc()) {
     $bname = $brand['bname'];
     $bid = $brand['bid'];
     
     $sql_qty = "select * from products where (bid = $bid) and (category=\"$category\")";
    
     $res = $conn->query($sql_qty);
     $qty = $res->num_rows;
     if ($res->num_rows > 0)
     $brand_list .= "<li class=\"cat-item cat-item-42\"><a href=\"?brand=$bid\">$bname</a> 
                      <span class=\"count\">($qty)</span></li>";
   }

   return $brand_list;
}

function get_brand_name($bid) {

    global $conn;
    if (!is_numeric($bid)) $bid = 0;
    $result = $conn->query("select * from brands where bid = $bid limit 1");
    $brand = $result->fetch_assoc();
    
    return $brand['bname'];

}

function get_product_name($id) {

    global $conn;
    $q = "select * from products where id = $id limit 1";
    if (!is_numeric($id)) $id = 0;
    //echo $q;
    $result = $conn->query($q);
    $product = $result->fetch_assoc();
    if ($result->num_rows > 0)
       return $product['model'];
    else
       return "Not found";   

}

function get_product_price($id) {

    global $conn;
    $q = "select * from products where id = $id limit 1";
    if (!is_numeric($id)) $id = 0;
    //echo $q;
    $result = $conn->query($q);
    $product = $result->fetch_assoc();
    if ($result->num_rows > 0)
       return $product['price'];
    else
       return "Not found";   

}


function get_delivery() {
     return 5;
}

// bid = ID of brand, sortby - string with field name, n = num of items on the page, $page = num of page
function get_items_list($category, $bid, $sortby, $page = 0, $n = 6, $maxprice = 0) {

    global $conn;
    $item_list = '';
    $minprice = 0;

    $records = ($page-1) * $n;
    if ($records < 0) $records = 0;

    if (!is_numeric($bid)) $bid = 0;

       if ($bid == 0)
       $q = "select * from products where category = \"$category\" order by $sortby limit $records, $n";
       else
       $q = "select * from products where (category = \"$category\") and (bid = $bid) order by $sortby limit $records, $n"; 
    
    if ($maxprice > 0) 
    {
       $minprice = $maxprice - 200;
       $q = "select * from products where (category = \"$category\") and (price >= $minprice) and (price < $maxprice) order by $sortby"; 
    }      
       
    $class = "";
    $row = 0;
    $pivot = $n / 2;

    $result = $conn->query($q);
    
    while ($product = $result->fetch_assoc()) {
      
      $row++;
      if ($row % $pivot == 0) 
          $class = "last simpleCart_shelfItem";
      else 
          $class = "simpleCart_shelfItem";
          
       $brand = get_brand_name($product['bid']);
       
       $image = "products/" . $product['id'] . "/1.jpg";   
    
      $item_list .= "<li class=\"$class\">
  <a class=\"cbp-vm-image\" href=\"product.php?id=$product[id]\">
     <div class=\"view view-first\">
	     <div class=\"inner_content clearfix\">
	       <div class=\"product_image\">
	         <div class=\"mask1\"><img src=\"$image\" alt=\"$product[model]\" class=\"img-responsive zoom-img\"></div>
		       <div class=\"mask\">
	           <div class=\"info\">ПРЕГЛЕДАЙ</div>
	         </div>
		       <div class=\"product_container\">
			       <h4>$product[model]</h4>
				     <p>$brand</p>
				     <div class=\"price mount item_price\">$product[price] лв.</div>
				      <a class=\"button item_add cbp-vm-icon cbp-vm-add\" href=\"cart_add.php?id=$product[id]\">Добави в количката</a>
	       </div>		
	     </div>
     </div>
      </div>
  </a>
</li>";
    }
    
    if ($result->num_rows == 0) $item_list = '<li>No products found. Please select another brand/price or press <b>Reset filters</b> button</li> ';

   return $item_list;

}

function get_price_filter($j) {

    $res = '';
    for ($i = 1; $i <= $j; $i++) {
      $price = $i * 200;
      $min = $price - 200;
      $res .= "<li class=\"cat-item cat-item-42\"><a href=\"?price=$price\">$min - $price</a></li>";
    
    }
    
    return $res;

}

function get_product_qty_by_category($category) {

    global $conn;
    $res = $conn->query("select * from products where category = \"$category\"");
    return $res->num_rows;
}

function get_brand_qty_by_category($bid, $category) {

    global $conn;
    $res = $conn->query("select * from products where category = \"$category\" and bid = $bid");
    
    return $res->num_rows;
}

function get_pagination($qty, $num) {

    $pages = '';
    $maxpages = 1;

    if ($qty % $num == 0)
       $maxpages = $qty / $num;
    else 
       $maxpages = ($qty / $num) + 1;
    
    if ($maxpages < 0) $pages = '<li class="active"><a href="#">1</a></li>';
    else  {
        for ($j = 1; $j <= $maxpages; $j++)
        {   
            $pages = $pages . "<li><a href=\"?page=$j\">$j</a></li>";
         }   

    }  
    return $pages;
}

function get_rand_products($qty) {

    global $conn;
    $other = '';
    $sql = "select * from products order by rand() limit $qty";
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
    
    return $other;

}

?>