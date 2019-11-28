<?php

include('auth.php');
include('../config.php');
include('../connect.php');
include('library.php');
include('template.php');

$tpl->get_tpl('admin.html');

$MESSAGES = '';

// last 5 new (status = 0) orders
$res = $conn->query("select * from products");

$table = '
<table class="table table-striped">
   <thead class="thead-inverse">
      <tr>
          <th>#</th>
          <th>Sku</th>
          <th>Brand</th>
          <th>Category</th>
          <th>Model</th>
          <th>Qty</th>
          <th>Price</th>
          <th>Actions</th>
      </tr>
   </thead>
   <tbody>
';

while ($product = $res->fetch_assoc())
{
   $brand = get_brand_name($product['bid']);
    
   $table .= "<tr>
                <td>$product[id]</td>
                <td>$product[sku]</td>
                <td>$brand</td>
                <td>$product[category]</td>
                <td>$product[model]</td>
                <td>$product[qty]</td>
                <td>$product[price]</td>
                <td><a href=product_edit.php?id=$product[id]>Edit</a> | 
                    <a href=product_delete.php?id=$product[id] onClick=\"return window.confirm('Are you sure?');\">Delete</a></td>
              </tr>";
}

$table .= "</table>";

if (isset($_GET['new'])) $MESSAGES .= success_alert('A new product was added');

$tpl->set_value('PAGENAME',"Products");          
$tpl->set_value('MESSAGES',$MESSAGES);      
$tpl->set_value('MAINTABLE',$table);

$tpl->tpl_parse();
echo $tpl->html;

?>