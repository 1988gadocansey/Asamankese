 <?php
 ini_set('display_errors', 0);
    require 'vendor/autoload.php';
    include "library/includes/config.php";
     include "library/includes/initialize.php";
     $help = new classes\helpers();
$teacher2 = new classes\Teacher();
$teacher = $teacher2->getTeacher_ID($_SESSION[ID]);
$_SESSION[indexno]="";
$instructor = $teacher2->getTeacher_Class($teacher->EMP_NUMBER);
$sms=new classes\smsgetway();
if(isset($_POST[sms])){
         $q=$_SESSION[last_query];
        $query=$sql->Prepare($q);
        $rt=$sql->Execute($query);
        
        While($stmt=$rt->FetchRow()){
            $arrayphone=$stmt[GUARDIAN_PHONE];
        
        if($a=$sms->sendAdmitted($arrayphone, $_POST[message],$stmt[INDEXNO])){
            $_SESSION[last_query]="";
        
            header("location:students.php?success=1");
            
            }
        }
    }
    if($_GET[program]){
        $_SESSION[program]=$_GET[program];
        }

        if($_GET[house]){
        $_SESSION[house]=$_GET[house];
        }
        
        if($_POST[go]){
        $_SESSION[search]=$_POST[search];
        $_SESSION[content]=$_POST[content];
        }

        if($_GET[year]){
        $_SESSION[year]=$_GET[year];
        }
        if($_GET[status]){
        $_SESSION[status]=$_GET[status];
        }
         
        if($_GET[gender]){
        $_SESSION[gender]=$_GET[gender];
        }
        if($_GET['class']){
        $_SESSION['class']=$_GET['class'];
        }

         


$app=new classes\structure();
     
    $notify=new classes\Notifications();
     $app->gethead();
 ?>
 <link href="vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
 <script src="js/jquery.js"></script>
 <script src="js/jquery_003.js"></script>
  
 <style>
     #assesment  tr:hover{
        
        background-color: #FFFCBE;
    }
     .container {
    width: 1351px;
}
td{
    text-transform: capitalize;
}
 </style>
  
 
 
<body>
      <div class="modal fade" id="sms" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Send SMS</h4>
                                        </div>
                                        <div class="modal-body">
                                            
                                            <form action="students.php" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
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
							Generate customised reports   send sms,edit students data here
                            </p>
                            <div style="margin-top:-3%;float:right">
                                 <button      class="btn bgm-lime waves-effect"  data-target="#sms"  data-toggle="modal">Send SMS<i class="md md-sms"></i></button> 
                                <a href="addStudent.php" title="add a student" class="btn bgm-orange waves-effect"> Add Student<i class="md md-add"></i></a>
                                 <button   class="btn btn-primary waves-effect waves-button dropdown-toggle" data-toggle="dropdown">Export Data<i class="md md-save"></i> </button>
                                        <ul class="dropdown-menu">
                                            
                                            <li><a href="#" onClick ="$('#assesment').tableExport({type:'csv',escape:'false'});"><img src='img/icons/csv.png' width="24"/> CSV</a></li>
                                            <li><a href="#" onClick ="$('#assesment').tableExport({type:'txt',escape:'false'});"><img src='img/icons/txt.png' width="24"/> TXT</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#" onClick ="$('#assesment').tableExport({type:'excel',escape:'false'});"><img src='img/icons/xls.png' width="24"/> XLS</a></li>
                                            <li><a href="#" onClick ="$('#assesment').tableExport({type:'doc',escape:'false'});"><img src='img/icons/word.png' width="24"/> Word</a></li>
                                            <li><a href="#" onClick ="$('#assesment').tableExport({type:'powerpoint',escape:'false'});"><img src='img/icons/ppt.png' width="24"/> PowerPoint</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#" onClick ="$('#assesment').tableExport({type:'png',escape:'false'});"><img src='img/icons/png.png' width="24"/> PNG</a></li>
                                            <li><a href="#" onClick ="$('#assesment').tableExport({type:'pdf',escape:'false'});"><img src='img/icons/pdf.png' width="24"/> PDF</a></li>
                                        </ul>
                            </div>
                        </div>
                    <table  width=" " border="0">
                                <tr>
                                    <td>&nbsp;</td>   
                     
                             <td width="20%">

                               <select class='form-control select2_sample1'  name='subject'  style="width:170px;" onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?program='+escape(this.value);" >
                                <option value=''>Filter by programme</option>
                                        <option value='All programs'>All Programs</option>
                                    <?php 
                                      global $sql;

                                          $query2=$sql->Prepare("SELECT * FROM tbl_program");


                                          $query=$sql->Execute( $query2);


                                       while( $row = $query->FetchRow())
                                         {

                                         ?>
                                         <option <?php if($_SESSION[program]==$row['NAME']){echo 'selected="selected"'; }?> value="<?php echo $row['NAME']; ?>"        ><?php echo $row['NAME']; ?></option>

                                  <?php }?>
                                      </select>

                            </td>
                             
				 
                       
                               <td width="25%">
                                    <select class='form-control'  name='subject'  style="width:150px;margin-left: -20px" onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?class='+escape(this.value);" >
                                <option value=''>Filter by Class</option>
                                        <option value='All classes'>All Classes </option>
                                    <?php 
                                      global $sql;

                                          $query2=$sql->Prepare("SELECT * FROM tbl_classes");


                                          $query=$sql->Execute( $query2);


                                       while( $row = $query->FetchRow())
                                         {

                                         ?>
                                         <option <?php if($_SESSION['class']==$row['name']){echo 'selected="selected"'; }?> value="<?php echo $row['name']; ?>"        ><?php echo $row['name']; ?></option>

                                  <?php }?>
                                      </select>

                               </td>
                    <td width="25%">
                                   <select class='form-control' style="margin-left:-73%;  width:72% "  onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?house='+escape(this.value);"     >
                                       <option value=''>Filter by houses</option>
                                        <option value='All houses'>All houses</option>
                                                          
                                                      <?php 
                                                      global $sql;

                                                      $query2=$sql->Prepare("SELECT * FROM tbl_house");


                                                        $query=$sql->Execute( $query2);


                                                     while( $row = $query->FetchRow())
                                                       {

                                                       ?>
                                                       <option value="<?php echo $row['house']; ?>"   <?php if($_SESSION[house]==$row['house']){echo "selected='selected'";} ?>      ><?php echo $row['house']; ?></option>

                                                    <?php }?>
                                                       
                                                   </select>

                            </td>     
                    <td>&nbsp;</td>
                      <td width="20%">

                        <select class='form-control'  name='term'  style="margin-left:-126%;  width:66% " onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?year='+escape(this.value);" >
                                         <option value=''>Filter by year group</option>
                                          <option value='All year'>All year groups</option>
                                                  <?php
                                                                                                               for($i=2008; $i<=4000; $i++){
                                                                                                                       $a=$i - 1 ."/". $i;?>
                                                                                                                                <option <?php if($_SESSION[year]==$a){echo 'selected="selected"'; }?>value='<?php echo $a ?>'><?php echo $a ?></option>";

                                                                                                                    <?php    } ?>


                                                                                                        ?>
                                    </select>

                     </td>
                      <td width="25%">
                                    <select class='form-control'      style="margin-left:;  width:108px " onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?gender='+escape(this.value);" >
                                         <option value=''>Filter by gender</option>
                                        <option value='All gender'>All gender</option>
                                        <option value='M'<?php if($_SESSION[gender]=='M'){echo 'selected="selected"'; }?>>Male</option>
                                        <option value='F'<?php if($_SESSION[gender]=='F'){echo 'selected="selected"'; }?>>Female</option>
                                         
                                    </select>

                      </td>
                     <td>&nbsp;</td>
                                <td width="25%">
                                    <select class='form-control'  name='term'  style="   width:139px " onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?status='+escape(this.value);" >
                                         <option value=''>Filter by status</option>
                                        <option value='All status'>All status</option>
                                         <option value='In School'<?php if($_SESSION[status]=='In School'){echo 'selected="selected"'; }?>>In School</option>
                                        <option value='Alumni'<?php if($_SESSION[status]=='Alumni'){echo 'selected="selected"'; }?>>Alumni</option>
                                        <option value='Deffered'<?php if($_SESSION[status]=='Deffered'){echo 'selected="selected"'; }?>>Deffered</option>
                                        <option value='Dead'<?php if($_SESSION[status]=='Dead'){echo 'selected="selected"'; }?>>Dead</option>
                                        <option value='Suspended'<?php if($_SESSION[status]=='Suspended'){echo 'selected="selected"'; }?>>Suspended</option>
                                        <option value='Rasticated'<?php if($_SESSION[status]=='Rasticated'){echo 'selected="selected"'; }?>>Rasticated</option>

                                    </select>

                     </td>
                       
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                              <td>&nbsp;</td>
                                </tr>
                    </table>
                        <p>&nbsp;</p>
                        <table align="center">
                            <tr>
                  <form action="students.php" method="post" >
                      <td width="25%">
                          
                                                         
                          <input type="text" name ="search" placeholder="search here"required="" style="margin-left:3px;  width:161% " class="form-control" id=" "  >
                                                             
                      </td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                       <td width="25%">
                           <select class='form-control'  name='content' required="" style="margin-left:;  width:78% "  >
                                         <option value=''>search by</option>
                                        
                                        <option value='SURNAME'<?php if($_SESSION[contents]=='SURNAME'){echo 'selected="selected"'; }?>>Surname</option>
                                        <option value='OTHERNAMES'<?php if($_SESSION[statuss]=='OTHERNAMES'){echo 'selected="selected"'; }?>>Othernames</option>
                                        <option value='INDEXNO'<?php if($_SESSION[statuss]=='INDEXNO'){echo 'selected="selected"'; }?>>Index No</option>
                                         
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
         
<hr>
                                            <?php 
                                                $program=$_SESSION[program];                                       
                                                 
                                                $gender=$_SESSION[gender];
                                                $class=$_SESSION['class'];
                                                $year=$_SESSION[year];
                                               $house=$_SESSION[house];
                                                $status=$_SESSION[status];
                                                $search=$_POST[search];
                                                $content=$_POST[content];
                                            

                                                if($class=="All classes" or $class==""){ $class=""; }else {$class_=" and  CLASS = '$class' "  ;}
                                                if($program=="All programs" or $program==""){ $program=""; }else {$program_="and PROGRAMME = '$program' "  ;}
                                                if($gender=="All gender" or $gender=="" ){ $gender=""; }else {$gender_=" and GENDER= '$gender' "  ;}
                                                if($year=="All year" or $year=="" ){ $year=""; }else {$year_=" and YEAR_GROUP = '$year' "  ;}
                                                if($house=="All houses" or $house=="" ){ $house=""; }else {$house_=" and HOUSE = '$house' "  ;}
                                       
                                                if($status=="All status" or $status=="" ){ $status=""; }else {$status_=" and STATUS = '$status' "  ;}
                                                if($search=="" ){ $search=""; }else {$search_="AND $content= '$search' "  ;}

                                              $_SESSION[last_query]=     $query =$sql->Prepare( "SELECT * FROM tbl_student WHERE 1 $program_  $class_  $search_ $gender_ $house_ $status_ $year_ ");
                                                   
                                           
                                              $rs = $sql->PageExecute($_SESSION[last_query],RECORDS_BY_PAGE,CURRENT_PAGE);
                                                      $recordsFound = $rs->_maxRecordCount;    // total record found
                                                     if (!$rs->EOF) 
                                                     {
                                            
                                                    $total = $rs->_maxRecordCount;    // total record found
             ?>
            <p style="color:green"><center>Total records = <?php echo $total; ?></center></p>
                    
           <table id="assesment"  class="table table-condensed table-vmiddle" >
               <thead>
                                <tr>
                                    <th  data-column-id="kk" data-type="numeric">No</th>
                                     <th  data-column-id="link" data-formatter="link">Pic</th>
                                    <th data-column-id="indexno">School No</th>
                                    <th data-column-id="indexno">WAEC IndexNo</th>
                                    <th data-column-id="surname" data-order="asc">Name</th>
                                     <th data-column-id="gender"  >Gender</th>
                                     <th data-column-id="gender"  >Age</th>
                                    <th data-column-id="phone" >Subject Combination</th>
                                    <th data-column-id="class"  >Class</th>
                                    
                                    <th data-column-id="guardian-name"  >Guardian</th>
                                    <th data-column-id="guardian-phone"  >Guardian Phone</th>
                                    
                                    
                                    <th data-column-id="Year Group"  >Year Group</th>
                                    
                                    <th data-column-id="status"  >Status</th>
                                     
                                    <th data-column-id="commands" data-formatter="commands" data-sortable="false">Actions </th>
                                     
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
                                    <td style="width:90px"><a href="addStudent.php?indexno=<?php echo $rt[INDEXNO] ?>"><img <?php echo $help->picture("studentPhotos/$rt[INDEXNO].jpg",90)  ?>     src="<?php echo file_exists("studentPhotos/$rt[INDEXNO].jpg") ? "studentPhotos/$rt[INDEXNO].jpg":"studentPhotos/user.png";?>" alt=" Picture of Student Here"    /></a></td>
                                 
                                    <td><?php  echo $rt[INDEXNO]; ?></td>
                                     <td><?php  echo $rt[WAEC_INDEXNO]; ?></td>
                                    <td><?php  echo $rt[SURNAME].",".$rt[OTHERNAMES] ?></td>
                                     
                                    <td><?php  echo $rt[GENDER]; ?></td>
                                    <td><?php  echo $rt[AGE]; ?>yrs</td>
                                    <td><?php  echo $rt[SUBJECT_COMBINATIONS]; ?></td>
                                     <td><?php  echo $rt["CLASS"]; ?></td>
                                    <td><?php  echo $rt[GUARDIAN_NAME]; ?></td>
                                    <td><?php  echo $rt[GUARDIAN_PHONE]; ?></td>
                                    
                                   
                               
                                    <td><?php  echo $rt[YEAR_GROUP]; ?></td>
                                    <td><?php  echo $rt[STATUS]; ?></td>
                                    <td>
                                        <a     href="addStudent.php?indexno=<?php  echo $rt[INDEXNO]?>" title="click to edit" tooltip="click to edit"> <span class="md md-edit"></span>   </a> 
                                        <a  onclick="return MM_openBrWindow('report_card.php?student=<?php  echo $rt[ID]?>','','menubar=yes,width=800,height=650')" title="click to print report card" tooltip="click to print transcript"> <span class="md-print " style="font:90px"></span>   </a> 
                                        <a  onclick="return MM_openBrWindow('printStudent.php?indexno=<?php  echo $rt[INDEXNO]?>','','menubar=yes,width=800,height=650')"     title="click to view" tooltip="click to view"> <span class="md-pageview "></span>   </a> 
                                    </td>  
                                
                                     </tr>
                                    <?php } ?>
                            </tbody>
            </table>
                        <br/>
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
                    
                    
                </div>
            </section>
        </section>
        
         
        <?php  $app->getDashboardScript() ; $app->getuploadScript(); ?>
        <script src="vendors/bootstrap-select/bootstrap-select.min.js"></script>
        <script src="vendors/chosen/chosen.jquery.min.js"></script>
        <script src="vendors/bootgrid/jquery.bootgrid.min.js"></script>
       
       
        
        <?php $app->exportScript() ?>
    </body>
  
</html>
