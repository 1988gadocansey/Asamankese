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
       /*$class=$_POST['class'];
       $term=$_POST[term];
       $year=$_POST[year];
       $subject=$_POST[subject];
        
        $query=$sql->Prepare("SELECT * FROM tbl_student WHERE CLASS='$class' AND STATUS LIKE '%In School%'");
         
        $rtmt=$sql->Execute($query);

        while($row=$rtmt->FetchRow()){
             $query22 = $sql->Prepare("insert into tbl_assesments(courseId,stuId,class,year,term) values('$subject', '$row[ID]', '$row[CLASS]', '$year', '$term')");
            
             $sql->Execute($query22);
          
            
        }
        header("location:open_term.php?success=1");*/
         $term = $school->TERM;
         $year = $school->YEAR;
        $query2=$sql->Prepare("SELECT * FROM tbl_classes");
                                                    
                                                    
         $query=$sql->Execute( $query2);
                                                                         
                                                                       
        while( $row = $query->FetchRow())
         {
                    $class=$row['name']; // class to assessment sheet
                    $queryC=$sql->Prepare("SELECT * FROM `tbl_courses` WHERE classId='$class' AND year='$year' AND term='$term' AND teacherId!=''");
                    print_r($queryC);  
                    $output=$sql->Execute( $queryC);
                    while( $col = $output->FetchRow()){ 
                        
                    $subject=$col['id']; //subject to assesment sheet
                        
                    $querys=$sql->Prepare("SELECT * FROM tbl_student WHERE CLASS='$class' AND STATUS LIKE '%In School%'");
         
                    $rtmt=$sql->Execute($querys);
                    
                    while( $rows = $rtmt->FetchRow()){
                        $student=$rows['ID'];// to assessment table
                        
                        
                        $insert_sql = $sql->Prepare("insert into tbl_assesments(courseId,stuId,class,year,term) values('$subject', '$student', '$class', '$year', '$term')");
            
                        $sql->Execute($insert_sql);
          
                        
                    }

                    
                 }
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
                        
                         <div class="card-header" align='center'>
                           <p align='center'>
                           <h5>PLEASE BEFORE YOU CLICK THE OPEN TERM BUTTON MAKE SURE YOU SET YOUR</h5> <br/>
                           <h6> 1.ACADEMIC YEAR AND TERM</h6><br/>
                           <h6> 2.SET TEACHERS TO THEIR RESPECTIVE SUBJECTS IN EVERY CLASS</h6><br/>
                           <h6>3.PLEASE CHECK THIS THINGS BEFORE</h6><br/>
                           </h5>
                            </p>
                         </div>
                        <form action="open_term.php?add=1" method="POST" class="form-horizontal" role="form">
                            <div class="card-body card-padding">

                                <div class=" " style="margin-left:480px" >
                                    <button onclick="return confirm('Are you sure you want to open this term as new term for entering mark?')" name="save" type="submit" class="btn btn-primary">Open new term</button>
                                    
                                </div>
                                &nbsp;
                            </div>
                        </form>
                    
                </div>
                </div>
                     
                    
                    
                </div>
            </section>
        </section>
        
         <?php  $app->getDashboardScript() ; $app->getuploadScript(); ?>
     
         <?php $app->exportScript() ?>
    </body>
  
</html>