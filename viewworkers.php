 <?php
 ini_set('display_errors', 0);
    require 'vendor/autoload.php';
    include "library/includes/config.php";
     include "library/includes/initialize.php";
     $help=new classes\helpers();
       $sms=new classes\smsgetway();
    $app=new classes\structure();
    
    $notify=new classes\Notifications();
     $app->gethead();
     if(isset($_POST[sms])){
         $q=$_SESSION[last_query];
        $query=$sql->Prepare($q);
        $rt=$sql->Execute($query);
        
        While($stmt=$rt->FetchRow()){
            $arrayphone=$stmt[phone];
         
        if($a=$sms->sendBulkSms($_POST[message],$arrayphone,$stmt[INDEXNO])){
            $_SESSION[last_query]="";
        
            header("location:viewworkers.php?success=1");
            
            }
        }
    }
    if($_POST[go]){
        $_SESSION[search]=$_POST[search];
        $_SESSION[content]=$_POST[content];
        }
 ?>
 <link href="vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
 <script src="js/jquery.js"></script>
 <script src="js/jquery_003.js"></script>
  
 <style>
     .container {
    width: 1310px;
}
 </style>
  
 
<body>
      
     <?php  $app->getTopRgion() ?>
        
        <section id="main">
             <?php $app->getMenu(); ?>
            
              <?php $app->getChats(); ?>
               <div class="modal fade" id="sms" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Send SMS</h4>
                                        </div>
                                        <div class="modal-body">
                                            
                                            <form action="viewworkers.php" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
                                                 <div class="card-body card-padding">
                                                     <div class="form-group">
                                                         <label for="inputPassworsd3" class="col-sm-2 control-label">Message</label>
                                                         <div class="col-sm-10">

                                                             <div class="fg-line">
                                                                  
                                                                 <textarea required="" class="form-control" name="message" rows="9" ></textarea>                                    
                                                             </div>
                                                         </div>
                                                     </div>
                                                <div class="modal-footer">
                                                      
                                                    <button type="submit" name="sms" class="btn btn-success">Send <i class="fa fa-sm"></i></button>
                                                          <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
                                                </div>
                                                  
                                                 </div>
                                             </div>  
                                            </form>
                                  </div>
                                </div>
                        </div>
            
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
                                <a      class="btn btn-success waves-effect"   href="upload_staff.php" >Upload Bulk Staff<i class="md md-save"></i></a> 
                              
                                <button      class="btn bgm-lime waves-effect"  data-target="#sms"  data-toggle="modal">Send SMS<i class="md md-sms"></i></button> 
                              
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
                         <td>&nbsp;</td>
                         <td>&nbsp;</td>
                         <td>&nbsp;</td>
                         <td>&nbsp;</td><td>&nbsp;</td>
                         
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
                        <table align="center">
                            <tr>
               <form action="viewworkers.php" method="post" >
                      <td width="25%">
                          
                                                         
                          <input type="text" name ="search" placeholder="search here"required="" style="margin-left:3px;  width:161% " class="form-control" id=" "  >
                                                             
                      </td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                       <td width="25%">
                           <select class='form-control'  name='content' required="" style="margin-left:;  width:78% "  >
                                         <option value=''>search by</option>
                                        
                                        <option value='surname'<?php if($_SESSION[contents]=='SURNAME'){echo 'selected="selected"'; }?>>Surname</option>
                                        <option value='Name'<?php if($_SESSION[statuss]=='OTHERNAMES'){echo 'selected="selected"'; }?>>Othernames</option>
                                        <option value='emp_number'<?php if($_SESSION[statuss]=='INDEXNO'){echo 'selected="selected"'; }?>>Staff ID</option>
                                         
                                    </select>

                      </td>
                      <td>&nbsp;</td>
                      <td width="25%">
                            <button type="submit" name="go" style="margin-left:%;width: 81px " class="btn btn-primary   btn-search">Search</button>
                      </td>
                    </tr>  
                    
                </form>
                </table>
 
<p>&nbsp;</p>
            </div><!--end .row -->
            
             <?php 
              
                  if(isset($_GET['grade'])){
                 if($_GET['grade']=="all"){
                     $end_query="";
                       }
                 else{ $end_query="AND grade='$_GET[grade]'   ";}
                  }
                  elseif(isset($_GET['position'])){
                 if($_GET['position']=="all"){
                     $end_query="";
                       }
                 else{ $end_query="AND position='$_GET[position]'   ";}
                  }
                  
                  elseif(isset($_GET['class'])){
                 if($_GET['class']=="all"){
                     $end_query="";
                       }
                 else{ $end_query="AND teaches='$_GET[class]'   ";}
                  }
                  
                  elseif(isset($_GET['designation'])){
                 if($_GET['designation']=="all"){
                     $end_query="";
                       }
                 else{ $end_query="AND designation='$_GET[designation]'   ";}
                  }
                   elseif(isset($_GET['gender'])){
                 if($_GET['gender']=="all"){
                     $end_query="";
                       }
                 else{ $end_query="AND sex='$_GET[gender]'   ";}
                  }
                  $search=$_POST[search];
                 $content=$_POST[content];
                             if($search=="" ){ $search=""; }else {$search_="AND $content= '$search' "  ;}
               
                  $_SESSION[last_query]=  $query= $sql->Prepare( "SELECT * FROM tbl_workers WHERE 1 $end_query $search_");
                                                
												$stmt =$sql->Prepare($query);
                                                    $rs = $sql->PageExecute($_SESSION[last_query],RECORDS_BY_PAGE,CURRENT_PAGE);
                                                      $recordsFound = $rs->_maxRecordCount;    // total record found
                                                     if (!$rs->EOF) {
                                                    
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
                                    while($rt=$rs->FetchRow()){
                                                            $count++;
                                       ?>
                                      <tr>
                                    <td><?php  echo $count; ?></td>
                                    <td style="width:90px"><a href="addworker.php?staff=<?php echo $rt[emp_number] ?>"><img <?php echo $help->picture("workerPics/$rt[emp_number].jpg",90)  ?>     src="<?php echo file_exists("workerPics/$rt[emp_number].jpg") ? "workerPics/$rt[emp_number].jpg":"workerPics/user.png";?>" alt=" Picture of WORKER Here"    /></a></td>
                                 
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
                    <center><?php
                     
                         $GenericEasyPagination->setTotalRecords($recordsFound);
	  
                        echo $GenericEasyPagination->getNavigation();
                        echo "<br>";
                        echo $GenericEasyPagination->getCurrentPages();
                      ?></center>
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

   
        <?php $app->exportScript() ?>
    </body>
  
</html>
