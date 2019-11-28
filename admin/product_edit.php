<?php

include('auth.php');
include('../config.php');
include('../connect.php');
include('library.php');
include('template.php');

$MESSAGES='';

if (!isset($_POST['edit']))
{

    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if ($id == FALSE || $id == NULL) {
        header("HTTP/1.0 404 Not Found");
        die();
    } 

    $res = $conn->query("select * from products where id = $id limit 1");

    if ($res->num_rows > 0) {

        $row = $res->fetch_assoc();
    
        $brandlist = get_brandlist($row['bid']);
    
        $table = "
          <table border=0 width=80%>
          <form action=product_edit.php method=post>
            <input type=hidden name=id value=$id>
            <input type=hidden name=edit value=1>
              <tr>
                <td><label for=\"product\">Product Name</label></td>
                <td><input type=\"text\" class=\"form-control\" id=\"model\"
                      name=model value=\"$row[model]\"></td>
              </tr>
              <tr>        
                <td><label for=\"partnum\">Sku</label></td>
                <td><input type=\"text\" class=\"form-control\" id=\"sku\"
                      name=sku value=\"$row[sku]\">          </td>
              </tr>
              <tr>
                <td><label for=\"product\">Brand</label></td>
                <td>$brandlist</td>
              </tr>
              <tr>
                <td><label for=\"product\">Category</label></td>
                <td><input type=\"text\" class=\"form-control\" id=\"category\"
                      name=category value=\"$row[category]\"></td>
              </tr>              
              <tr>   
                <td><label for=\"qty\">Qty</label></td>
                <td><input type=\"number\" min=1 class=\"form-control\" id=\"qty\"
                    name=qty value=$row[qty]></td>   
              </tr>
              <tr>
                <td><label for=\"price\">Price</label></td>
                <td><input type=\"text\" class=\"form-control\" id=\"price\"
                    name=price value=\"$row[price]\"></td>         
              </tr>
              <tr>
                <td><label for=\"price\">Size</label></td>
                <td><input type=\"text\" class=\"form-control\" id=\"size\"
                    name=size value=\"$row[size]\"></td>         
              </tr>
              <tr>
                <td><label for=\"price\">Info</label></td>
                <td><textarea class=\"form-control\" rows=10 cols=20 name=info>$row[info]</textarea></td>         
              </tr>               
              
              <tr>
              <td colspan=2>
              <button type=\"submit\" class=\"btn btn-success\">Save</button>
              
              </form> 
              </td>
              </tr>
             
              </table>";

    }
    else {
       $MESSAGES = error_alert("Product no exists, ID #$id");
       $table = "";
    }

      $tpl->get_tpl('admin.html');
      $tpl->set_value('PAGENAME','Edit');
      $tpl->set_value('MESSAGES', $MESSAGES);
      $tpl->set_value('MAINTABLE',$table);

      $tpl->tpl_parse();
      echo $tpl->html;

}
else {
  
  $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
  $bid = filter_input(INPUT_POST, 'bid', FILTER_VALIDATE_INT);
  $qty = filter_input(INPUT_POST, 'qty', FILTER_VALIDATE_INT);
  $size = filter_input(INPUT_POST, 'size', FILTER_SANITIZE_MAGIC_QUOTES);
  
  
  $model = filter_input(INPUT_POST, 'model', FILTER_SANITIZE_MAGIC_QUOTES);
  $sku = filter_input(INPUT_POST, 'sku', FILTER_SANITIZE_MAGIC_QUOTES);
  $info = filter_input(INPUT_POST, 'info', FILTER_SANITIZE_MAGIC_QUOTES);
  $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_MAGIC_QUOTES);
  $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_MAGIC_QUOTES);
  
  $q = "update products set bid = $bid, model = \"$model\", sku = \"$sku\", 
         info = \"$info\", qty = $qty, size = \"$size\", 
         category = \"$category\", price = \"$price\" where id = $id limit 1";
         
  //die($q);       
  
  $conn->query($q);
  

  Header('Location: products.php');

}

?>