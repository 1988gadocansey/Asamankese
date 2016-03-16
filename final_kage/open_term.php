 <?php
 ini_set('display_errors', 0);
    require 'vendor/autoload.php';
    include "library/includes/config.php";
     include "library/includes/initialize.php";
     global $sql;
    $app=new classes\structure();
    $help=new classes\helpers();
    $school=new classes\School();
     $school=$school->getAcademicYearTerm();
    $notify=new classes\Notifications();
    $teacher=new classes\Teacher();
    if(isset($_GET[add])==1){
        $class=$_POST['class'];
       $term=$_POST[term];
       $year=$_POST[year];
       $subject=$_POST[subject];
        
        $query=$sql->Prepare("SELECT * FROM tbl_student WHERE CLASS='$class' AND STATUS LIKE '%In School%'");
         
        $rtmt=$sql->Execute($query);

        while($row=$rtmt->FetchRow()){
             $query22 = $sql->Prepare("insert into tbl_assesments(courseId,stuId,class,year,term) values('$subject', '$row[ID]', '$row[CLASS]', '$year', '$term')");
            
             $sql->Execute($query22);
          
            
        }
        header("location:open_term.php?success=1");
    }
     
     $app->gethead();
 ?>
 <link href="vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
 
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
                              Mount Subjects for new Term 
                            </p>
                         </div>
                        <form action="open_term.php?add=1" method="POST" class="form-horizontal" role="form">
                                                 <div class="card-body card-padding">
                                                     <div class="form-group">
                                                         <label for="inputEmail3"    class="col-sm-2 control-label">Class</label>
                                                         <div class="col-sm-10">
                                                             <div class="fg-line">
                                                                 <select class='' style="width:240px"   required="" name="class" onChange="getSubject(this.value)">
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
                                                                         <option value="<?php echo $row['id']; ?>" <?php if ($rows->SUBJECT_COMBINATIONS == $row['Combination']) {
                                                                         echo "selected='selected'";
                                                                     } ?>>  <?php echo $row['name']; ?></option>

                                                                     <?php } ?>
                                                                      </select>
                                                             </div>
                                                         </div>
                                                     </div>
                                                      <div class="form-group">
                                                         <label for="inputPassword3" class="col-sm-2 control-label">Academic year</label>
                                                         <div class="col-sm-10">

                                                             <div class="fg-line">
                                                            <select class=''    required="" name="year" style="width:240px">
                                                                     <option value=''>Academic year</option>
                                                                           
                                                                        <?php
                                                            for ($i = 2008; $i <= 4000; $i++) {
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
                                             
                                        
                                <div class=" " style="margin-left:231px" >
                                            <button name="save" type="submit" class="btn btn-primary">Save changes</button>
                                            <button type="reset" class="btn btn-danger" data-dismiss="modal">Reset</button>
                                </div>
                            &nbsp;
                                   </form>
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