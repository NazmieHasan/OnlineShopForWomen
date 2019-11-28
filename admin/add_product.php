<?php

include('auth.php');
include('../config.php');
include('../connect.php');
include('library.php');
include('template.php');

$MESSAGES='';

if (!isset($_POST['new'])) {
//view form
 $brandlist = get_brandlist(0);
 $table = "
          <table border=0 width=80%>
          <form action=add_product.php method=post>
              <input type=hidden name=new value=1>
              <tr>
                <td><label for=\"product\">Product Name</label></td>
                <td><input type=\"text\" class=\"form-control\" id=\"model\"
                      name=model></td>
              </tr>
              <tr>        
                <td><label for=\"partnum\">Sku</label></td>
                <td><input type=\"text\" class=\"form-control\" id=\"sku\"
                      name=sku></td>
              </tr>
              <tr>
                <td><label for=\"product\">Brand</label></td>
                <td>$brandlist</td>
              </tr>
              <tr>
                <td><label for=\"product\">Category</label></td>
                <td><select name=category><option value=\"clothes\">clothes</option>
                   <option value=\"shoes\">shoes</option>
                   <option value=\"accessories\">accessories</option>
                   </select></td>
              </tr>              
              <tr>   
                <td><label for=\"qty\">Qty</label></td>
                <td><input type=\"number\" min=1 class=\"form-control\" id=\"qty\"
                    name=qty></td>   
              </tr>
              <tr>
                <td><label for=\"price\">Price</label></td>
                <td><input type=\"text\" class=\"form-control\" id=\"price\"
                    name=price></td>         
              </tr>
              <tr>
                <td><label for=\"size\">Size</label></td>
                <td><input type=\"text\" class=\"form-control\" id=\"size\"
                    name=size></td>         
              </tr>
              <tr>
                <td><label for=\"info\">Info</label></td>
                <td><textarea class=\"form-control\" rows=10 cols=20 name=info></textarea></td>         
              </tr>               
              <tr>
              <td colspan=2>
              <button type=\"submit\" class=\"btn btn-success\">Save</button>
              
              </form> 
              </td>
              </tr>
             
              </table>";
              
              $tpl->get_tpl('admin.html');
              $tpl->set_value('PAGENAME',"New product");          
              $tpl->set_value('MESSAGES','');      
              $tpl->set_value('MAINTABLE',$table);
              $tpl->tpl_parse();
              echo $tpl->html;
}
else {
// insert

  $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
  $bid = filter_input(INPUT_POST, 'bid', FILTER_VALIDATE_INT);
  $qty = filter_input(INPUT_POST, 'qty', FILTER_VALIDATE_INT);
  $size = filter_input(INPUT_POST, 'size', FILTER_SANITIZE_MAGIC_QUOTES);
  
  
  $model = filter_input(INPUT_POST, 'model', FILTER_SANITIZE_MAGIC_QUOTES);
  $sku = filter_input(INPUT_POST, 'sku', FILTER_SANITIZE_MAGIC_QUOTES);
  $info = filter_input(INPUT_POST, 'info', FILTER_SANITIZE_MAGIC_QUOTES);
  $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_MAGIC_QUOTES);
  $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_MAGIC_QUOTES);
  $date_added=date('Y-m-d H-i-s');

    $q = "insert into products values(0, \"$sku\", $bid, \"$category\", \"$model\", \"$info\", \"$size\", $qty, \"$price\", \"$date_added\")";
    
   // echo $q;
   $conn->query($q);
   
   Header('Location: products.php?new=ok');
    

}

?>