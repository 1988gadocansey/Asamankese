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
        if(isset($_GET[id])){
        $_SESSION[rep]=$_GET[id];
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
        $conduct=$_POST[conduct];		
        $attitude=$_POST[attitude];		
        $interest=$_POST[interest];		
         
        $class_teacher=$_POST[class_teacher];
        $head_teacher=$_POST[head_teacher];
        $promoted=$_POST[promoted];
         
	$counter=  $_POST['upper'];
		   
   for($i=0;$i<$counter;$i++){
 

        $student=$indexno[$i];

        $class=$class_id[$i];
        $attend_=$attend[$i];
        $conduct_=$conduct[$i];		
        $attitude_=$attitude[$i];		
        $interest_=$interest[$i];		
         
        $class_teacher_=$class_teacher[$i];
        $head_teacher_=$head_teacher[$i];
        $promoted_=$promoted[$i];
 
        $dates=date('M/Y');
        
            if($teacher->USER_TYPE=="Administrator"){
                $query=$sql->Prepare("update tbl_class_members set attendance='$attend_',conduct='$conduct_',interest='$interest_',attitude='$attitude_' ,promotedTo='$promoted_',form_mast_report='$class_teacher_',head_mast_report='$head_teacher_' where  id='$class'");

            }

            elseif($teacher->USER_TYPE=="Teacher"){

             $query=$sql->Prepare("update tbl_class_members set attendance='$attend_',conduct='$conduct_',interest='$interest_',attitude='$attitude_' ,promotedTo='$promoted_',form_mast_report='$class_teacher_',head_mast_report='$head_teacher_' where  id='$class'");

            }
            elseif($teacher->USER_TYPE=="Head Teacher"){

             $query=$sql->Prepare("update tbl_class_members set attendance='$attend_',conduct='$conduct_',interest='$interest_',attitude='$attitude_' ,promotedTo='$promoted_',form_mast_report='$class_teacher_',head_mast_report='$head_teacher_' where  id='$class'");
              }      
             
              $sql->Execute($query);



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
				Prepare Reports
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
                                    <select class='form-control'     name="class"   style="margin-left:6%;Width:160px" onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?classes='+escape(this.value);">
                                 <option value=''>Filter by class</option>
                                          <option value='All Classes'>All Classes</option>
                                      <?php 
                                global $sql;

                                      $query2=$sql->Prepare("SELECT * FROM tbl_classes");


                                      $query=$sql->Execute( $query2);


                                   while( $rtmtow = $query->FetchRow())
                                     {

                                     ?>
                                     <option value="<?php echo $rtmtow['name']; ?>"  <?php if($_SESSION[classes]==$rtmtow['name']){echo 'selected="selected"'; }?>      ><?php echo $rtmtow['name']; ?></option>

                               <?php }?>
                                        </select>

                            </td>
                             
				  
                      
                    <td>&nbsp;</td>
                      <td width="20%">

                        <select class='form-control'  name='term'  style="margin-left:-25%;  width:168px " onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?term='+escape(this.value);" >
                                         <option value=''>Filter by term</option>
                                        <option value='All Terms'>All Terms</option>
                                            <option value='1'<?php if($_SESSION[term]=='1'){echo 'selected="selected"'; }?>>1</option>
                                            <option value='2'<?php if($_SESSION[term]=='2'){echo 'selected="selected"'; }?>>2</option>
                                        <option value='3'<?php if($_SESSION[term]=='3'){echo 'selected="selected"'; }?>>3</option>

                                    </select>

                     </td>
                    <td>&nbsp;</td>
                    <td width="30%">

                                <select class='form-control'  name='year'  style="margin-left:-14%; width:168px" onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?year='+escape(this.value);" >
                                                 <option value=''>Filter by academic year</option>
                                                <option value='All Years'>All Years</option>
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
                                    <th style="text-align:center" data-type="string" data-column-id="Total Score" style="text-align:center">Total Score</th>
                                   
                                    <th data-column-id="Attendance" data-order="asc" style="text-align:center">Attendance</th>
                                    <th data-column-id="Conduct" style="text-align: ">Conduct</th>
                                     <th data-column-id="Attitude">Attitude</th>
                                    <th data-column-id="Interest" data-order="asc" style="text-align: ">Interest</th>
                                
                                     <th data-column-id="Class teacher Report" data-order="asc" style="text-align: ">Class Teachers Report</th>
                                      <th data-column-id="Headmaster Report" data-order="asc" style="text-align: ">Head Teachers Report</th>
                                       <th data-column-id="Promoted" data-order="asc" style="text-align: ">Promoted to</th>
                                      <th data-column-id="Position" data-order="asc" style="text-align: ">Position</th>
                                </tr>
                            </thead>
                            <tbody>
     <form id="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <?php 
//$_SESSION[currentterm]="";
//include 'connect.php';
                if($_SESSION[rep]=="ALL" or !$_SESSION[rep]){$inse="" ; } else {$inse=" and tbl_class_members.class='$_SESSION[rep]'";}
                if($teacher->USER_TYPE=="Administrator"){}else{
                $and="and  tbl_classes.teacherId='$teacher->EMP_NUMBER'";
                }
                 $query=$sql->Prepare("SELECT DISTINCT  total,position,attendance,house_mast_report,conduct,interest,attitude,form_mast_report,head_mast_report,tbl_class_members.class,promotedTo,surname,othernames,tbl_class_members.id as id,tbl_student.indexno as idd from tbl_class_members,tbl_student,tbl_classes   where tbl_class_members.year='$school->YEAR' and tbl_class_members.term ='$school->TERM' and tbl_class_members.student=tbl_student.indexno    $and $inse");		
                $query=$query." ORDER BY total desc,tbl_student.surname asc";
               // print_r($query);
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
                    <input type="hidden" name="student[]" id="stu<?php echo $thecounter ?>" value="<?php echo $rtmt[sid];?>" />
                    <input type="hidden" name="class[]" id="idd<?php echo $thecounter ?>" value="<?php echo $rtmt[id];?>" />
                    <input type="hidden" name="index[]" id="index<?php echo $thecounter ?>" value="<?php echo $rtmt[idd];?>" /></td>
                 <input type="hidden" name="upper" value="<?php echo $count;?>" id="upper" />
                <td><strong><?php echo ($rtmt["class"]); ?></strong></td>
                <td><strong><?php echo ($rtmt[total]); ?></strong></td>
                
                <td ><label><strong>
                  <input name="attendance[]"  <?php if($teacher->USER_TYPE=="Housemaster"){echo 'disabled="disabled"';}?>  type="text" id="attendance<?php echo $thecounter ?>" size="8" maxlength="8" value="<?php echo $rtmt[attendance] ?>" />
                </strong></label></td>
                <td style="text-align:left"> 
                    <select class=''  name='conduct[]' onClick="beginEditing(this);" onBlur="finishEditing();"    >
                        <option value=''>select conduct</option>
                               <?php 
                            global $sql;

                                  $query2=$sql->Prepare("SELECT DISTINCT con FROM conduct");


                                  $query=$sql->Execute( $query2);


                               while( $row = $query->FetchRow())
                                 {

                                 ?>
                                 <option value="<?php echo $row['con']; ?>"  <?php if($row['con']==$rtmt[conduct]){echo 'selected="selected"'; } ?>     ><?php echo $row['con']; ?></option>

                           <?php }?>

                   </select>
                   
                </td>
                <td><select class=''  name='attitude[]'  onClick="beginEditing(this);" onBlur="finishEditing();"  >
                        <option value=''>select attitude</option>
                               <?php 
                            global $sql;

                                  $query2=$sql->Prepare("SELECT DISTINCT att FROM attitude");


                                  $query=$sql->Execute( $query2);


                               while( $row = $query->FetchRow())
                                 {

                                 ?>
                                 <option value="<?php echo $row['att']; ?>"  <?php if($row['att']==$rtmt[attitude]){echo 'selected="selected"'; } ?>     ><?php echo $row['att']; ?></option>

                           <?php }?>

                   </select></td>
                <td><select name="interest[]" <?php if($teacher->USER_TYPE!="Teacher"){echo 'disabled="disabled"';}?>  onClick="beginEditing(this);" onBlur="finishEditing();">
                 <option value=''>select interest</option>
                               <?php 
                            global $sql;

                                  $query2=$sql->Prepare("SELECT DISTINCT interest FROM interest");


                                  $query=$sql->Execute( $query2);


                               while( $row = $query->FetchRow())
                                 {

                                 ?>
                                 <option value="<?php echo $row['interest']; ?>"  <?php if($row['interest']==$rtmt[interest]){echo 'selected="selected"'; } ?>     ><?php echo $row['interest']; ?></option>

                           <?php }?>

                </select></td>
                 
                <td><label><strong>
                  <select name="class_teacher[]" <?php if($teacher->USER_TYPE!="Teacher" ){echo 'disabled="disabled"';}?>  onClick="beginEditing(this);" onBlur="finishEditing();">
                 <option value=''>select class teacher's</option>
                               <?php 
                            global $sql;

                                  $query2=$sql->Prepare("SELECT DISTINCT con FROM class_teacher_report");


                                  $query=$sql->Execute( $query2);


                               while( $row = $query->FetchRow())
                                 {

                                 ?>
                                 <option value="<?php echo $row['con']; ?>"  <?php if($row['con']==$rtmt["form_mast_report"]){echo 'selected="selected"'; } ?>     ><?php echo $row['con']; ?></option>

                           <?php }?>

                </select>
                </strong></label>
                
                </td>
                <td><select name="head_teacher[]" <?php if($teacher->POSITION!="Head Teacher" || $teacher->USER_TYPE!="Teacher"  ){echo 'disabled="disabled"';}?>  onClick="beginEditing(this);" onBlur="finishEditing();">
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
                <td><label>
                  <select name="promoted[]" <?php if($teacher->USER_TYPE!="Teacher" ){echo 'disabled="disabled"';}?>   >
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
                </label></td>
                <td><div align="center"><strong><?php echo $rtmt[position]; ?> </strong></div>
                    <strong>
                      <label></label>
                  </strong></td>
                  <td ><img src="images/print_2.png" alt="sa" title="Click to print report card"width="33" height="24" onclick="MM_openBrWindow('report_card.php?indexno=<?php echo $rtmt[idd]; ?>','','menubar=yes,scrollbars=yes,resizable=yes,width=950,height=900')" /></td>
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
