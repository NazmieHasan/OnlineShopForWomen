<?php

include('auth.php');
include('../config.php');
include('../connect.php');
include('library.php');
include('template.php');

$tpl->get_tpl('admin.html');

// last 5 new (status = 0) orders
if (isset($_GET['filter'])) {
    $filter = filter_input(INPUT_GET, 'filter', FILTER_VALIDATE_INT);
    
    if ($filter == FALSE || $filter == NULL) {
        header("HTTP/1.0 404 Not Found");
        die();
    } 
    
    $res = $conn->query("select * from orders where status = $filter order by id desc");
}
else
    $res = $conn->query("select * from orders order by id desc");

$table = '
<p>Filter: <a href=orders.php>All</a> | <a href=orders.php?filter=2>Done</a> | <a href=orders.php?filter=1>Closed</a>
<table class="table table-striped">
   <thead class="thead-inverse">
      <tr>
          <th>#</th>
          <th>Date</th>
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
                <td>$order[dt]</td>
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


$tpl->set_value('PAGENAME',"Orders");          
$tpl->set_value('MESSAGES','');      
$tpl->set_value('MAINTABLE',$table);

$tpl->tpl_parse();
echo $tpl->html;

?>