<?php
   ini_set('display_errors', 0);
        require 'vendor/autoload.php';
        include "library/includes/config.php";
         include "library/includes/initialize.php";
 global $sql;
  $_SESSION[user]=$_GET[worker];

 if(isset($_GET[save])){
     $permission=array();  // holds array of permissions
     $user= $_SESSION[user];
     $count=$_POST[counter];
      $child= $_POST[child];
     $parent= $_POST["parent"];
     
      $child_perm=implode(",", $child);
       $parent_perm=implode(",", $parent);
        $a= $child_perm.",".$parent_perm;
      //print_r($a);
       $stmt=$sql->Prepare("UPDATE tbl_modules SET MODULES='$a' WHERE USER_ID='$user'");
      if($sql->Execute($stmt)){
          header("location:viewworkers.php");
      }
     
 }
$query=$sql->prepare("SELECT * FROM tbl_modules AS top JOIN tbl_auth AS auth ON top.USER_ID='$user' ");
			 
  $stmt=$sql->Execute($query);
 echo "<input type='hidden' value='$stmt->RecordCount()' name='counter'/>";
if($stmt->RecordCount() > 0){
  
  
    
       
    
        //creating our table heading
        
         $menu_all=array();
        while($row = $stmt->FetchRow()){
           
            
             $module=$row["MODULES"];
              
             $menu_all=explode(",",$module);
              
             
         
            }
             // print_r($menu_all);
            ?>
<form action="modules.php?save" method="post">
    <?php
             for($i=0;$i < count($menu_all);$i++){
                $a=   $menu_all[$i]; 
               
             $query2 = $sql->prepare("SELECT * FROM tbl_menu WHERE   id='$a' AND parentid='0' ORDER BY id ASC ");
            
              
            $stmt2 = $sql->Execute( $query2 );
            while($row=$stmt2->fetchRow()){
                extract($row);
              echo"  <li class='sub-menu'>";
              ?>
    <input type="checkbox" name="parent[]" value="<?php echo $id ?>"/><?php echo $name ?>
                                 <ul>  
                                 
                        
                      <?php  $query2 = $sql->prepare("SELECT * FROM tbl_menu WHERE parentid='$a' ");
                        $stmt2 = $sql->Execute( $query2 );
 
                    while ($row2 = $stmt2->FetchRow()){
                         extract($row2);
                        echo "
                               
                                    <input type='checkbox' name='child[]' value='$id'/>$name
                                     
                               ";

                    }
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                   
              echo  " </ul></li>";
              
              
              
              
              
              
              
              
              
            }
         }
            
       
            
       
           
}

?>
                                      <button type="submit" class="btn btn-warning">Save permission</button>
</form>