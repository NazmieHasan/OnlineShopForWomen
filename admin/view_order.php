<?php

include('auth.php');
include('../config.php');
include('../connect.php');
include('library.php');
include('template.php');

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id == FALSE || $id == NULL) {
    header("HTTP/1.0 404 Not Found");
    die();
    }

$pid = $id;

$res = $conn->query("select * from orders where id = $id limit 1");
$order = $res->fetch_assoc();

$status = get_status($order['status']);

$table = "
<p><strong>Client Name:</strong> $order[name]
<p><strong>Client Family:</strong> $order[family]
<p><strong>Client Phone:</strong> $order[phone]
<p><strong>Client Address:</strong> $order[adr]
<p><strong>Date:</strong> $order[dt]
<p><strong>Total sum:</strong> $order[osum]
<p><strong>Status:</strong> $status

<table class=\"table table-striped\">
   <thead class=\"thead-inverse\">
      <tr>
          <th>#</th>
          <th>Model</th>
          <th>Qty</th>
          <th>Price</th>
      </tr>
   </thead>
   <tbody>
";

$cart = unserialize($order['items']);

foreach ($cart as $id => $qty) {
 $product_name = get_product_name($id);
 $product_price = get_product_price($id);
 $table .= "<tr><td>$id</td>
                <td>$product_name</td>
                <td>$qty</td>
                <td>$product_price</td>
            </tr>";    
}

$table .= "</table>

<p><a href=change_status.php?id=$pid&code=2><button class=\"btn btn-success\">Done!</button></a>
   <a href=change_status.php?id=$pid&code=1><button class=\"btn btn-danger\" >Close</button></a>";

$tpl->get_tpl('admin.html');
$tpl->set_value('PAGENAME',"Order #$pid");          
$tpl->set_value('MESSAGES','');      
$tpl->set_value('MAINTABLE',$table);

$tpl->tpl_parse();
echo $tpl->html;
?>