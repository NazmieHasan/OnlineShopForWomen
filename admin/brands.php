<?php

include('auth.php');
include('../config.php');
include('../connect.php');
include('library.php');
include('template.php');

$tpl->get_tpl('admin.html');

$MESSAGES = '';

// last 5 new (status = 0) orders
$res = $conn->query("select * from brands");

$table = '
<table class="table table-striped">
   <thead class="thead-inverse">
      <tr>
          <th>#</th>
          <th>Brand</th>
          <th>Actions</th>
      </tr>
   </thead>
   <tbody>
';

while ($brand = $res->fetch_assoc())
{
     
   $table .= "<tr>
                <td>$brand[bid]</td>
                <td>$brand[bname]</td>
                <td><a href=brand_edit.php?id=$brand[bid]>Edit</a> | 
                    <a href=brand_delete.php?id=$brand[bid] onClick=\"return window.confirm('Are you sure?');\">Delete</a></td>
              </tr>";
}

$table .= "</table>";


if (isset($_GET['new'])) $MESSAGES .= success_alert('A new brand was added');

$tpl->set_value('PAGENAME',"Brands");          
$tpl->set_value('MESSAGES',$MESSAGES);      
$tpl->set_value('MAINTABLE',$table);

$tpl->tpl_parse();
echo $tpl->html;

?>