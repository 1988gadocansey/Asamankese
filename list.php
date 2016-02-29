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
     $help=new classes\helpers();
     $notify=new classes\Notifications();
     $app->gethead();
     $teacher=new classes\Teacher();  $teacher=$teacher->getTeacher_ID($_SESSION[ID]);

     $session->set("CLASS",$_GET['class']);
     $session->set("SUBJECT",$_GET['subject']);
     $grade=new classes\Grades();
      if(isset($_POST[submit])){
          // for grade guild table -- it represents the values set for calculations
          // sets for each course in a term and in an academic year
                  $qu1=$_POST[quiz1];
		  $qu2=$_POST[quiz2];
		  $qu3=$_POST[quiz3];
		  $qu4=$_POST[quiz4];
                   $stmt=$sql->Prepare("select id from tbl_gradesguide where year='$school->YEAR' and term='$school->TERM' and course='".$session->get('SUBJECT')."' and class='".$session->get('CLASS')."'");
            
                  $stmt=$sql->Execute($stmt);
                  if($stmt->RecordCount()>0){
                      $stmt_=$sql->Prepare("Update tbl_gradesguide set quiz1='$qu1',quiz2='$qu2',quiz3='$qu3' where year='$school->YEAR' and term='$school->TERM' and course='".$session->get('SUBJECT')."'  and class='".$session->get('CLASS')."'");
                        $sql->Execute($stmt_);
                   }
                   else{
                        $stmt_=$sql->Prepare("insert into  tbl_gradesguide set quiz1='$qu1',quiz2='$qu2',quiz3='$qu3' ,  year='$school->YEAR'  ,term='$school->TERM' ,course='".$session->get('SUBJECT')."',   class='".$session->get('CLASS')."'");
                        $sql->Execute($stmt_);
                   }
            /// ////////////////////////////////////////////////////////////
             // grade table area //
            ////////////////////////////////////////////////////////////////
           $count=$_POST[counter];
           $student_id=$_POST[stuid];
           $indexno=$_POST[indexno];
           $quiz1=$_POST[q1];
           $quiz2=$_POST[q2];
           $quiz3=$_POST[q3];
           $exam=$_POST[exam];
           $seventy=$_POST[seventy];
            $thirty=$_POST[thirty];
           $grade_value=$_POST[grade];
           $comment=$_POST[comment];
           for($i=0;$i<$count;$i++){
               // getting each array
                $student_id_=$student_id[$i];
                $indexno_=$indexno[$i];
                $grade_value_=$grade_value[$i];
                $comment_=$comment[$i];
                $thirty_=$thirty[$i];
                $quiz1_=number_format($quiz1[$i], 2, '.', ',');
                $quiz2_=number_format($quiz2[$i], 2, '.', ',');
                $quiz3_=number_format($quiz3[$i], 2, '.', ',');
                $exam_=number_format($exam[$i], 2, '.', ',');
                $seventy_=number_format($seventy[$i], 2, '.', ',');
                 $total=$thirty_+ $seventy_;
                 ////////////////////////////////////////////
                //update students total score in that class for that year inside the class records which is == to the total of all scores in all courses taken in that year
	       //first select the total of total scores of all scores in all subject in that year
                
                    $stmt1=$sql->Prepare("select sum(total) as total from tbl_grades where stuId='$student_id_' and year='$school->YEAR' and term='$school->TERM'");
                    $a=$sql->Execute($stmt1);
                    
                    while($row=$a->FetchRow()){
             
                        $stmt=$sql->Prepare("update tbl_class_members set total='$row[total]' where STUDENT='$indexno_' and  year='$school->YEAR' and term='$school->TERM'")  ;
                    
                        $sql->Execute($stmt);
                    
                        
                    }
                    
                    $rtmt=$sql->Prepare("UPDATE tbl_grades SET quiz1='$quiz1_',quiz2='$quiz2_',quiz3='$quiz3_',exam='$exam_',total='$total',comments='$comment_' , grade='$grade_value_' WHERE id='$student_id_'") ;
                    print_r($rtmt);
                    $sql->Execute($rtmt);
          
                    ////////////////////////////////////////////////////////////
                    // Starting position in subject
                    ////////////////////////////////////////////////////////////
                    
                    $query1=$sql->Prepare("SELECT tbl_grades.id as id,tbl_grades.total as total from tbl_student,tbl_grades,tbl_courses where tbl_grades.year='$school->YEAR' and tbl_grades.term='$school->TERM'  and tbl_grades.stuId=tbl_student.ID and tbl_grades.courseId=tbl_courses.id and tbl_courses.name='".$session->get('SUBJECT')."'  and tbl_courses.classId='".$session->get('CLASS')."' ORDER BY tbl_grades.total desc");		
                    
                    $query1=$sql->Execute($query1);
                     $inde=0;
                     
                     $row=$query1->RecordCount();
                     $oldtotal=-1;
                     $repeat=0;
                    while($ra=$query1->FetchRow()){
                    $inde++;
                    $currentotal=$ra['total'];
                    //check if there is a tie then dont change pos else increse position
                    if($oldtotal==$currentotal){}else{$in=$inde; }
                     $oldtotal=$currentotal;
                     $po=$in."/".$row;
                    
                      $stmt=$sql->Prepare("update tbl_grades set posInSubject='$po' where id='$ra[id]'") ;
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
                        //check if there is a tie then dont change pos else increse position
                        if($oldtotal==$currentotal){}else{$in=$inde; }
                         $oldtotal=$currentotal;

                          $po=$in."/".$row;
                         //echo "_";
                          $in_=$sql->Prepare("update tbl_class_members  set position ='$po' where student='$r[student]'");
                          $sql->Execute($in_);

                      }
      
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
                            
                            $stmt2=$sql->Prepare("select * from tbl_gradesguide where year='$school->YEAR' and term='$school->TERM' and course='$_GET[subject]' and class='$_GET[class]'") ;
                            
                            $stmt=$sql->Execute($stmt2);
                             
                            while($row=$stmt->FetchRow()){
                                $quiz1=$row["quiz1"];
                                $quiz2=$row["quiz2"];
                                $quiz3=$row["quiz3"];
                            }
                            
                          ?>
                            <th style="text-align: center" ><div align="center">
                                <label for="quiz1"></label>
                                <input name="quiz1" type="text" style="width:62%" id="quiz1" size="2" value="<?php echo $quiz1; ?>" />
                              </div></th>
                              <th style="text-align: center" ><div align="center">
                                <input name="quiz2" type="text" style="width:62%" id="quiz2" size="2" value="<?php echo $quiz2; ?>" />
                              </div></th>
                              <th style="text-align: center" ><div align="center">
                                  <input name="quiz3" type="text" style="width:62%" id="quiz3" size="2" value="<?php echo $quiz3; ?>"/>
                              </div></th>
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
                                 $query2=$sql->Prepare("SELECT  tbl_grades.id AS id,stuId,total,posInSubject ,indexno ,tbl_student.id AS stid,tbl_student.surname AS surname,tbl_student.othernames AS othernames,quiz1,quiz2,quiz3,exam,comments,posInSubject from tbl_student,tbl_grades,tbl_courses where tbl_grades.year='$school->YEAR' AND tbl_grades.term='$school->TERM' AND tbl_grades.class=tbl_courses.classId AND tbl_grades.stuId=tbl_student.ID AND tbl_grades.courseId=tbl_courses.id AND tbl_courses.classId='$_GET[class]' AND tbl_courses.name='$_GET[subject]' ");
                                 print_r($query2);
                                 $query=$sql->Execute($query2);
                                $count=0;
                               echo  $total_record=$query->RecordCount();
                                while($rt=$query->FetchRow()){
                                    $count++;
                                    ?>
                                    <input type="hidden" value="<?php echo $total_record; ?>" name="counter"/>
                                     <input type="hidden" name="indexno[]" id="stu" value="<?php echo $rt[indexno];?>" />
                                     <input type="hidden" name="stuid[]" id="stu" value="<?php echo $rt[id];?>" />
                                     <input type="hidden" name="id[]" id="idd" value="<?php echo $rt[id];?>" />
                                    <tr>
                                        <td style="text-align: center"><?php echo $count ?></td>
                                        <td style="text-align:  "><?php echo $rt[indexno] ?></td>
                                        <td style="text-align: left"><?php echo $rt[surname].",".$rt[othernames] ?></td>
                                        <td style="text-align: center"><input name="q1[]"  onblur="return check(this.id,'quiz1')" type="text" id="q1<?php echo $thecounter ?>" size="5" maxlength="4" value="<?php echo $rt[quiz1]; ?>" /></td>
                                        <td style="text-align: center"> <input name="q2[]"  onblur="return check(this.id,'quiz2')" type="text" id="q2<?php echo $thecounter ?>" size="5" maxlength="4" value="<?php echo $rt[quiz2]; ?>" /></td>
                                        <td style="text-align: center"><input name="q3[]"  onblur="return check(this.id,'quiz3')" type="text" id="q3<?php echo $thecounter ?>" size="5" maxlength="4" value="<?php echo $rt[quiz3]; ?>" /></td>
                                        
                                        <td style="text-align: center"><div align="center"><strong><?php echo ($rt[quiz1]+$rt[quiz2]+$rt[quiz3]+$rt[quiz4]); ?></strong></td>
                                        <td style="text-align: center"><div align="center"><strong><?php echo (($rt[quiz1]+$rt[quiz2]+$rt[quiz3]+$rt[quiz4])/100 * 30); ?></strong></td>
                                        <input type="hidden" name="thirty[]" value="<?php echo (($rt[quiz1]+$rt[quiz2]+$rt[quiz3]+$rt[quiz4])/100 * 30); ?>"/>
                                        <td style="text-align: center"><input name="exam[]" type="text" onblur="return check70(this.id)" id="exam<?php echo $thecounter ?>" size="10" maxlength="4" value="<?php echo $rt[exam] ?>" /></td>
                                        
                                        <td style="text-align: center"><div align="center"><strong><input type="hidden" value="<?php echo ($rt[exam]/100) * 70 ?>" name="seventy[]"><?php echo ($rt[exam]/100) * 70 ?></strong></div></td>
                                        <td style="text-align: center"><div align="center"><strong><?php echo ($rt[total]); ?></strong></td>
                                        <td style="text-align: center"><?php  $rmt= $grade->getGradeValue($rt[total]); echo $rmt->GRADE ?><input type="hidden" name="grade[]" value="<?php  echo $rmt->GRADE ?>"/></td>
                                        <td style="text-align: center"><input type="hidden" name="comment[]" value="<?php  echo $rmt->COMMENT ?>"/><?php  echo $rmt->COMMENT ?></td> 
                                       
                                         <td style="text-align: center"><?php echo $rt['posInSubject']; ?>&nbsp;</td>
                                       
                                     </tr>
                                <?php }?>
                            </tbody>
                          </table>
                          
                              <center><div style="position: fixed;  bottom: 0px;left: 43%  ">
                                <p >
                                  <input type="hidden" name="upper" value="<?php echo $count++;?>" id="upper" />
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
       
        <!-- Data Table -->
         <!-- Data Table -->
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
							 var cellValue = row["Class"]+"&&subject="+ row["Subject"];
							return "<a     href=\"list.php?class="+cellValue+"  \"> <span class=\"md md-edit\"></span>   </a>";
						}
						 }
					 

                });
            });
        </script>
        <?php $app->exportScript() ?>
    </body>
  
</html>
