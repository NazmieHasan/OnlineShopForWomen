<?php

include('auth.php');
include('../config.php');
include('../connect.php');
include('library.php');
include('template.php');

$MESSAGES ='';

if (!isset($_POST['edit']))
{

    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if ($id == FALSE || $id == NULL) {
        header("HTTP/1.0 404 Not Found");
        die();
    } 

    $res = $conn->query("select * from brands where bid = $id limit 1");

    if ($res->num_rows > 0) {

        $row = $res->fetch_assoc();
    
        $table = "
          <table border=0 width=80%>
          <form action=brand_edit.php method=post>
            <input type=hidden name=id value=$id>
            <input type=hidden name=edit value=1>
              <tr>
                <td><label for=\"product\"Brand Name</label></td>
                <td><input type=\"text\" class=\"form-control\" id=\"bname\"
                      name=bname value=\"$row[bname]\"></td>
              </tr>
              <tr>
                <td colspan=2>&nbsp</td>

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
       $MESSAGES = error_alert("Brand no exists, ID #$id");
       $table = "";
    }

      $tpl->get_tpl('admin.html');
      $tpl->set_value('PAGENAME','Edit brand');
      $tpl->set_value('MESSAGES', $MESSAGES);
      $tpl->set_value('MAINTABLE',$table);

      $tpl->tpl_parse();
      echo $tpl->html;

}
else {
  
  $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
  $bname = filter_input(INPUT_POST, 'bname', FILTER_SANITIZE_MAGIC_QUOTES);

  
  $q = "update brands set bname = \"$bname\" where bid = $id limit 1";
         
  //die($q);       
  
  $conn->query($q);
  

  Header('Location: brands.php');

}

?>