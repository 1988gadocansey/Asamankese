 <?php
 ini_set('display_errors', 0);
    require 'vendor/autoload.php';
    include "library/includes/config.php";
     include "library/includes/initialize.php";
     	 $help=new classes\helpers();
		 $school=new classes\School();
		 $school=$school->getAcademicYearTerm();
	 	 $student=new classes\Student();
       	   
          $app=new classes\structure();
        
          $notify=new classes\Notifications();
           $app->gethead();
	   if(isset($_GET[sub])){
		    
		  $counter=$_POST["counter"];
		   $class=$_POST["class"];
		   $teacher=$_POST["teacher"];
		  for($i=1;$i<=$counter;$i++){
			  
		  
		   $classes=$class[$i];
		   $teachers=$teacher[$i];
		  if($teachers=="" && $classes=""){}else{
		  $a=$sql->Prepare("update tbl_classes set teacherId='$teachers' ,term='$school->TERM' , year='$school->YEAR' where  name='$classes' ")  ;
		  
		  if($sql->Execute($a)){
			   header("location:class_teacher.php?success=1");
			  
			  }
			  else{
				  
			 	header("location:class_teacher.php?error=1");
				  }
		  
		  
		  }
		  
		  
		  }
		  
		  
		  }
		  
 ?>
 <link href="vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
  
  
 
<body>
      
     <?php  $app->getTopRgion() ?>
        
        <section id="main">
             <?php $app->getMenu(); ?>
            
              <?php $app->getChats(); ?>
            
            
          <section id="content">
                <div class="container">
                    <div class="block-header">
                       <?php $notify->displayMessage();  ?>
                    
                         
                    </div>
               <div class="section-body">
                      
                    <div class="card">
                        
                        <div class="card-header">
                           <p>
							Assign Class Teachers here
                            </p>
                           
                        </div>
                        <div class="row">
                        
                        
                        <div class="table-responsive">
                             
                          <form id="form1" name="form1" method="post" action="class_teacher.php?sub=1">
                          	 <table align="center" style="width:60%" class="table table-bordered table-vmiddle table-hover">
                                        <tr>
                                          <td width="" border="0"></td>
                                          <td width=" " style="text-align:"> Class Name</td>
                                          <td width=" "> Teacher</td>
                                          </tr>
												<?php 
                                    
                                    
                                    
                                            
                                                $query=$sql->Prepare("SELECT * FROM tbl_classes  ");		
                                             
                                            
                                         
                                                $b=$sql->Execute($query);
                                                 
                                                while( $r= $b->FetchRow())
                                                
                                                {
                                                   
                                                ?>
									      <tr>
                                           <td><?php echo $thecounter=$counter++ ?></td>
                                          <td>
										  <?php echo $r[name];?>
                                            <input type="hidden" name="class[]" id="class" value="<?php echo $r[name];?>" />
                                            
                                            </td>
                                             <td> 
                                              <label><strong>
                                              <select   class="form-control"  name="teacher[]" id="teacher">
                                                <option value="" >SELECT CLASS TEACHER</option>
                                                <?php 
                             
                            
                            
													 $query2=$sql->Prepare("SELECT * FROM tbl_workers WHERE designation='Teacher'");
													
													
														$query=$sql->Execute( $query2);                            
																		  
													   while( $row = $query->FetchRow())
															
															{
															?>
														<option value="<?php echo $row[emp_number] ?>" <?php if($row[emp_number]==$r[teacherId]){echo 'selected="selected"';}?>><?php echo $row['title']." ".$row['Surname']." ".$row['Name']; ?></option>
														  <?php }?>
                                                  </select>
                                                </strong></label>
                                            
                                            </td>
                                          </tr>
                                              <?php 
																			  
								            } ?>
										      
                                           
                                             
                                          </table>
                                        
                                          <div class="row"><center>
                                          <input type="hidden" name="counter" value="<?php  echo $counter++;?>" id="upper" />
                                                <input  id="proceed" type="submit" name="Edit" id="Edit" value="UPDATE" class="btn btn-primary btn-large">
                                                <input  id="proceed" type="submit"  name="refresh" id="refresh" value="refresh" class="btn btn-success btn-large">
                                                
                                            </center></div>  <p></p>
                                    </form>
                        </div>
                        
                        </div>
             
                    </div>
                </div>
               
               
                </div>
                     
              
                
            </section>
        </section>
        
         
        <?php  $app->getDashboardScript() ; $app->getuploadScript(); ?>
        <script src="vendors/bootstrap-select/bootstrap-select.min.js"></script>
        <script src="vendors/chosen/chosen.jquery.min.js"></script>

        <script src="vendors/bootgrid/jquery.bootgrid.min.js"></script>
       
      
    </body>
  
</html>
