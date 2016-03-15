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
        $help=new classes\helpers();
        $notify=new classes\Notifications();
         $app->gethead();
	 if(isset($_GET[add])==1){
	   $name= $_POST[subject];
	   $teacher= $_POST[teacher];
	   $classes=$_POST[classes];
	  if($name=="SELECT SUBJECT" or $teacher=="SELECT TEACHER"  or $classes=="Choose Class"  ){echo"<script>alert('ERROR !!! PLEASE FILL ALL FILEDS') </script>";} else {
	  
	  $sd=$sql->Prepare("select * from tbl_courses where name='$name' and classId='$classes'");
	  $s1d=$sql->Execute($sd);
	  if(count($sd1->FetchRow)==0){
	  
	   $stmt =$sql->Prepare("INSERT INTO tbl_courses VALUES ('','$name','$teacher','$classes','$school->YEAR','$school->TERM','','')");
	   $result=$sql->Execute($stmt);
	   if ($result){header("location:assign_teachers.php?success=1");
	   
	   } 

       }
	  else{
		 $sql->Prepare("update tbl_courses set teacherId='$teacher' where name='$name' and classId='$classes'");
		 $sql->Execute($sql);
		  
		if ($result)  {header("location:assign_teachers.php?success=1");
		
		   
		}
	    
		}
	  
	  }
	  }
 ?>
 <link href="vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
 <script src="js/jquery.js"></script>
 <script src="js/jquery_003.js"></script>
  <script type="text/javascript">
 function getSubject(str)
{
if (str=="")
  {
  document.getElementById("subject").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("subject").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getSubject.php?ID="+str,true);
xmlhttp.send();
}

</script>
  
 
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
                     <div class="modal fade" id="modalWider" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Assign Teachers</h4>
                                        </div>
                                        <div class="modal-body">
                               <form action="assign_teachers.php?add=1" method="POST" class="form-horizontal" role="form">
                                                 <div class="card-body card-padding">
                                                     <div class="form-group">
                                                         <label for="inputEmail3"    class="col-sm-2 control-label">Class</label>
                                                         <div class="col-sm-10">
                                                             <div class="fg-line">
                                                                   <select class=''    required="" name="classes" onChange="getSubject(this.value)">
                                                                     <option value=''>select class</option>
                                                                           
                                                                          <?php 
                                                                    global $sql;
                                                     
                                                                          $query2=$sql->Prepare("SELECT * FROM tbl_classes");
                                                    
                                                    
                                                                          $query=$sql->Execute( $query2);
                                                                         
                                                                       
                                                                       while( $row = $query->FetchRow())
                                                                         {
                                                                           
                                                                         ?>
                                                                         <option value="<?php echo $row['name']; ?>"        ><?php echo $row['name']; ?></option>
                                                    
                                                                   <?php }?>
                                                                            </select>
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="form-group">
                                                         <label for="inputPassword3" class="col-sm-2 control-label">Subject</label>
                                                         <div class="col-sm-10">

                                                             <div class="fg-line">
                                                                 <select class='form-control'   id='subject'   name="subject"  >
                                                                     <option value=''>select subject</option>
                                                                           
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
                                                                      </select>
                                                             </div>
                                                         </div>
                                                     </div>
                                                      <div class="form-group">
                                                         <label for="inputPassword3" class="col-sm-2 control-label">Teacher</label>
                                                         <div class="col-sm-10">

                                                             <div class="fg-line">
                                                            <select class=''    required="" name="teacher" >
                                                                     <option value=''>select teacher</option>
                                                                           
                                                                          <?php 
                                                                    global $sql;
                                                     
                                                                          $query2=$sql->Prepare("SELECT * FROM tbl_workers WHERE designation='Teacher'");
                                                    
                                                    
                                                                          $query=$sql->Execute( $query2);
                                                                         
                                                                       
                                                                       while( $rt = $query->FetchRow())
                                                                         {
                                                                           
                                                                         ?>
                                                                         <option value="<?php echo $rt['emp_number']; ?>"        ><?php   echo $rt[title]." ". $rt[surname]." ".$rt[Name]; ?></option>
                                                    
                                                                   <?php }?>
                                                                            </select>
                                                             </div>
                                                         </div>
                                                     </div>
                                                      
                                                 </div>
                                             
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-link">Save changes</button>
                                            <button type="reset" class="btn btn-link" data-dismiss="modal">Close</button>
                                        </div>
                                   </form>
                                    </div>
                                </div>
                            </div>
                    <div class="card">
                        
                        <div class="card-header">
                           <p>
							Assign Subject Teachers here
                            </p>
                          <div style="margin-top:-3%;float:right">
                                  <button data-toggle="modal" href="#modalWider" class="btn bgm-pink waves-effect">Assign new teacher</button>
                                 <button   class="btn btn-primary waves-effect waves-button dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                                        <ul class="dropdown-menu">
                                            
                                            <li><a href="#" onClick ="$('#data-table-command').tableExport({type:'csv',escape:'false'});"><img src='img/icons/csv.png' width="24"/> CSV</a></li>
                                            <li><a href="#" onClick ="$('#data-table-command').tableExport({type:'txt',escape:'false'});"><img src='img/icons/txt.png' width="24"/> TXT</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#" onClick ="$('#data-table-command').tableExport({type:'excel',escape:'false'});"><img src='img/icons/xls.png' width="24"/> XLS</a></li>
                                            <li><a href="#" onClick ="$('#data-table-command').tableExport({type:'doc',escape:'false'});"><img src='img/icons/word.png' width="24"/> Word</a></li>
                                            <li><a href="#" onClick ="$('#data-table-command').tableExport({type:'powerpoint',escape:'false'});"><img src='img/icons/ppt.png' width="24"/> PowerPoint</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#" onClick ="$('#data-table-command').tableExport({type:'png',escape:'false'});"><img src='img/icons/png.png' width="24"/> PNG</a></li>
                                            <li><a href="#" onClick ="$('#data-table-command').tableExport({type:'pdf',escape:'false'});"><img src='img/icons/pdf.png' width="24"/> PDF</a></li>
                                        </ul>
                            </div>
                        </div>
                        <div class="row">
                           

                <table  width=" " border="0">
                    <tr>

                         <td>&nbsp;</td>
                         <td>&nbsp;</td>
                          <td>&nbsp;</td>
                           <td>&nbsp;</td>
                            <td>&nbsp;</td>
                             <td>&nbsp;</td>
                <td width="25%">
                 <select class='form-control'   id='status' onChange="document.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?class='+escape(this.value);"   style="margin-left:14%;width:150px">
                 <option value=''>Filter by class</option>
                  	  <option value='all'>All</option>
                      <?php 
                global $sql;
 
                      $query2=$sql->Prepare("SELECT * FROM tbl_classes");


                      $query=$sql->Execute( $query2);
                     
                   
                   while( $row = $query->FetchRow())
                     {
                       
                     ?>
                     <option value="<?php echo $row['name']; ?>"        ><?php echo $row['name']; ?></option>

               <?php }?>
                        </select>
      
            </td>
            

                      
               <td>&nbsp;</td>
                <td width="25%">
                <select class='form-control'  name='year'  style="margin-left:2%; width:190px "  >
                  <option value=''>Filter subject</option>
                  	  <option value='all'>All</option>
                      <?php 
                global $sql;
 
                      $query2=$sql->Prepare("SELECT DISTINCT name FROM tbl_courses");


                      $query=$sql->Execute( $query2);
                     
                   
                   while( $row = $query->FetchRow())
                     {
                       
                     ?>
                     <option value="<?php echo $row['name']; ?>"        ><?php echo $row['name']; ?></option>

               <?php }?>
                        </select>
      
            </td>
            
            
        <td>&nbsp;</td>
         <td width="20% ">

                        <select class='form-control'    id='status' style="margin-left:% ;width:150px" onchange="document.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?worker='+escape(this.value);">
                            <option value=''>Filter by worker</option>
                  	  <option value='all'>All</option>
                      <?php 
                    global $sql;
 
                      $query2=$sql->Prepare("SELECT * FROM tbl_workers WHERE designation='Teacher'");


                      $query=$sql->Execute( $query2);
                     
                   
                   while( $row = $query->FetchRow())
                     {
                       
                     ?>
                     <option value="<?php echo $row['emp_number']; ?>" ><?php echo $row['title']." ".$row['Surname']." ".$row['Name']; ?></option>

               <?php }?>
                        </select>

                    </td>
                       <td width="30%">

            <select class='form-control'  name='year'  style="  " onchange="document.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?year='+escape(this.value);" >
                             <option value=''>Filter by academic year</option>
                            <option value='all'>All</option>
                  	         <?php
							 	for($i=2008; $i<=date("Y"); $i++){
									$a=$i - 1 ."/". $i;
										echo "<option value='$a'>$a</option>";
									
									}
							 
							 
							 ?>
                
                        </select>

         </td>
                    <td>&nbsp;</td>
               
        <td width="20%">

            <select class='form-control'     onchange="document.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?term='+escape(this.value);" >
                             <option value=''>Filter by term</option>
                            <option value='all'>All</option>
                  	        <option value='1'>1</option>
                      		<option value='2'>2</option>
                            <option value='3'>3</option>
                
                        </select>

         </td>
       
         
    </tr>  
</table>
 
 
<p>&nbsp;</p>
            </div><!--end .row -->
             
             <?php 
              
                  if(isset($_GET['subject'])){
                 if($_GET['subject']=="all"){
                     $end_query="";
                       }
                 else{ $end_query="WHERE name='$_GET[subject]'   ";}
                  }
                  elseif(isset($_GET['position'])){
                 if($_GET['position']=="all"){
                     $end_query="";
                       }
                 else{ $end_query="WHERE position='$_GET[position]'   ";}
                  }
                  
                  elseif(isset($_GET['class'])){
                 if($_GET['class']=="all"){
                     $end_query="";
                       }
                 else{ $end_query="WHERE classId='$_GET[class]'   ";}
                  }
				   elseif(isset($_GET['term'])){
                 if($_GET['term']=="all"){
                     $end_query="";
                       }
                 else{ $end_query="WHERE term='$_GET[term]'   ";}
                  }
                  
                  elseif(isset($_GET['worker'])){
                 if($_GET['worker']=="all"){
                     $end_query="";
                       }
                 else{ $end_query="WHERE teacherId='$_GET[worker]'   ";}
                  }
				  elseif(isset($_GET['year'])){
                 if($_GET['year']=="year"){
                     $end_query="";
                       }
                 else{ $end_query="WHERE year LIKE '%$_GET[year]%'   ";}
                  }
                   
                  
				  $_SESSION[last_query]=  $query= $sql->Prepare( "SELECT * FROM `tbl_courses` $end_query ");
                                               
								 $rs = $sql->PageExecute($query,RECORDS_BY_PAGE,CURRENT_PAGE);
                                                      $recordsFound = $rs->_maxRecordCount;    // total record found
                                                     if (!$rs->EOF) 
                                                     {
             ?>
            <p style="color:green"><center>Filter by (<?php echo $end_query;?>) Total records = <?php echo $total; ?></center></p>
                    <div class="table-responsive">
            <table   class="table table-striped table-vmiddle table-hover" >
                            <thead>
                                <tr>
                                    <th data-column-id="kk" data-type="numeric">No</th>
                                     <th data-column-id="Subject" data-type=" ">Subject</th>
                                    <th style="text-align:center" data-type="string" data-column-id="Class" style="text-align:center">Class</th>
                                    <th data-column-id="Teacher">Teacher</th>
                                    <th data-column-id="Academic Year" data-order="asc" style="text-align:center">Academic Year</th>
                                    <th data-column-id="Term" style="text-align:center">Term</th>
                                    
                                    <th data-column-id="No of Students" data-order="asc" style="text-align:center">No of Students</th>
                                     
                                    <th data-column-id="link" data-formatter="link" data-sortable="false"> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count=0;
                                    while($rt=$rs->FetchRow()){
                                                            $count++;
                                       ?>
                                      <tr>
                                    <td><?php  echo $count; ?></td>
                                     <td><?php  echo $rt[name]; ?></td>
                                     
                                    <td style="text-align:center"><?php  echo $rt[classId]; ?></td>
                                    <td><?php  $teacher=new classes\Teacher(); $teacher=$teacher->getTeacher($rt[teacherId]);  echo $teacher->NAME." " .$teacher->SURNAME; ?></td>
                                    <td style="text-align:center"><?php  echo $rt[year] ?></td>
                                    <td style="text-align:center"><?php  echo $rt[term] ?></td>
                                    <td style="text-align:center"><?php  echo $student->getTotalStudent_by_Class($rt[classId]); ?></td>
                                    
                                
                                
                                     </tr>
                                    <?php } ?>
                            </tbody>
                         </table>
                    
                    <center><?php
                     
                         $GenericEasyPagination->setTotalRecords($recordsFound);
	  
                        echo $GenericEasyPagination->getNavigation();
                        echo "<br>";
                        echo $GenericEasyPagination->getCurrentPages();
                      ?></center>
                    </div>
                                    <?php }else{
                  echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                Oh snap! Something went wrong. No record to display! Please upload students data
                            </div>";
             }?>
                    </div>
                </div>
                </div>
                     
                    
                    
                </div>
            </section>
        </section>
        
         
        <?php  $app->getDashboardScript() ; $app->getuploadScript(); ?>
      
        <?php $app->exportScript() ?>
    </body>
  
</html>
