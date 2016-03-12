 <?php
     ini_set('display_errors',0);
     require 'vendor/autoload.php';
     include "library/includes/config.php";
     include "library/includes/initialize.php"; 
     include('parsecsv.lib.php');
     $help=new classes\helpers();
     $school=new classes\School();
     $school=$school->getAcademicYearTerm();
     $student=new classes\Student();
       		   
     $app=new classes\structure();
      
     $notify=new classes\Notifications();
     $app->gethead();
     $teacher=new classes\Teacher();  $teacher=$teacher->getTeacher_ID($_SESSION[ID]);

     $session->set("CLASS",$_GET['class']);
     $session->set("SUBJECT",$_GET['subject']);
     $grade=new classes\Grades();
     if (isset($_POST[submit])) {
       $upper=$_POST[upper];
		 
		 
		  
		  for($i=1;$i<$upper;$i++){
$idd="idd$i";			
$stu="stu$i";
$q1="q1$i";
$q2="q2$i";
$q3="q3$i";
$q4="q4$i";
$exam="exam$i";

$c1="c1$i";
$c2="c2$i";
$c3="c3$i";
$c4="c4$i";
$ce="ce$i";
$grade="grade$i";
$comment="comment$i";

// $comments="comments$i";				


$stud="stu$i";

$id=$_POST[$idd];

$quiz1=$quiz1;

$exam=number_format($_POST[$exam]*.70, 1, '.', ',');
$quiz1=number_format($_POST[$q1], 1, '.', ',');
$quiz2=number_format($_POST[$q2], 1, '.', ',');
$quiz3=number_format($_POST[$q3], 1, '.', ',');
$grades=$_POST[$grade];
$comments=$_POST[$comment];
$oldexam=number_format($_POST[$ce]*.70, 1, '.', ',');
$oldquiz1=number_format($_POST[$c1], 1, '.', ',');
$oldquiz2=number_format($_POST[$c2], 1, '.', ',');
$oldquiz3=number_format($_POST[$c3], 1, '.', ',');
//$comments=$_POST[$comments];
$student=$_POST[$stud];
		  $tot=$quiz1+$quiz2+$quiz3+$exam;
	//update grades in quizes and exan and total
	//echo " oldquiz1:$oldquiz1 quiz1:$quiz1 oldquiz2:$oldquiz2 quiz2:$quiz2 oldquiz3:$oldquiz3 quiz3:$quiz3 oldexam:$oldexam exam:$exam ";
			//echo "<br/>";
	$update='';
	if($oldquiz1!=$quiz1 ){ $update=" test1=\"$quiz1\" ,";}
	if($oldquiz2!=$quiz2){ $update.=" test2=\"$quiz2\" ,";}
	if($oldquiz3!=$quiz3 ){ $update.=" test3=\"$quiz3\" ,";}
	if($oldexam!=$exam ){ $update.=" exam=\"$exam\" ,";}
	
	if($update){
		
	  $query=$sql->Prepare("update tbl_assesments set $update  total=\"$tot\", comments='$comments' , grade='$grades' where  id=\"$id\"");
	 
	 $sql->Execute($query);
	 
         
         $stmt1=$sql->Prepare("select sum(total) as total from tbl_assesments where stuId='$student' and year='$school->YEAR' and term='$school->TERM'");
                    $a=$sql->Execute($stmt1);
                    
                    while($row=$a->FetchRow()){
                         $studentNo=$help->getIndex($student);
                        $stmt=$sql->Prepare("update tbl_class_members set total='$row[total]' where STUDENT='$studentNo' and  year='$school->YEAR' and term='$school->TERM'")  ;
                    
                        $sql->Execute($stmt);
                    
                        
                    }
         
         
         
         
         
         
         
	}
		  
        
    }
    
  ////////////////////////////////////////////////////////////
                    // Starting position in subject
                    ////////////////////////////////////////////////////////////
                    
                    $query2=$sql->Prepare("SELECT tbl_assesments.id as id,tbl_assesments.total as total from tbl_student,tbl_assesments,tbl_courses where tbl_assesments.year='$school->YEAR' and tbl_assesments.term='$school->TERM'  and tbl_assesments.stuId=tbl_student.ID and tbl_assesments.courseId=tbl_courses.id and tbl_courses.name='".$session->get('SUBJECT')."'  and tbl_courses.classId='".$session->get('CLASS')."' ORDER BY tbl_assesments.total desc");		
                    
                    $query1=$sql->Execute($query2);
                     $inde=0;
                     
                     $row=$query1->RecordCount();
                     $oldtotal=-1;
                     $repeat=0;
                    while($ra=$query1->FetchRow()){
                    $inde++;
                    $currentotal=$ra['total'];
                     
                    if($oldtotal==$currentotal){}else{$in=$inde; }
                     $oldtotal=$currentotal;
                     $po=$in."/".$row;
                    
                      $stmt=$sql->Prepare("update tbl_assesments set posInSubject='$po' where id='$ra[id]'") ;
                     
                      print_r($stmt);
                      $sql->Execute($stmt);

                     }
                     
                     ////////////////////////////////////////////////////////////////////////
                     // starting overall position in class ie class average
                     /////////////////////////////////////////////////////////////////////////
                     
                        $input1=$sql->Prepare("SELECT id,total,student from tbl_class_members where class='".$session->get('CLASS')."' and year='$school->YEAR' and term='$school->TERM' ORDER BY total desc");
                    
                        $input_=$sql->Execute($input1);
                     
                        $inde=0;
 
                        $row=$input_->RecordCount();
                        while($r=$input_->FetchRow()){

                        $inde++;
                        $currentotal=$r['total'];
                        if($oldtotal==$currentotal){}else{$in=$inde; }
                         $oldtotal=$currentotal;

                          $po=$in."/".$row;
                         //echo "_";
                          $in_=$sql->Prepare("update tbl_class_members  set position ='$po' where student='$r[student]'");
                          $sql->Execute($in_);

                      }	  
         
         
     }

//////////////////////////////////////////////////////////////////////
          // upload excel csv result starts here  ie using the parsecsv library//
          //////////////////////////////////////////////////////////////////////

	  
 ?>
 <link href="vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
   <style>
     .container {
    width: 1549px;
    }
    #assesment  tr:hover{
        
        background-color: #FFFCBE;
    }
    .info {
       background-color: #CDDC39 !important;
       box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.15);
       min-height: 40px;
        
    }
    input{
        text-align: center
    }
    
 </style>
  <script>
      function check(ids,box){
		  
		  var input=document.getElementById(ids).value-0;
		  var checker=document.getElementById(box).value-0;
	   
                    if(input>checker){

                    alert('Score can not be greater than '+checker);
                    document.getElementById(ids).value="";
                    document.getElementById(ids).focus();
                          
                      return false;
                    }
	  
	  }

        function check70(ids){
                  if(document.getElementById(ids).value >100 ){

                  alert('Score can not be greater than 100');
                  document.getElementById(ids).value="";
                  document.getElementById(ids).focus();
                                                 

                    return false;
                  }

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
                      
                    <div class="card">
                        
                        <div class="card-header">
                           <p>
                               Continuous Assesment Section
                            </p>
                          <div style="margin-top:-3%;float:right">
                                <?php if($teacher->USER_TYPE=='Administrator'){ ?> <button data-toggle="modal" href="#modalWider" class="btn bgm-pink waves-effect">Create new user</button><?php }?>
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
                         <div class="info" style="">
                        <div class="row">
                           
                            <table align="center" style="margin-top:9px" border="0">
                                <tr>
                              <td>
                                  Total Student = <?php echo $student->getTotalStudent_by_Class($session->get("CLASS"),$school->YEAR,$school->TERM) ?> &nbsp;| &nbsp; 
                              </td>
                              <td>
                                  &nbsp;Total Male = <?php echo $student->getTotalStudent_by_gender("Male",$session->get("CLASS"))?> 
                               
                              </td>
                            
                            <td>
                                &nbsp;| &nbsp;  &nbsp;Total Female = <?php echo $student->getTotalStudent_by_gender("Female",$session->get("CLASS"))?>
                            </td>
                             <td>
                                &nbsp;| &nbsp;  &nbsp;Subject = <?php echo  $session->get("SUBJECT")?>
                            </td>
                            <td>
                                &nbsp;| &nbsp;  &nbsp;CLASS = <?php echo $session->get("CLASS")?>
                            </td>
                            <td>
                                &nbsp;| &nbsp;  &nbsp;ACADEMIC YEAR  = <?php echo $school->YEAR?>
                            </td>
                            <td>
                                &nbsp;| &nbsp;  &nbsp;TERM = <?php echo $school->TERM?>
                            </td>
                            <td> &nbsp; &nbsp; &nbsp; &nbsp;</td>
                            <Td>
                                <a href="excel.php?form=<?php echo $session->get("CLASS"); ?>&amp;course=<?php echo $session->get("SUBJECT"); ?>" ><img src='images/excel.png' width="24"/> Export to excel</a>
                            </Td>
                            <Td></Td>
                            </tr>
                            </table>
                                 
                        </div>    
                        </div>
                        <p></p>
                        <div class="row">
                            
                       <form action="" method="post">
                        <div  class="table-responsive">
                          <center><table class="table table-bordered " id="assesment" style="width:90%" >
                            <thead>
                            <th style="text-align: center">#</th>
                            <th style="text-align:  ">INDEX NO</th>
                            <th>STUDENT</th>
                            <?php 
                            
                             
                            
                          ?>
                            <th style="text-align: center" ><div align="center">
                                 
                                
                              </div>ClassWork</th>
                              <th style="text-align: center" ><div align="center">
         
                              </div>HomeWork</th>
                              <th style="text-align: center" ><div align="center">
                                  
                              </div>Class Test</th>
                              <th style="text-align: center" >Total Class Score</th>
                              <th style="text-align: center" >30% Class score</th>
                              <th style="text-align: center" >Exam Score</th>
                              <th style="text-align: center" >70% </th>
                              <th style="text-align: center" >Total (30% + 70%)</th>
                              <th style="text-align: center" >Grade</th>
                             
                              <th  style="text-align: center" ><div align="center">Comments</div></th>
                               <th style="text-align: center" >Position</th>
                            </thead>
                            <tbody>
                                <?php
                                 $query2="SELECT  tbl_assesments.id AS id,stuId,total,posInSubject ,indexno ,tbl_student.id AS stid,tbl_student.surname AS surname,tbl_student.othernames AS othernames,test1,test2,test3,exam,comments,posInSubject from tbl_student,tbl_assesments,tbl_courses where tbl_assesments.year='$school->YEAR' AND tbl_assesments.term='$school->TERM' AND tbl_assesments.class=tbl_courses.classId AND tbl_assesments.stuId=tbl_student.ID AND tbl_assesments.courseId=tbl_courses.id AND tbl_courses.classId='$_GET[class]' AND tbl_assesments.courseId='$_GET[subject]' ";
                                // print_r($query2);
                                 $rs = $sql->PageExecute($query2,RECORDS_BY_PAGE,CURRENT_PAGE);
                                $counter=1;
                               
                                while($rt=$rs->FetchRow()){
                                    $thecounter=$counter++ ;
                                    ?>
                                    <input type="hidden" value="<?php echo  $rs->_maxRecordCount; ?>" name="counter"/>
                                     <input type="hidden" name="indexno[]" id="stu" value="<?php echo $rt[indexno];?>" />
                                     <input type="hidden"   name="stu<?php echo $thecounter ?>" id="stu" value="<?php echo $rt[id];?>" />
                                     <input type="hidden" name="idd<?php echo $thecounter ?>" id="idd" value="<?php echo $rt[id];?>" />
                                    <tr>
                                        <td style="text-align: center"><?php echo $counter ?></td>
                                        <td style="text-align:  "><?php echo $rt[indexno] ?></td>
                                        <td style="text-align: left"><?php echo $rt[surname].",".$rt[othernames] ?></td>
                                        <td style="text-align: center"><input  name="q1<?php echo $thecounter ?>" type="text" id="q1<?php echo $thecounter ?>" size="5" maxlength="4" value="<?php echo $rt[test1]; ?>" /></td>
                                        <input type="hidden" name="c1<?php echo $thecounter ?>" id="c1<?php echo $thecounter ?>" value="<?php echo $rt[test1]; ?>" />
            
                                        <td style="text-align: center"> <input name="q2<?php echo $thecounter ?>"   type="text" id="q2<?php echo $thecounter ?>" size="5" maxlength="4" value="<?php echo $rt[test2]; ?>" /></td>
                                        <input type="hidden" name="c2<?php echo $thecounter ?>" id="c1<?php echo $thecounter ?>" value="<?php echo $rt[test2]; ?>" />
            
                                        
                                        <td style="text-align: center"><input name="q3<?php echo $thecounter ?>"    type="text" id="q3<?php echo $thecounter ?>" size="5" maxlength="4" value="<?php echo $rt[test3]; ?>" /></td>
                                        <input type="hidden" name="c3<?php echo $thecounter ?>" id="c1<?php echo $thecounter ?>" value="<?php echo $rt[test3]; ?>" />
            
                                        <td style="text-align: center"><div align="center"><strong><?php echo ($rt[test1]+$rt[test2]+$rt[test3]+$rt[test4]); ?></strong></td>
                                        <td style="text-align: center"><div align="center"><strong><?php echo (($rt[test1]+$rt[test2]+$rt[test3]+$rt[test4])/100 * 30); ?></strong></td>
                                        <input type="hidden"   value="<?php echo ($rt[test1]+$rt[test2]+$rt[test3]+$rt[test4])*10/3; ?>"/>
                                        <td style="text-align: center"><input name="exam<?php echo $thecounter ?>" type="text"   id="exam<?php echo $thecounter ?>" size="10" maxlength="4" value="<?php echo $rt[exam] ?>" /></td>
                                        
                                        <td style="text-align: center"><div align="center"><strong><input type="hidden" value="<?php echo  ($rt[exam])* 70/100 ?>" name="ce<?php echo $thecounter ?>"><?php echo ($rt[exam])* 70/100 ?></strong></div></td>
                                        <td style="text-align: center"><div align="center"><strong><?php echo ($rt[total]); ?></strong></td>
                                        <td style="text-align: center"><?php  $rmt= $grade->getGradeValue($rt[total]); echo $rmt->GRADE ?><input type="hidden" name="grade<?php echo $thecounter ?>" value="<?php  echo $rmt->GRADE ?>"/></td>
                                        <td style="text-align: center"><input type="hidden" name="comment<?php echo $thecounter ?>" value="<?php  echo $rmt->COMMENT ?>"/><?php  echo $rmt->COMMENT ?></td> 
                                       
                                         <td style="text-align: center"><?php echo $rt['posInSubject']; ?>&nbsp;</td>
                                       
                                     </tr>
                                <?php }?>
                            </tbody>
                          </table>
                          
                              <center><div style="position: fixed;  bottom: 0px;left: 43%  ">
                                <p >
                                  <input type="hidden" name="upper" value="<?php echo $counter++;?>" id="upper" />
                                  <label>
                                    <input  type="submit" name="submit" id="submit" class="btn btn-success" value="UPDATE RECORDS" />
                                    </label>
                                  <label>
                                    <input type="submit" name="button" id="button" class="btn btn-warning" value="RESET" />
                                    </label>
                                </p>
                                  </div></center>
                          </form>
                          </center>
                        
                        </div>
                                     
                    </div>
                </div>
                </div>
                     
                    
                    
                </div>
            </section>
        </section>
        
         
        <?php  $app->getDashboardScript() ; $app->getuploadScript(); ?>
 <script src="vendors/bootgrid/jquery.bootgrid.min.js"></script>
       
          <script src="vendors/bootgrid/jquery.bootgrid.min.js"></script>
       
        
        <?php $app->exportScript() ?>
    </body>
  
</html>
