<?php

include('../config.php');
include('../connect.php');

function get_status($status) {

    switch ($status) {
        case 0: return "New";
        case 1: return "Closed";
        case 2: return "Done";
        default: return "N/D";
    }    

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

function get_brand_name($bid) {

    global $conn;
    if (!is_numeric($bid)) $bid = 0;
    $result = $conn->query("select * from brands where bid = $bid limit 1");
    $brand = $result->fetch_assoc();
    return $brand['bname'];

}

function success_alert($txt) {

return "<div class=\"alert alert-success\">
  <a href=# class=close data-dismiss=alert>&times;</a>
  $txt
</div>";

}

function error_alert($txt) {

return "<div class=\"alert alert-danger\">
  <a href=# class=close data-dismiss=alert>&times;</a>
  $txt
</div>";

}

function info_alert($txt) {

return "<div class=\"alert alert-info\">
  <a href=# class=close data-dismiss=alert>&times;</a>
  $txt
</div>";

}


function get_brandlist($bid=0) {
      global $conn;
      
      // формируем список брендов
      $catlist = '<select class="form-control" name=bid>';
      $q = "select * from brands";
      $res = $conn->query($q);
      $selected='';
      
      while ($row = $res->fetch_assoc()) {
          if ($bid == $row['bid']) $selected = 'selected';
          else $selected = '';
          $catlist = $catlist . "<option $selected value=$row[bid]><b>$row[bname]</b></option>";
    

      }
      $catlist = $catlist . "</select>";
      
      return $catlist;

}