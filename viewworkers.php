 <?php
 ini_set('display_errors', 0);
    require 'vendor/autoload.php';
    include "library/includes/config.php";
     include "library/includes/initialize.php";
     $help=new classes\helpers();
       
    $app=new classes\structure();
    $help=new classes\helpers();
    $notify=new classes\Notifications();
     $app->gethead();
 ?>
 <link href="vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
 <script src="js/jquery.js"></script>
 <script src="js/jquery_003.js"></script>
  
 <style>
     .container {
    width: 1490px;
}
 </style>
  
 
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
							Generate customised reports   send sms,edit workers data here
                            </p>
                            <div style="margin-top:-3%;float:right">
                                <a href="addworker.php" class="btn bgm-orange waves-effect"> Add Worker<i class="md md-add"></i></a>
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
                           

                <table  width="%" border="0">
                    <tr>

                         <td>&nbsp;</td>
                <td width="25%">
                 <select class='form-control'   id='status' onChange="document.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?class='+escape(this.value);"   style="margin-left:14%;Width:60%">
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
                <select class='form-control'  name='year'  style="margin-left:16%; width:55% " onchange="document.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?designation='+escape(this.value);" >
                            <option value=''>Filter job type</option>
                  	  <option value='all'>All</option>
                      <?php 
                global $sql;
 
                      $query2=$sql->Prepare("SELECT DISTINCT designation FROM tbl_workers");


                      $query=$sql->Execute( $query2);
                     
                   
                   while( $row = $query->FetchRow())
                     {
                       
                     ?>
                     <option value="<?php echo $row['designation']; ?>"        ><?php echo $row['designation']; ?></option>

               <?php }?>
                        </select>
      
            </td>
            
            
        <td>&nbsp;</td>
         <td width="20% ">

                        <select class='form-control'    id='status' style="margin-left: ;Width:70%" onchange="document.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?position='+escape(this.value);">
                            <option value=''>Filter by position</option>
                  	  <option value='all'>All</option>
                      <?php 
                global $sql;
 
                      $query2=$sql->Prepare("SELECT DISTINCT position FROM tbl_workers");


                      $query=$sql->Execute( $query2);
                     
                   
                   while( $row = $query->FetchRow())
                     {
                       
                     ?>
                     <option value="<?php echo $row['position']; ?>"        ><?php echo $row['position']; ?></option>

               <?php }?>
                        </select>

                    </td>
                    <td>&nbsp;</td>
               <td width="20%">
             
             
                     <select  class='form-control' style="margin-left:-14%;Width:80%"   onchange="document.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?grade='+escape(this.value);">
                                             
                         <option value=''>Select grade</option>
                         <option value='all'>All</option>

                         <?php 
                global $sql;
 
                      $query2=$sql->Prepare("SELECT DISTINCT grade FROM tbl_workers");


                      $query=$sql->Execute( $query2);
                     
                   
                   while( $row = $query->FetchRow())
                     {
                       
                     ?>
                     <option value="<?php echo $row['grade']; ?>"        ><?php echo $row['grade']; ?></option>

               <?php }?>
                        </select>

             
        </td>
        <td width="30%">

            <select class='form-control'  name='year'  style="margin-left:-39%;  " onchange="document.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?gender='+escape(this.value);" >
                            <option value=''>Filter gender</option>
                  	        <option value='all'>All</option>
                      		<option value='Male'>Male</option>
                            <option value='Female'>Female</option>
                
                        </select>

                    </td>
         
    </tr>  
</table>
 
 
<p>&nbsp;</p>
            </div><!--end .row -->
            <div class=" ">
                 <div class="panel panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                <center>Send SMS</center>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                        <div class="panel-body">
                                            <form id="form2" name="form2" method="post" action="viewworkers.php?send=1">
                    <label></label>
                    <table width="640" border="0" align="center">
                      <tr>
                        <td colspan="2" bgcolor="#91B7D9">Select teachers to send sms</td>
                      </tr>
                      <tr>
                        <td colspan="2" bgcolor="#2D5982">
                            <select id="unit" class="tag-select" multiple="multiple" data-placeholder="select students to send sms to their parents"  name="students">
                                                         <option value=''>select workers</option>
                                                           
                                                                <?php 
                                                          global $sql;

                                                                $query2=$sql->Prepare("SELECT * FROM tbl_workers");


                                                                $query=$sql->Execute( $query2);


                                                             while( $row = $query->FetchRow())
                                                               {

                                                               ?>
                                                               <option value="<?php echo $row['emp_number']; ?>"     >     <?php echo $row['surname']." - ".$row['Name']; ?></option>

                                                         <?php }?>
                                                          </select>
                            
                          </td>
                      </tr>
                      <tr>
                        <td bgcolor="#91B7D9"><div align="center"><strong>Text Message</strong></div></td>
                        <td valign="top" bgcolor="#91B7D9"><div align="center"><strong>Fields Available</strong></div></td>
                      </tr>
                      <tr>
                        <td width="419" height="110" bgcolor="#2D5982"><div align="center">
                            <textarea name="sms" id="sms" cols="45" rows="5"></textarea>
                        </div></td>
                        <td width="211" valign="top" bgcolor="#2D5982"><div align="center">
                            <script>
						function inse(inco){
						var curr=document.getElementById('sms');
						curr.value=curr.value+"["+inco+"]"
						}
						</script>
                            <select name="select"  ondblclick="inse(this.value)" size="6" id="select">
                              <option value="surname"> Surname</option>
                              <option value="Name">Othernames</option>
                              <option value="position">Position</option>
                              <option value="grade">Grade</option>
                              <option value="empStatus">Employee Status</option>
                               
                                
                            </select>
                        </div></td>
                      </tr>
                      <tr>
                        <td colspan="2"><label>
                            <div align="center">
                                <center>   <input type="submit" class="btn btn-success" name="send" id="send" value="Send Message" /></center>
                            </div>
                          </label></td>
                      </tr>
                    </table>
                    <label> </label>
                    <label></label>
                  </form>
                                            
                                            
                                        </div>
                                    </div>
                                </div>

            </div>
             <?php 
              
                  if(isset($_GET['grade'])){
                 if($_GET['grade']=="all"){
                     $end_query="";
                       }
                 else{ $end_query="WHERE grade='$_GET[grade]'   ";}
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
                 else{ $end_query="WHERE teaches='$_GET[class]'   ";}
                  }
                  
                  elseif(isset($_GET['designation'])){
                 if($_GET['designation']=="all"){
                     $end_query="";
                       }
                 else{ $end_query="WHERE designation='$_GET[designation]'   ";}
                  }
                   elseif(isset($_GET['gender'])){
                 if($_GET['gender']=="all"){
                     $end_query="";
                       }
                 else{ $end_query="WHERE sex='$_GET[gender]'   ";}
                  }                             $_SESSION[last_query]=  $query= $sql->Prepare( "SELECT * FROM tbl_workers $end_query ");
                                                
												$stmt =$sql->Prepare($query);
                                                    $out=$sql->Execute($stmt);
                                                    $total=$out->RecordCount();
                                                    if($out->RecordCount()>0){
             ?>
            <p style="color:green"><center>Filter by (<?php echo $end_query;?>) Total records = <?php echo $total; ?></center></p>
                    <div class="table-responsive">
           <table id="data-table-command" class="table table-striped table-vmiddle" >
                            <thead>
                                <tr>
                                    <th data-column-id="kk" data-type="numeric">No</th>
                                    <th style="text-align:center" data-column-id="link" data-formatter="link">Picture</th>
                                    <th data-column-id="staffId">Staff ID</th>
                                    <th data-column-id="Name" data-order="asc">Name</th>
                                    <th data-column-id="class">Classes</th>
                                    <th data-column-id="Gender" data-order="asc">Gender</th>
                                    <th data-column-id="age" data-order="asc">Age</th>
                                    <th data-column-id="marital status" data-order="asc">Marital Status</th>
                                    <th data-column-id="job type" data-order="asc">Job Type</th>
                                    <th data-column-id="ssnit"   data-type=" ">SSNIT</th>
                                    <th data-column-id="Position"  >Position</th>
                                     
                                    <th data-column-id="address" data-order="asc">Address</th>
                                    <th data-column-id="Hometown">Hometown</th>
                                    <th data-column-id="Place of residence" data-order="asc">Place of residence</th>
                                    <th data-column-id="Email">Email</th>
                                    <th data-column-id="grade">Grade</th>
                                    <th data-column-id="Education"  >Education Level</th>
                                    <th data-column-id="Date Hired"  >Date Hired</th>
                                    <th data-column-id="Employment Status"  >Employment Status</th>
                                    <th data-column-id="Salary"  >Salary</th>
                                    <th data-column-id="Dependants"  >Dependants</th>
                                    <th data-column-id="Parents"  >Parents </th>
                                    <th data-column-id="Leave Status"  >Leave Status</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count=0;
                                    while($rt=$out->FetchRow()){
                                                            $count++;
                                       ?>
                                      <tr>
                                    <td><?php  echo $count; ?></td>
                                    <td>  </td>
                                    <td><?php  echo $rt[emp_number]; ?></td>
                                    <td><?php  echo $rt[title]." ". $rt[surname]." ".$rt[Name] ?></td>
                                    <td><?php  echo  $rt[classes]; ?></td>
                                    <td><?php  echo $rt[sex]; ?></td>
                                    <td><?php  echo $help->age(date("d-m-Y",$rt[dob]),"gh"); ?></td>
                                    <td><?php  echo $rt[marital]; ?></td>
                                    <td><?php  echo $rt[designation]; ?></td>
                                    <td><?php  echo $rt[ssnit]; ?></td>
                                    <td><?php  echo $rt[position]; ?></td>
                                    <td><?php  echo $rt[address]; ?></td>
                                    <td><?php  echo $rt[hometown]; ?></td>
                                    <td><?php  echo $rt[placeofresidence]; ?></td>
                                    <td><?php  echo $rt[email]; ?></td>
                                    <td><?php  echo $rt[grade]; ?></td>
                                    <td><?php  echo $rt[education]; ?></td>
                                    <td><?php  echo date("d-m-Y",$rt[datehired]); ?></td>
                                    <td><?php  echo $rt[empStatus]; ?></td>
                                    <td><?php  echo $rt[salary]; ?></td>
                                    <td><?php  echo $rt[dependentsNo]; ?></td>
                                    <td><?php  echo " Father :".$rt[father]." Mother :". $rt[mother]?></td>
                                    <td><?php  echo $rt[leaves]; ?></td>
                                      
                                     
                                
                                
                                     </tr>
                                    <?php } ?>
                            </tbody>
            </table></div>
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
        <script src="vendors/bootstrap-select/bootstrap-select.min.js"></script>
        <script src="vendors/chosen/chosen.jquery.min.js"></script>

  <script src="vendors/bootgrid/jquery.bootgrid.min.js"></script>
       
        <script type="text/javascript">
            $(document).ready(function(){
                
                
                //Command Buttons
                $("#data-table-command").bootgrid({
                    css: {
                        icon: 'md icon',
                        iconColumns: 'md-view-module',
                        iconDown: 'md-expand-more',
                        iconRefresh: 'md-refresh',
                        iconUp: 'md-expand-less'
                    },
                     caseSensitive: false,
					  formatters: {
						"link": function(column, row)
						{
							 var cellValue = row["staffId"];
							return "<a href='addworker.php?staff="+cellValue+"'><img  src='workerPics/"+cellValue+".jpg' style='width:79px;height:67px'   alt=\"staff pic here\" /></a>";
						}
						  					}
					 

                });
            });
        </script>
        <?php $app->exportScript() ?>
    </body>
  
</html>
