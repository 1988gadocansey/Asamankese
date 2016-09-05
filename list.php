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
      if(isset($_POST[submit])){
           
          // for grade guild table -- it represents the values set for calculations
          // sets for each course in a term and in an academic year
                  $qu1=$_POST[test1];
		  $qu2=$_POST[test2];
		  $qu3=$_POST[test3];
		  $qu4=$_POST[test4];
                   
            /// ////////////////////////////////////////////////////////////
             // grade table area //
            ////////////////////////////////////////////////////////////////
           $count=$_POST[upper];
           $student_id=$_POST[stuid];
           $id=$_POST[id];
           $indexno=$_POST[indexno];
           $test1=$_POST[q1];
           $test2=$_POST[q2];
           $test3=$_POST[q3];
           $exam=$_POST[exam];
           $seventy=$_POST[seventy];
            $thirty=$_POST[thirty];
           $grade_value=$_POST[grade];
           $comment=$_POST[comment];
           for($i=0;$i<$count;$i++){
               // getting each array
                $student_id_=$student_id[$i];
                $id_=$id[$i];
                $indexno_=$indexno[$i];
                $grade_value_=$grade_value[$i];
                $comment_=$comment[$i];
                $thirty_=$thirty[$i];
                $test1_=number_format($test1[$i], 2, '.', ',');
                $test2_=number_format($test2[$i], 2, '.', ',');
                $test3_=number_format($test3[$i], 2, '.', ',');
                $exam_=number_format($exam[$i], 2, '.', ',');
                $seventy_=number_format($seventy[$i], 2, '.', ',');
                 $total=$thirty_+ $seventy_;
                 ////////////////////////////////////////////
                //update students total score in that class for that year inside the class records which is == to the total of all scores in all courses taken in that year
	       //first select the total of total scores of all scores in all subject in that year
                
                    $stmt1=$sql->Prepare("select sum(total) as total,class from tbl_assesments where stuId='$student_id_' and year='$school->YEAR' and term='$school->TERM'");
                   //print_r($stmt1);
                    $a=$sql->Execute($stmt1);
                    
                     $row=$a->FetchRow() ;
             	 
                        $queryIn=$sql->Prepare("SELECT * from tbl_class_members WHERE year='$school->YEAR' AND term='$school->TERM' AND STUDENT='$indexno_'   ");
                       // print_r($queryIn);
                        $outputQuery=$sql->Execute($queryIn);
                        if($outputQuery->RecordCount()==1){
                            $stmt=$sql->Prepare("update tbl_class_members set total='$row[total]' where STUDENT='$indexno_' and  year='$school->YEAR' and term='$school->TERM'")  ;
                 
                        }
                        else{
                            $stmt=$sql->Prepare("INSERT INTO tbl_class_members set total='$row[total]', STUDENT='$indexno_' , year='$school->YEAR' , term='$school->TERM',class='$row[class]'")  ;
                 
                        }
                          // print_r($stmt);
                       $sql->Execute($stmt);
                    
                        
                    
                    
                    $rtmt=$sql->Prepare("UPDATE tbl_assesments SET test1='$test1_',test2='$test2_',test3='$test3_',exam='$exam_',total='$total',comments='$comment_' , grade='$grade_value_' ,entered_by='$_SESSION[ID]' WHERE id='$id_'") ;
                   // print_r($rtmt);
                    $sql->Execute($rtmt);
           }
                    ////////////////////////////////////////////////////////////
                    // Starting position in subject
                    ////////////////////////////////////////////////////////////
                    
                    $query2=$sql->Prepare("SELECT tbl_assesments.id as id,tbl_assesments.total as total from tbl_student,tbl_assesments,tbl_courses where tbl_assesments.year='$school->YEAR' and tbl_assesments.term='$school->TERM'  and tbl_assesments.stuId=tbl_student.ID and tbl_assesments.courseId=tbl_courses.id and tbl_courses.id='".$session->get('SUBJECT')."'  and tbl_courses.classId='".$session->get('CLASS')."' ORDER BY tbl_assesments.total desc");		
                    
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
                          $in_=$sql->Prepare("update tbl_class_members  set position ='$po' where student='$r[student]' AND year='$school->YEAR' and term='$school->TERM'");
                          //print_r($in_);
                          $sql->Execute($in_);

                      }
      
            echo "<script>alert('Please click the reculculate button down. is very important')</script>";
           
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
      

        function check(){
                  if(document.getElementById('exams').value >100 || document.getElementById('cwork').value >100 ){

                  alert('Score can not be greater than 100');
                  document.getElementById('exams').value="";
                   document.getElementById('cwork').value="";
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
                               <!--<?php if($teacher->USER_TYPE=='Administrator'){ ?> <button data-toggle="modal" href="#modalWider" class="btn bgm-pink waves-effect">Create new user</button><?php }?>-->
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
                                  Total Student = <?php echo $student->getTotalStudent_by_Class($_GET['class'],$school->YEAR,$school->TERM) ?> &nbsp;| &nbsp; 
                              </td>
                              <td>
                                  &nbsp;Total Male = <?php echo $student->getTotalStudent_by_gender("Male",$session->get("CLASS"))?> 
                               
                              </td>
                            
                            <td>
                                &nbsp;| &nbsp;  &nbsp;Total Female = <?php echo $student->getTotalStudent_by_gender("Female",$session->get("CLASS"))?>
                            </td>
                             <td>
                                &nbsp;| &nbsp;  &nbsp;Subject = <?php echo  $_GET[name]?>
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
                           <!-- <Td>
                                <a href="excel.php?form=<?php echo $session->get("CLASS"); ?>&amp;course=<?php echo $session->get("SUBJECT"); ?>" ><img src='images/excel.png' width="24"/> Export to excel</a>
                            </Td>
                            <Td></Td>
                            </tr>-->
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
                                 
                                
                              </div>Class Score</th>
                               
                              <th style="text-align: center;display: none" >Total Class Score</th>
                              <th style="text-align: center;display: none" >30% Class score</th>
                              <th style="text-align: center" >Exam Score</th>
                              <th style="text-align: center;display: none" >70% </th>
                              <th style="text-align: center" >Total (30% + 70%)</th>
                              <th style="text-align: center" >Grade</th>
                             
                              <th  style="text-align:" ><div align="">Comments</div></th>
                               <th style="text-align: center" >Position</th>
                            </thead>
                            <tbody>
                                <?php
                                 $query2="SELECT  tbl_assesments.id AS id,stuId,total,posInSubject ,indexno ,tbl_student.id AS stid,tbl_student.surname AS surname,tbl_student.othernames AS othernames,test1,test2,test3,exam,comments,posInSubject from tbl_student,tbl_assesments,tbl_courses where tbl_assesments.year='$school->YEAR' AND tbl_assesments.term='$school->TERM' AND tbl_assesments.class=tbl_courses.classId AND tbl_assesments.stuId=tbl_student.ID AND tbl_assesments.courseId=tbl_courses.id AND tbl_assesments.class='$_GET[class]' AND tbl_assesments.courseId='$_GET[subject]' ORDER BY tbl_student.GENDER desc,SURNAME";
                                //print_r($query2);
                                 $rs = $sql->PageExecute($query2,RECORDS_BY_PAGE,CURRENT_PAGE);
                                $count=0;
                               
                                while($rt=$rs->FetchRow()){
                                    $count++;
                                    ?>
                                    <input type="hidden" value="<?php echo  $rs->_maxRecordCount; ?>" name="counter"/>
                                     <input type="hidden" name="indexno[]" id="stu" value="<?php echo $rt[indexno];?>" />
                                     <input type="hidden" name="stuid[]" id="stu" value="<?php echo $rt[stuId];?>" />
                                     <input type="hidden" name="id[]" id="idd" value="<?php echo $rt[id];?>" />
                                    <tr>
                                        <td style="text-align: center"><?php echo $count ?></td>
                                        <td style="text-align:  "><?php echo $rt[indexno] ?></td>
                                         
                                        <td style="text-align: left"><?php echo $rt[surname].",".$rt[othernames] ?></td>
                                        <td style="text-align: center"><input name="q1[]"     type="text" class="work" size="5" maxlength="3" value="<?php echo $rt[test1]; ?>" /></td>
                                         
                                        <td style="text-align: center;display: none"><div align="center"><strong><?php echo ($rt[test1]+$rt[test2]+$rt[test3]+$rt[test4]); ?></strong></td>
                                        <td style="text-align: center;display: none"><div align="center"><strong><?php $a= ($rt[test1]+$rt[test2]+$rt[test3]+$rt[test4])* 0.3;echo $a ?></strong></td>
                                        <input type="hidden" name="thirty[]" value="<?php echo  ($rt[test1]+$rt[test2]+$rt[test3]+$rt[test4])* 0.3; ?>"/>
                                        <td style="text-align: center"><input name="exam[]" type="text"   class="work" size="10" maxlength="3" value="<?php echo $rt[exam] ?>" /></td>
                                        
                                        <td  style="text-align: center;display: none"><div align="center"><strong><input type="hidden" value="<?php echo  ($rt[exam]/100) * 70 ?>" name="seventy[]"><?php $b=($rt[exam]/100) * 70 ;echo $b ?></strong></div></td>
                                        <td style="text-align: center"><div align="center"><strong><?php echo $a+$b; ?></strong></td>
                                        <td style="text-align: center"><?php  $rmt= $grade->getGradeValue($rt[total]); echo $rmt->GRADE ?><input type="hidden" name="grade[]" value="<?php  echo $rmt->GRADE ?>"/></td>
                                        <td style="text-align:"><input type="hidden" name="comment[]" value="<?php  echo $rmt->COMMENT ?>"/><?php  echo $rmt->COMMENT ?></td> 
                                       
                                         <td style="text-align: center"><?php echo $rt['posInSubject']; ?></td>
                                       
                                     </tr>
                                <?php }?>
                            </tbody>
                          </table>
                          
                              <center><div style="position: fixed;  bottom: 0px;left: 50%  ">
                                <p >
                                  <input type="hidden" name="upper" value="<?php echo $count++;?>" id="upper" />
                                  <label>
                                    <input  type="submit" name="submit" id="submit" class="btn btn-success" value="Save"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    </label>
                                     <label>
                                    <input  type="submit" name="submit" id="submit" class="btn btn-primary btn-sm" value="Recalculate Grade"/>
                                    </label>
                                 <!-- <label>
                                    <input type="submit" name="button" id="button" class="btn btn-warning btn-lg" value="RESET" />
                                    </label>-->
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
    <script>
            $('.work').blur(function() {
                 
   if(parseInt($(this).val()) > 100) {
       alert('Mark cannot be greater than 100');
       $(this).val('');
       $(this).focus();
   }
});
          
          </script>
 <script src="vendors/bootgrid/jquery.bootgrid.min.js"></script>
       
          <script src="vendors/bootgrid/jquery.bootgrid.min.js"></script>
       
        
        <?php $app->exportScript() ?>
          
    </body>
  
</html>
