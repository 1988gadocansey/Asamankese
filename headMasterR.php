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
        $teacher_ob=new classes\Teacher();  $teacher=$teacher_ob->getTeacher_ID($_SESSION[ID]);
  //print_r($teacher);
        if($_GET[year]){
        $_SESSION[year]=$_GET[year];
        }
        if($_GET[term]){
        $_SESSION[term]=$_GET[term];
        }
         
        if($_GET['class']){
        $_SESSION["class"]=$_GET["class"];
        }
        
        // checked if we are in current or new academic year ie new term or new year
        $query2=$sql->Prepare("SELECT  year,term FROM tbl_class_members order by year DESC");		  
        $query22=$sql->Execute($query2);
        while($rss= $query22->FetchRow())
        {
                $years=$rss['year'];
                $terms=$rss['term'];
         }
          
        $query=$sql->Prepare("SELECT  name,nextClass FROM tbl_classes order by name");		  
        $query=$sql->Execute($query);
        while($rs = $query->FetchRow())
        {
                $class[]=$rs['name'];
                $nextclass[$rs['name']]=$rs['nextClass'];
         }
                  $class[]="ALUMNI";
                  $teacher->USER_TYPE;
     if($_POST[submit]){
        $indexno=$_POST[index] ;

        $class_id=$_POST["class"] ;
        $attend=$_POST[attendance];
        
       
        $head_teacher=$_POST[head_teacher];
        $promoted=$_POST[promoted];
         
	$counter=  $_POST['upper'];
	  $form=$_POST['form'];	   
   for($i=0;$i<$counter;$i++){
 

        $student=$indexno[$i];

        $id=$class_id[$i];
        $attend_=$attend[$i];
         
         $form_=$form[$i];
        $head_teacher_=$head_teacher[$i];
        $promoted_=$promoted[$i];
 
        $dates=date('M/Y');
        
             if($school->YEAR==$years && $school->TERM==$terms){
             $query=$sql->Prepare("update tbl_class_members set attendance='$attend_',promotedTo='$promoted_',head_mast_report='$head_teacher_',year='$school->YEAR',term='$school->TERM' where  id='$id'");
            // print_r($query);
             
             }
             else{
                 $query=$sql->Prepare("insert into tbl_class_members set class='$form_', student='$student', attendance='$attend_',promotedTo='$promoted_',head_mast_report='$head_teacher_',year='$school->YEAR',term='$school->TERM'");
                // print_r($dates);
             }
             
              $sql->Execute($query);



        }

    }

                
	  
 ?>
   
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
   <script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
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
                      
                    <div class="card">
                        
                        <div class="card-header">
                           <p>
                               Prepare Reports for <strong><?php echo $school->YEAR .' Year '. $school->TERM .'term';?></strong>
                            </p>
                          <div style="margin-top:-3%;float:right">
                                 
                               <?php if($teacher->USER_TYPE=='Teacher'){ ?>  <button   class="btn btn-primary waves-effect waves-button dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button><?php }?>
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
                    <form action="" method="post">
                     
                	    <td>&nbsp;</td>
                             <td>&nbsp;</td>
                             <td>&nbsp;</td>
                                <td width="25%">
                                    <select class='form-control'     name="class"   style="margin-left:6%;Width:160px" onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?class='+escape(this.value);">
                                 <option value=''>Filter by class</option>
                                          <option value='All class'>All Classes</option>
                                      <?php 
                                global $sql;

                                      $query2=$sql->Prepare("SELECT * FROM tbl_classes");


                                      $query=$sql->Execute( $query2);


                                   while( $rtmtow = $query->FetchRow())
                                     {

                                     ?>
                                     <option value="<?php echo $rtmtow['name']; ?>"  <?php if($_SESSION['class']==$rtmtow['name']){echo 'selected="selected"'; }?>      ><?php echo $rtmtow['name']; ?></option>

                               <?php }?>
                                        </select>

                            </td>
                             
				  
                      
                    <!--<td>&nbsp;</td>
                      <td width="20%">

                        <select class='form-control'  name='term'  style="margin-left:-25%;  width:168px " onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?term='+escape(this.value);" >
                                         <option value=''>Filter by term</option>
                                        <option value='All term'>All Terms</option>
                                            <option value='1'<?php if($_SESSION[term]=='1'){echo 'selected="selected"'; }?>>1</option>
                                            <option value='2'<?php if($_SESSION[term]=='2'){echo 'selected="selected"'; }?>>2</option>
                                        <option value='3'<?php if($_SESSION[term]=='3'){echo 'selected="selected"'; }?>>3</option>

                                    </select>

                     </td>
                    <td>&nbsp;</td>
                    <td width="30%">

                                <select class='form-control'  name='year'  style="margin-left:-14%; width:168px" onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?year='+escape(this.value);" >
                                                 <option value=''>Filter by academic year</option>
                                                <option value='All year'>All Years</option>
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
 
 
                <p>&nbsp;</p>
                            </div><!--end .row -->

             
              
                    <div class="table-responsive">
                        <table class="table table-striped"  >
                            <thead>
                                <tr>
                                    
                                     <th  data-type="numeric" data-identifier="true">No</th>
                                     <th data-column-id="Student"   data-toggle="tooltip">Student</th>
                                     <th data-column-id="Class" data-type=" " data-toggle="tooltip">Class</th>
                                    <th style="text-align" data-type="string" data-column-id="Total Score" style="text-align:center">Total Score</th>
                                   
                                    <th data-column-id="Attendance" data-order="asc" style="text-align:">Attendance</th>
                                       
                                       <th data-column-id="Headmaster Report" data-order="asc" style="text-align: ">Head Teachers Report</th>
                                       <?php  if($school->TERM=='3'){?>
                                       <th data-column-id="Promoted" data-order="asc" style="text-align: ">Promoted to</th>
                                     
                                       <?php }?>
                                       
                                       <th data-column-id="Position" data-order="asc" style="text-align: ">Position</th>
                                      
                                </tr>
                            </thead>
                            <tbody>
     <form id="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <?php 
                               $class=$_SESSION['class'];
                                                $year=$_SESSION[year];
                                               $term=$_SESSION[term];
                                                 if($year=="All year" or $year=="" ){ $year=""; }else {$year_=" and tbl_class_members.year = '$year' "  ;}
                                                if($class=="All class" or $class==""){ $class=""; }else {$class_=" and  tbl_class_members.class = '$class' "  ;}
                                              if($term=="All term" or $term==""){ $term=""; }else {$term_=" and  tbl_class_members.term = '$term' "  ;}
                                                     
                 $query=$sql->Prepare("SELECT DISTINCT  total,position,attendance,head_mast_report,tbl_class_members.class,promotedTo,surname,othernames,tbl_class_members.id as id,tbl_student.indexno as idd from tbl_class_members,tbl_student,tbl_classes   where 1 and tbl_class_members.year='$school->YEAR' and tbl_class_members.term ='$school->TERM' and tbl_class_members.student=tbl_student.indexno and tbl_student.status='In school'   $term_ $class_ $year_");		
                $query=$query." ORDER BY total desc,tbl_student.surname asc";
              //print_r($query);
                $rs = $sql->PageExecute($query,30);
                $recordsFound = $rs->_maxRecordCount;    // total record found
                                                      
                                            
                 
                 
                $count;
                       // print_r($stmt->FetchRow());
                while($rtmt = $rs->FetchRow())

                {
                    $count++;
                ?>
              <tr>
                <td ><?php echo $count ?></td>
                <td><?php echo $rtmt[surname].", ".$rtmt[othernames];?>
                    <input type="hidden" name="student[]" value="<?php echo $rtmt[sid];?>" />
                    <input type="hidden" name="class[]" value="<?php echo $rtmt[id];?>" />
                    <input type="hidden" name="index[]" value="<?php echo $rtmt[idd];?>" /></td>
                 <input type="hidden" name="form[]" value="<?php echo $rtmt["class"];?>" /></td>
                 <input type="hidden" name="upper" value="<?php echo $count;?>" id="upper" />
                <td><?php echo ($rtmt["class"]); ?></td>
                <td><?php echo ($rtmt[total]); ?></td>
                
                <td ><label>
                        <input name="attendance[]" readonly=""  type="text" size="8" maxlength="8" value="<?php echo $rtmt[attendance] ?>" />
                </label></td>
               
                   
                <td><select name="head_teacher[]" >
                 <option value=''>select head teacher's</option>
                               <?php 
                            global $sql;

                                  $query2=$sql->Prepare("SELECT DISTINCT con FROM head_master_report");


                                  $query=$sql->Execute( $query2);


                               while( $row = $query->FetchRow())
                                 {

                                 ?>
                                 <option value="<?php echo $row['con']; ?>"  <?php if($row['con']==$rtmt["head_mast_report"]){echo 'selected="selected"'; } ?>     ><?php echo $row['con']; ?></option>

                           <?php }?>

                </select>
             
             </td>
              <?php  if($school->TERM=='3'){?>
                <td><label>
                  <select name="promoted[]"    >
                 <option value=''>select promotion</option>
                               <?php 
                            global $sql;

                                  $query2=$sql->Prepare("SELECT name   FROM tbl_classes");


                                  $query=$sql->Execute( $query2);


                               while( $row = $query->FetchRow())
                                 {

                                 ?>
                                 <option value="<?php echo $row['name']; ?>"  <?php if($row['name']==$rtmt["promotedTo"]){echo 'selected="selected"'; } ?>     ><?php echo $row['name']; ?></option>

                           <?php }?>

                </select>
              </label></td><?php }?>
                <td><div align="center"><?php echo $rtmt[position]; ?> </div>
                    
                      <label></label>
                  </td>
                   </tr>
              <?php 
				  
								  } ?>
            </table>
                        <center> <p>&nbsp;</p>
            <p>
             
              <label>
              <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-success" />
              </label>
              <label>
              <input type="submit" name="button" id="button" class="btn btn-warning" value="cancel" />
              </label>
            </p></center>
    </div>
                    </form> 
                            </tbody>
                          </table>
                         <br/>
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
                     
                    
                    
                </div>
            </section>
        </section>
        
         
        <?php  $app->getDashboardScript() ; $app->getuploadScript(); ?>
  
        <?php $app->exportScript() ?>
    </body>
  
</html>
