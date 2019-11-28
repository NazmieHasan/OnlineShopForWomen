<?php

include('auth.php');
include('../config.php');
include('../connect.php');
include('library.php');
include('template.php');

$tpl->get_tpl('admin.html');

// last 5 new (status = 0) orders
$res = $conn->query("select * from orders where status = 0 order by id desc limit 5");

$table = '
<table class="table table-striped">
   <thead class="thead-inverse">
      <tr>
          <th>#</th>
          <th>Client Name</th>
          <th>Client Family</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Address</th>
          <th>Items</th>
          <th>Status</th>
      </tr>
   </thead>
   <tbody>
';

while ($order = $res->fetch_assoc())
{
   $status = get_status($order['status']);
   
   $table .= "<tr>
                <td>$order[id]</td>
                <td>$order[name]</td>
                <td>$order[family]</td>
                <td>$order[email]</td>
                <td>$order[phone]</td>
                <td>$order[adr]</td>
                <td><a href=view_order.php?id=$order[id]>View</a></td>
                <td>$status</td>
              </tr>";
}

$table .= "</table>";


$tpl->set_value('PAGENAME','Last Orders');          
$tpl->set_value('MESSAGES','');      
$tpl->set_value('MAINTABLE',$table);

$tpl->tpl_parse();
echo $tpl->html;

?>