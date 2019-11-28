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
          <form action=brand_add.php method=post>
              <input type=hidden name=new value=1>
              <tr>
                <td><label for=\"product\">Brand Name</label></td>
                <td><input type=\"text\" class=\"form-control\" id=\"bname\"
                      name=bname></td>
              </tr>
             
              <tr>
                <td>&nbsp</td>
                <td></td>         
              </tr>               
              
              <tr>
              <td colspan=2>
              <button type=\"submit\" class=\"btn btn-success\">Save</button>
              
              </form> 
              </td>
              </tr>
             
              </table>";
              
              $tpl->get_tpl('admin.html');
              $tpl->set_value('PAGENAME',"New brand");          
              $tpl->set_value('MESSAGES','');      
              $tpl->set_value('MAINTABLE',$table);
              $tpl->tpl_parse();
              echo $tpl->html;
}
else {
// insert

  
  
    $bname = filter_input(INPUT_POST, 'bname', FILTER_SANITIZE_MAGIC_QUOTES);

    $q = "insert into brands values(0, \"$bname\")";
    
   // echo $q;
   $conn->query($q);
   
   Header('Location: brands.php?new=ok');
    

}

?>