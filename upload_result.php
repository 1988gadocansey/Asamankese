<?php
ini_set('display_errors', 0);
    require 'vendor/autoload.php';
    include "library/includes/config.php";
     include "library/includes/initialize.php";
    $app=new classes\structure();
    $notify=new classes\Notifications();
    $help=new classes\helpers();
    $config = new classes\School();
    $school = $config->getAcademicYearTerm();
     

    function getSub($code){
        global $sql;
        $query=$sql->Prepare("SELECT * FROM tbl_courses WHERE id='$code'");
        $kk=$sql->Execute($query);
        $row=$kk->FetchNextObject();
        return $row->NAME;
    }





     
     
     $student=new classes\Student();
    $grade=new classes\Grades();
    if (isset($_GET[upload]) == "result") {
      $class=$_POST['class'];
     $session->set("CLASS",$_POST['class']);
     $session->set("SUBJECT",$_POST['subject']);
    $year=$_POST['year'];
    $term=$_POST['term'];
    // upload students cv
    //check if file path is empty
    $extension = end(explode(".", basename($_FILES['file']['name'])));
    if ($extension == 'csv') {


        $destination = "uploads/";
        //Import uploaded file to Database
        $handle = fopen($_FILES['file']['tmp_name'], "r");

        move_uploaded_file($_FILES["file"]["tmp_name"], $destination);



        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            
            $num = count($data);

            for ($c = 0; $c < $num; $c++) {
                $col[$c] = $data[$c];
            }
             
             $indexno = $col[1];
             $test1 = $col[2];
            $test2 = $col[3];
             $test3 = $col[4];
            
            $total30 = ($test1+$test2+$test3)*0.3;
            $exam=number_format($col[5]*.70, 1, '.', ',');
            $total=number_format($total30+$exam, 1, '.', ',');
            $rmt= $grade->getGradeValue($total); 
            $gradeMark=$rmt->GRADE;
            $comment=$rmt->COMMENT;
            
            $studentID=$help->getID($indexno);
             
            // SQL Query to insert data into DataBase
            $query = $sql->Prepare("SELECT * FROM tbl_student WHERE INDEXNO='$indexno' AND CLASS='$class'");
            $in=$sql->Execute($query);
            
            if($in->RecordCount()==0){
                echo "<script>alert('Please some students are not in the students list')</script>";
            }else{
                
                
                
                ////////////////////////////////////////////
                //update students total score in that class for that year inside the class records which is == to the total of all scores in all courses taken in that year
	       //first select the total of total scores of all scores in all subject in that year
                
                    $stmt1=$sql->Prepare("select sum(total) as total from tbl_assesments where stuId='$studentID' and year='$school->YEAR' and term='$school->TERM'");
                    
                    $a=$sql->Execute($stmt1);
                    
                    while($row=$a->FetchRow()){
             
                        $stmt=$sql->Prepare("update tbl_class_members set total='$total' where STUDENT='$indexno' and  year='$school->YEAR' and term='$school->TERM'")  ;
                    
                        $sql->Execute($stmt);
                    
                        
                    }
                    
                    $rtmt=$sql->Prepare("UPDATE tbl_assesments SET test1='$test1',test2='$test2',test3='$test3',exam='$exam',total='$total',comments='$comment' , grade='$gradeMark' ,entered_by='$_SESSION[ID]' WHERE stuId='$studentID'AND courseId='".$session->get('SUBJECT')."'AND year='$year' AND term='$term'AND class='".$session->get('CLASS')."'") ;
                    
                    $sql->Execute($rtmt);
                
                  
                 
                
            }
        }
        fclose($handle);
         ////////////////////////////////////////////////////////////
                    // Starting position in subject
                    ////////////////////////////////////////////////////////////
                    
                    $query2=$sql->Prepare("SELECT tbl_assesments.id as id,tbl_assesments.total as total from tbl_student,tbl_assesments,tbl_courses where tbl_assesments.year='$year' and tbl_assesments.term='$term'  and tbl_assesments.stuId=tbl_student.ID and tbl_assesments.courseId=tbl_courses.id and tbl_courses.id='".$session->get('SUBJECT')."'  and tbl_courses.classId='".$session->get('CLASS')."' ORDER BY tbl_assesments.total desc");		
                    
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
                          $in_=$sql->Prepare("update tbl_class_members  set position ='$po' where student='$r[student]'");
                          $sql->Execute($in_);
                          header('location:upload_result.php?success=1');
                
                      }
      
         
    }
    else{
        echo "<script>alert('Please upload only csv files')</script>";
    }
    
    
}










$app->gethead();
     
?>
 
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
                
                     
                    <div class="card">
                        <div class="card-header">
                            <h2><header>UPLOAD BULK STUDENTS RESULTS HERE (Template)</header>
                            </small></h2>
                        </div>
                        
                        <div class="card-body card-padding">
                            <form action="upload_result.php?upload=result" role="form" method="POST" enctype="multipart/form-data">
                                <div class="row" style="overflow: scroll">
                                          <table class="table table-bordered no-margin" style="">
								<thead>
									<tr>
										<th>NO</th>
										<th>INDEXNO</th>
										<th>TEST 1</th>
										 
                                                                                <th>TEST 2</th>
                                                                                <th>TEST 3</th>
                                                                                
                                                                                <th>EXAM</th>
                                                                                
                                                                                
									</tr>
								</thead>
								<tbody>
									 
								</tbody>
							</table>
                                </div>
                                <div class="row">
                                <div class="col-sm-12">
                                     
                                    
                                    <center> <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <span class="btn btn-primary btn-file m-r-10">
                                            <span class="fileinput-new">Select file</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="file" required="">
                                        </span>
                                        <span class="fileinput-filename"></span>
                                        <a href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>
                                        </div></center>
                                </div>
                                    <div class="col-sm-12">
                                        
                                        <div class="form-group">
                                                         <label for="inputEmail3"    class="col-sm-2 control-label">Class</label>
                                                         <div class="col-sm-10">
                                                             <div class="fg-line">
                                                                 <select class='' style="width:240px"   required="" name="class" onChange="getSubject(this.valxue)">
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
                                        <p>&nbsp;</p>
                                                     <div class="form-group">
                                                         <label for="inputPassword3" class="col-sm-2 control-label">Subject</label>
                                                         <div class="col-sm-10">

                                                             <div class="fg-line">
                                                                 <select class='form-control' style="width:240px"  id='subject'   name="subject"  >
                                                                     <option value=''>select subject</option>
                                                                          <?php
                                                                     global $sql;

                                                                     $query2 = $sql->Prepare("SELECT *  FROM   tbl_courses WHERE  year='$school->YEAR' and term='$school->TERM' AND teacherId!=''");


                                                                     $query = $sql->Execute($query2);


                                                                     while ($row = $query->FetchRow()) {
                                                                         ?>
                                                                         <option value="<?php echo $row['id']; ?>" >  <?php echo $row['name'].'-'.$row['classId']; ?></option>

                                                                     <?php } ?>
                                                                      </select>
                                                             </div>
                                                         </div>
                                                     </div>
                                        
                                    </div>
                                     <p>&nbsp;</p>
                                    <div class="col-sm-12">
                                        
                                        
                                                    <div class="form-group">
                                                         <label for="inputPassword3" class="col-sm-2 control-label">Academic year</label>
                                                         <div class="col-sm-10">

                                                             <div class="fg-line">
                                                            <select class=''    required="" name="year" style="width:240px">
                                                                     <option value=''>Academic year</option>
                                                                           
                                                                        <?php
                                                            for ($i = 2015; $i <=2017; $i++) {
                                                                $a = $i - 1 . "/" . $i;
                                                                ?>
                                                                <option <?php if ($_SESSION[yesar] == $a) {
                                                                echo 'selected="selected"';
                                                            } ?>value='<?php echo $a ?>'><?php echo $a ?></option>";

                                                            <?php } ?>


                                                            ?>
                                                                            
                                                            </select>
                                                             </div>
                                                         </div>
                                                     </div>
                                        <p>&nbsp;</p>
                                                      <div class="form-group">
                                                         <label for="inputPassword3" class="col-sm-2 control-label">Term</label>
                                                         <div class="col-sm-10">

                                                             <div class="fg-line">
                                                                 <select class='form-control' style="width:240px"   required="" name="term" >
                                                                    <option value=''>Filter by term</option>
                                                                   <option value='all'>All</option>
                                                                       <option value='1'>1</option>
                                                                       <option value='2'>2</option>
                                                                   <option value='3'>3</option>

                                                               </select>
                                                             </div>
                                                         </div>
                                                     </div>
                                    </div>
                            </div>
                            
                            <div class="col-sm-12">
                                
                                <Center> <button type="submit" class="btn btn-primary btn-sm m-t-10">Upload</button></center>
                            </div>
                            </form>
                            <br/>
                            <br/>
                            
                        </div>
                    </div>
                    
                     
                    
                    
                </div>
            </section>
        </section>
        
       <?php $app->getDashboardScript() ; $app->getuploadScript(); ?>
        
    </body>
  
</html>