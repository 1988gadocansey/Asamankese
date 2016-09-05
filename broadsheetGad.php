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
        $teacher=new classes\Teacher();  $teacher=$teacher->getTeacher_ID($_SESSION[ID]);
        if($_GET[classes]){
        $_SESSION[classes]=$_GET[classes];
        }
 
        if($_GET[year]){
        $_SESSION[year]=$_GET[year];
        }

        if($_GET[term]){
        $_SESSION[term]=$_GET[term];
        }
        if($_POST[go]){
        $_SESSION[search]=$_POST[search];
        $_SESSION[content]=$_POST[content];
        }
        $search=$_POST[search];
                                                
        $content=$_POST[content];
        
                                            
 function getPhone($stuId){
     global $sql;
     
    $query1 = $sql->Prepare("SELECT ID,GUARDIAN_PHONE,SURNAME,OTHERNAMES from tbl_student where id='$stuId' AND GUARDIAN_PHONE!=''");
    //print_r($query1);
    $query = $sql->Execute($query1);

    $row = $query->FetchNextObject();
     
    return $row->GUARDIAN_PHONE;
     
 }
 function getShortCode($course) {
    global $sql;
     
    $query1 = $sql->Prepare("SELECT shortcode FROM `tbl_subjects` where name='$course' ");
    //print_r($query1);
    $query = $sql->Execute($query1);

    $row = $query->FetchNextObject();
    return $row->SHORTCODE;
  }
 function getCourse($courseId) {
    global $sql;
     
    $query1 = $sql->Prepare("SELECT name from tbl_courses where id='$courseId' ");
    //print_r($query1);
    $query = $sql->Execute($query1);

    $row = $query->FetchNextObject();
    return getShortCode($row->NAME);
  }

  function getCourseGrade($courseId,$year,$term,$student) {
    global $sql;
     
    $query1 = $sql->Prepare("SELECT total from tbl_assesments where term='$term' and year='$year' and stuId='$student'and  courseId='$courseId' AND total>0");
    //print_r($query1);
    $query = $sql->Execute($query1);

    $row = $query->FetchNextObject();
    return $row->TOTAL;
  }
 if(isset($_GET['send'])){
     global $sql;
       $class=$_SESSION[classes];
       $term=$_SESSION[term];
       $students=$_SESSION['students'];    
       
       $year=$_SESSION[year];
       if(!empty($year)&& !empty($term)){
         for($i=0;$i<count($students);$i++){
            $query1 = $sql->Prepare("SELECT courseId,grade from tbl_assesments where term='$term' and year='$year' and  stuId='$students[$i]' and class='$class'");
            //print_r($query1);
            $query = $sql->Execute($query1);
            
            
         //  $total=$help->$row->TOTAL;
         while($row = $query->FetchRow()){
            //$data[$students[$i]][$b[courseId]]=$b[total];	 
	    $datascore[$students[$i]].=getCourse($row[courseId])."=".$row[grade].", ";
         }
         }
      
         
        // print_r($datascore);
        for($i=0;$i<count($students);$i++){
          
			 $phone=getPhone($students[$i]);
			
			 $message="Hi Guildian these are the performances of your ward  ".$help->getName($students[$i])." Form:".$class." Term:".$term." Grades: ".rtrim($datascore[$students[$i]],',');
                        //print_r($message);
                         $name=$help->getName($students[$i]);
                          $help->firesms($message, $phone, $name) ;
		         set_time_limit(500);
                          

		 
	 }
         
    }
 }
?>
 <link href="vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
  
  <style>
     .container {
    width: 1380px;
}
 .md {
    font-size: 17px;
    vertical-align: middle;
    color: #333;
    margin-right: 10px;
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
				Subjects Assessments
                            </p>
                          <div style="margin-top:-3%;float:right">
                                  <?php if($_SESSION[level]=='Administrator'){ ?> 
                              
                              <a href="broadsheet.php?send=&1"      class="btn bgm-lime waves-effect btn-sm"  data-target="#sms"  onclick="return confirm('This may attract sms charges do you still want to continue??')">Send results to parents<i class="md md-sms"></i></a> 
                              <button title="Print broadsheet" onclick="javascript:printDiv('print')" class="btn bgm-orange waves-effect btn-sm"><i class="md md-print"></i>Print</button>
                                  
                              <button   class="btn btn-primary waves-effect waves-button dropdown-toggle btn-sm" data-toggle="dropdown">Export Data<i class="md md-save"></i> </button>
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
                                  <?php }?>
                            </div>
                             
                        </div>
                        <div class="row">
                           

                <table  width="1000px " border="0" align="center">
                    <tr>
                    <form action="" method="post">
                     
                	    <td>&nbsp;</td>
                             <td>&nbsp;</td>
                             <td>&nbsp;</td>
                             <td>&nbsp;</td>
                             <td>&nbsp;</td>
                             <td>&nbsp;</td>
                             <td>&nbsp;</td>
                                <td width="">
                                    <select class='form-control'   id='status' name="class"   style="" onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?classes='+escape(this.value);">
                                 <option value=''>Filter by class</option>
                                           
                                      <?php 
                                global $sql;

                                      $query2=$sql->Prepare("SELECT * FROM tbl_classes");


                                      $query=$sql->Execute( $query2);


                                   while( $row = $query->FetchRow())
                                     {

                                     ?>
                                     <option value="<?php echo $row['name']; ?>"  <?php if($_SESSION[classes]==$row['name']){echo 'selected="selected"'; }?>      ><?php echo $row['name']; ?></option>

                               <?php }?>
                                        </select>

                            </td>
                              <td>&nbsp;</td>
                             <td>&nbsp;</td>
                    <td>&nbsp;</td>
                      <td width="20%">

                        <select class='form-control'  name='term'  style=" " onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?term='+escape(this.value);" >
                                         <option value=''>Filter by term</option>
                                      
                                            <option value='1'<?php if($_SESSION[term]=='1'){echo 'selected="selected"'; }?>>1</option>
                                            <option value='2'<?php if($_SESSION[term]=='2'){echo 'selected="selected"'; }?>>2</option>
                                        <option value='3'<?php if($_SESSION[term]=='3'){echo 'selected="selected"'; }?>>3</option>

                                    </select>

                     </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                             <td>&nbsp;</td>
                    <td width="">

                        <select class='form-control'  name='year'  style="" onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?year='+escape(this.value);" >
                                         <option value=''>Filter by academic year</option>
                                        
                                             <?php
                                                                            for($i=2008; $i<=date("Y"); $i++){
                                                                                    $a=$i - 1 ."/". $i;?>
                                                                                             <option <?php if($_SESSION[year]==$a){echo 'selected="selected"'; }?>value='<?php echo $a ?>'><?php echo $a ?></option>";
                                                                             
                                                                                 <?php    } ?>


                                                                     ?>

                                    </select>

                     </td>
                      <td>&nbsp;</td>
        
                    <td>

                       <!-- <div class="form-action ">
                                <button type="submit" name="submit" class="btn ink-reaction btn-raised btn-primary">Search</button>

                        </div> -->
                    </td>
        
                    </tr>  
                </form>
                </table>
                            &nbsp;
                             <table align="center">
                            <tr>
                            <form action="broadsheet.php" method="post" >
                      <td width="25%">
                          
                                                         
                          <input type="text" name ="search" placeholder="search by index number"required="" style="margin-left:3px;width: 130px " class="form-control" >
                                                             
                      </td>
                      <td>&nbsp;</td>
                      <td width="25%">
                          <button type="submit" name="go" style="margin-left:%;width: 81px " class="btn btn-primary   btn-search">Search<i class="md md-search"></i></button>
                      </td>
                    </tr>  
                    
                </form>
                </table>
 
 
                <p>&nbsp;</p>
                            
                        
           </div><!--end .row -->

             <?php 
              
                $class=$_SESSION[classes];
                $term=$_SESSION[term];
                 $search=$help->getID($_POST[search]);
                 
                                            
                $year=$_SESSION[year];
                if($term=="All Terms" or $term==""){ $ter=""; }else {$ter=" and tbl_assesments.term = '$term' "  ;}
                  if($year=="All Years" or $year==""){ $ins=""; }else {$ins=" and tbl_assesments.year = '$year' "  ;}
                if($class=="All Classes" or $class=="" ){ $in=""; }else {$in=" and tbl_assesments.class = '$class' "  ;}
                if($search=="" ){ $search=""; }else {$search_=" AND stuId= '$search' "  ;}

                   if($_SESSION[term]==1){
                       $tt="1st Term";
                   }
                   elseif($_SESSION[term]==2){
                       $tt="2nd Term";
                   }
                   else{
                       $tt="3rd Term";
                   }
                
             ?>     
              
                    <div class="table-responsive">
                        <div id="print">
                        <p><center><b>Broadsheet for <?php echo $class." "; echo  $tt ." " ; echo  $year. " Academic year"?></b></center></p>
                        <table  id="data-table-command" class="table table-bordered table-vmiddle table-hover"  >
                            <thead>
                                <tr>
                                    
                                     <th>No</th>
                                     <th data-column-id="Student" data-type=" " data-toggle="tooltip">Student</th>
                                     <?php 
                                     
                                        $queryy=$sql->prepare("SELECT distinct courseId FROM `tbl_assesments` WHERE class='$class' ORDER BY courseId");
                                        $query_=$sql->Execute($queryy);
                                        while($row=$query_->FetchRow()){
                                            //$courseArray=array();
                                           
                                           $course=$row['courseId'];
                                            $courseArray[]=$course;
                                     ?>
                                      
                                     <th data-column-id="Exam Score" data-order="asc" style="text-align:"><?php echo getCourse($row['courseId'])?></th>
                                    <?php }?>
                                </tr>
                            </thead>
                            <?php
                                $query11= $sql->Prepare( "SELECT DISTINCT tbl_assesments.stuId as stuId from tbl_assesments WHERE 1 $ter $inse $ins $in $search_ ORDER BY stuId ASC");
                              // print_r($query11);             
                                $rs = $sql->PageExecute($query11,RECORDS_BY_PAGE,CURRENT_PAGE);
                                                      $recordsFound = $rs->_maxRecordCount;    // total record found
                                                     if (!$rs->EOF) 
                                                     {
                                            
                                                     $total = $rs->_maxRecordCount; }
                                    
                            
                            ?>
                            <tbody>
                                  <?php
                                   $count=0;
                                   $mark=array();
                                    while($rtmt=$rs->FetchRow()){
                                         $count++;
                                         //array_push($courseArray, $rtmt[total])
                                         //$data[$rtmt[indexno][$rtmt[courseId]]]=$rtmt[total];	
                                   	 	$students[]=$rtmt[stuId];
                                                $_SESSION['students']=$students;
                                       ?>
                                
                                    <tr>
                                        <td><?php  echo $count?></td>
                                             
                                        <td style="text-align:left"><?php $a=$rtmt[stuId];echo $help->getName($rtmt[stuId]); //echo $help->getIndex($a) ?></td>
                                  
                                         <?php
                                                
                                        for($i=0;$i<count($courseArray);$i++){  
                                           
                                           // print_r($courseArray); "<td>$courseArray[$i]</td>";
                                        print_r("<td>".  round(getCourseGrade($courseArray[$i],$_SESSION[year],$_SESSION[term],$a))."% - ".$help->getGrade(getCourseGrade($courseArray[$i],$_SESSION[year],$_SESSION[term],$a))."</td>");

                                     }   }?>     
                                     
                                   </tr>
                                   
                            </tbody>
                          </table><br/>
                        </div>
                     <center><?php
                     
                         $GenericEasyPagination->setTotalRecords($recordsFound);
	  
                        echo $GenericEasyPagination->getNavigation();
                        echo "<br>";
                        echo $GenericEasyPagination->getCurrentPages();
                      ?></center>                             
             
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
