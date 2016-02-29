<?php
ini_set('display_errors', 0);
    require 'vendor/autoload.php';
    include "library/includes/config.php";
      
  $id=$_GET['ID'];
 
?>

<option value=''>Select Subject</option>
<?php 
																			  
																				  
																				  
																				  
																				  
																				  
								$result2=$sql->Prepare(" SELECT name FROM tbl_subjects  ");
																				  
									$result=$sql->Execute($result2);											  
															$num=0;
											while($row2=$result->FetchRow($result))
																
															{
															$name=$row2[name];
															 
															$num++;
	echo"<option Class='' value='$name' name='group'>$name</option>";
															}
																				  

 ?>
 