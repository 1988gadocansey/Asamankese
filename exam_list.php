 <?php
 ini_set('display_errors', 0);
    require 'vendor/autoload.php';
    include "library/includes/config.php";
     include "library/includes/initialize.php";
     $help = new classes\helpers();
$teacher2 = new classes\Teacher();
$teacher = $teacher2->getTeacher_ID($_SESSION[ID]);
if(isset($_GET['class'])){
                            $class=$_GET['class'];
                        }
 


$app=new classes\structure();
    $help=new classes\helpers();
    $notify=new classes\Notifications();
     $app->gethead();
 ?>
 <link href="vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
 <script src="js/jquery.js"></script>
 <script src="js/jquery_003.js"></script>
  
 <style>
     .container {
    width: 1349px;
}
td{
    text-transform: capitalize;
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
                            <p class="text-caption">Examination Attendance Sheet</p>
                        </div>
                        <div align="center"><h4 class="text-bolder text-success"> Examination Attendance Sheet of <?PHP  echo $class?></p></h4></div>
                        <hr>                       
 <?php
                        
                         $query = $sql->Prepare("SELECT * FROM tbl_student  WHERE CLASS='$class' ORDER BY  STUDENT_TYPE ASC  ");


                            $rs = $sql->PageExecute($query,1000, CURRENT_PAGE);
                            $recordsFound = $rs->_maxRecordCount;    // total record found
                            if (!$rs->EOF) {

                                $total = $rs->_maxRecordCount;    // total record found
                           ?>

                     
            <table id="students" class="table table-condensed  table-vmiddle" >
                            <thead bgcolor="#91B7D8">
                                <tr>
                                    <th>No</th>
                                    <th>Photo</th>
                                    <th>Index No</th>
                                    <th>Surname</th>
                                    <th>Othernames</th>
                                    
                                    <th>Class</th>
                                    <th>Programme</th>
                                    
                                    <th>Department</th>
                                    <th>Signature</th>
                                     
                                     
                                    
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
                                    <td style="width:90px"><a href="addStudent.php?indexno=<?php echo $rt[INDEXNO] ?>"><img <?php echo $help->picture("studentPhotos/$rt[INDEXNO].jpg",90)  ?>     src="<?php echo file_exists("studentPhotos/$rt[INDEXNO].jpg") ? "studentPhotos/$rt[INDEXNO].jpg":"studentPhotos/user.jpg";?>" alt=" Picture of Student Here"    /></a></td>
                                    <td><?php  echo $rt[INDEXNO]; ?></td>
                                    <td><?php  echo $rt[SURNAME] ?></td>
                                    <td><?php  echo $rt[OTHERNAMES]; ?></td>
                                     
                                    <td><?php  echo $rt["CLASS"]; ?></td>
                                    <td><?php  echo $rt[PROGRAMME]; ?></td>
                                    
                                    <td><?php  echo $rt["DEPARTMENT"]; ?></td>
                                    <td>.................................</td>
                                          </tr>
                                    <?php } ?>
                            </tbody>
            </table>
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
         
        
        <?php $app->exportScript() ?>
        <script>
            window.print();
                    //window.close();
        </script>
    </body>
  
</html>
