<?php
   
 global $sql;
$query=$sql->prepare("SELECT * FROM tbl_modules AS top JOIN tbl_auth AS auth ON top.USER_ID=auth.ID WHERE auth.ID='$_SESSION[ID]' ");
			 
  $stmt=$sql->Execute($query);
if($stmt->RecordCount() > 0){
  
  
    
       
    
        //creating our table heading
        
         $menu_all=array();
        while($row = $stmt->FetchRow()){
           
            
             $module=$row["MODULES"];
              
             $menu_all=explode(",",$module);
              
             
         
            }
             // print_r($menu_all);
             for($i=0;$i < count($menu_all);$i++){
                $a=   $menu_all[$i]; 
               
             $query2 = $sql->prepare("SELECT * FROM tbl_menu WHERE   id='$a' AND parentid='0' ORDER BY order_  desc ");
            
              
            $stmt2 = $sql->Execute( $query2 );
            while($row=$stmt2->fetchRow()){
                extract($row);
              echo"  <li class='sub-menu'>
                                <a href='#'><i class='md md-layers'></i>{$name}</a><ul>"; 
                                 
                        
                        $query2 = $sql->prepare("SELECT * FROM tbl_menu WHERE parentid='$a' ");
                        $stmt2 = $sql->Execute( $query2 );
 
                    while ($row2 = $stmt2->FetchRow()){
                         extract($row2);
                        echo "
                               
                                    <li><a href='{$link}.php'>$name</a></li>
                                     
                               ";

                    }
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                   
              echo  " </ul></li>";
              
              
              
              
              
              
              
              
              
            }
         }
            
       
            
       
           
}
?>
 