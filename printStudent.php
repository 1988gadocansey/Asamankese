 <?php
 ini_set('display_errors', 0);
    require 'vendor/autoload.php';
    include "library/includes/config.php";
     include "library/includes/initialize.php";
    $app=new classes\structure();
     if(isset($_GET[indexno])){
         $indexno=$_GET[indexno];
         $stmt=$sql->Prepare("SELECT * FROM tbl_student WHERE INDEXNO='$indexno'");
         $in=$sql->Execute($stmt);
         $student_info=$in->FetchRow();
         
     }
     
    $help=new classes\helpers();
    $notify=new classes\Notifications();
     $app->gethead();
 ?>
<link href="css/app.min.css" rel="stylesheet"/>
 <link href="vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
  
<body>
      
          
        <section id="main">
              
            
          <section id="content">
                <div class="container">
                    <div class="block-header">
                       <?php $notify->displayMessage();  ?>
                    
                         
                    </div>  
                    <p align="center"><img src="images/printout.JPG" alt="printout" style="width:1026px;height:auto" /></p></td>
  
               <div class="section-body">
                     <div class="card">
                        <div class="card-header">
                            <center><div class="text-boldest text-warning"><h4>Details of Student</h4></div></center>
                        </div>
                        
                         <div class="card-body">
                           
                             <table width="100%" border="0" align="left" class="table table-invoicer " style="border:1px solid #fff">
                                 <tr>
                                     <td width="210" class="uppercase" align="right"><strong>SCHOOL INDEX N<u>O</u></strong></td>
                                     <td width="408" class="capitalize"><?php echo $student_info['INDEXNO'] ?></td>
                                     <td width="260" rowspan="8" ><img  <?php $id= $student_info['INDEXNO'];
echo $help->picture("studentPhotos/$id.jpg", 240); ?>  src="<?php echo file_exists("studentPhotos/$id.jpg") ? "studentPhotos/$id.jpg" : ""; ?>" alt=" Picture of Student Here"  alt=' PHOTO here'/></td>

                                 </tr>
                                 <tr>
                                     <td class="uppercase" align="right"><strong>WAEC INDEX N<u>O</u>:</strong></td>

                                     <td class="capitalize"><?php echo $student_info['WAEC_INDEXNO'] ?></td>
                                 </tr>
                                 <tr>
                                     <td class="uppercase" align="right"><strong>SURNAME:</strong></td>
                                     <td class="capitalize"><?php echo $student_info['SURNAME'] ?></td>
                                 </tr>
                                 <tr>
                                     <td class="uppercase" align="right"><strong>OTHERNAMES:</strong></td>
                                     <td class="capitalize"><?php echo $student_info['OTHERNAMES'] ?></td>
                                 </tr>
                                 <tr>
                                     <td class="uppercase" align="right"><strong>DATE OF BIRTH</strong>:</td>
                                     <td class="capitalize"><?php echo $student_info['DOB'] ?></td>
                                 </tr>
                                 <tr>
                                     <td class="uppercase" align="right"><strong>AGE:</strong></td>
                                     <td class="capitalize"><?php echo $student_info['AGE']; ?>yrs</td>
                                 </tr>
                                 <tr>
                                     <td height="51" align="right" class="uppercase" style="vertical-align:top"><strong>GENDER:</strong></td>
                                     <td class="capitalize"><?php echo $student_info['GENDER']; ?></td>
                                 </tr>
                                 <tr>
                                     <td class="uppercase" align="right"><strong>STATUS:</strong></td>
                                     <td class="capitalize"><?php echo $student_info['STATUS']; ?></td>
                                 </tr>
                                 <tr>
                                     <td class="uppercase" align="right"><strong>HOMETOWN:</strong></td>
                                     <td class="capitalize"><?php echo $student_info['HOMETOWN']; ?></td>

                                 </tr>
                                 <tr>
                                     <td class="uppercase" align="right"><strong>PROGRAMME OF STUDY:</strong></td>
                                     <td class="capitalize"><?php echo $student_info['PROGRAMME']; ?></td>

                                 </tr>
                                 <tr>
                                     <td class="uppercase" align="right"><strong>CLASS:</strong></td>
                                     <td class="capitalize"><?php echo $student_info['CLASS']; ?></td>

                                 </tr>
                                                     
                                <!-- <tr>
                                  <td class="uppercase" align="right"><strong>WORKING EXPERIENCE:</strong></td>
                                   <td class="capitalize"><?php //echo $student_info['WORKING_EXPERIENCE']; ?>yrs</td>
                                   
                                 </tr> -->
                                 <tr>
                                     <td class="uppercase" align="right"><strong>NATIONALITY:</strong></td>
                                     <td class="capitalize"><?php echo $student_info['NATIONALITY']; ?></td>

                                 </tr>
                                 <tr>
                                     <td class="uppercase" align="right"><strong>HOMETOWN:</strong></td>
                                     <td class="capitalize"><?php echo $student_info['HOMETOWN']; ?></td>

                                 </tr>
                                  <tr>
                                     <td class="uppercase" align="right"><strong>REGION:</strong></td>
                                     <td class="capitalize"><?php echo $student_info['REGION']; ?></td>

                                  </tr>
                                  <tr>
                                      <td colspan="5"><center><h4>GUARDIAN INFORMATION</h4></center></td>
                                  </tr>
                                                <tr>
                                                        <td class="uppercase" align="right"><strong>NAME OF GUARDIAN:</strong></td>
                                                        <td class="capitalize"><?php echo $student_info[GUARDIAN_NAME]; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="uppercase" align="right"><strong>ADDRESS OF GUARDIAN:</strong></td>
                                                        <td class="capitalize"><?php echo $student_info[GUARDIAN_ADDRESS]; ?></td>
                                                    </tr>

                                                    <tr>
                                                        <td class="uppercase" align="right"><strong>PHONE N<u>O</u> OF GUARDIAN</strong>:</td>
                                                        <td class="capitalize"><?php echo $student_info[GUARDIAN_PHONE]; ?></td>
                                                    </tr>

                                                    <tr>
                                                        <td width="210" class="uppercase" align="right"><strong>RELATIONSHIP TO APPLICANT</strong></td>
                                                        <td width="408" class="capitalize"><?php echo $student_info[GUARDIAN_RELATIONSHIP]; ?></td>
                                                    </tr>
                                                     
                                            </table>
                        
                        </div>
                    </div>
                   			 

                </div>
                </div>
             
            </section>
        </section>
        
         
        <?php $app->getDashboardScript() ; $app->getuploadScript(); ?>
        
  <script src="vendors/bootgrid/jquery.bootgrid.min.js"></script>
       <script>
           window.print();
            window.close();
           </script>
    </body>
  
</html>