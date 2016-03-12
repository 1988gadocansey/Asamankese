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
    if (isset($_GET[upload]) == "staff") {

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
             $query=$sql->Prepare("SELECT * FROM `tbl_worker_no` ");
            $stmt=$sql->Execute($query);
            $row=$stmt->FetchNextObject();
                 
            $number = "ASASCO".date("Y").$row->ID;
             
            $title = $col[1];
            $surname = $col[2];
            $othernames = $col[3];
            $gender =$col[4];
            $phone = $col[5];
            $address = $col[6];
            $dob =  $col[7];
              
            

            // SQL Query to insert data into DataBase
            $query = $sql->Prepare("INSERT INTO tbl_workers(emp_number,title,Name,surname,address,phone,dob,sex) VALUES('" . $number . "','" . $title . "','" . $othernames . "','" . $surname . "','" . $address . "','" . $phone . "','" . $dob . "','" . $gender .  "')");
            
            $a = $sql->Execute($query);
            if ($a) {
                
                    $query=$sql->Prepare("UPDATE tbl_worker_no SET id=id+1");   
                if($sql->Execute($query)){
             
                header("location:upload_staff.php?success=1");
                
                }
            }
            else{
                  header("location:upload_staff.php?error=1");
            }
        }

        fclose($handle);
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
                            <h2><header>UPLOAD BULK STAFF  HERE (Template)</header>
                            </small></h2>
                        </div>
                        
                        <div class="card-body card-padding">
                            <form action="upload_staff.php?upload=staff" role="form" method="POST" enctype="multipart/form-data">
                                <div class="row" style="overflow: scroll">
                                          <table class="table table-bordered no-margin" style="">
								<thead>
									<tr>
										<th>No</th>
                                                                                <th>TITLE</th>
										<th>SURNAME</th>
										<th>OTHERNAMES</th>
										 
                                                                                <th>GENDER</th>
                                                                                <th>PHONE</th>
                                                                                <th>ADDRESS</th>
                                                                                 <th>DOB(2/12/1190)</th>
                                                                                
                                                                                
									</tr>
								</thead>
								<tbody>
									 
								</tbody>
							</table>
                                </div>
                                <div class="row">
                                <div class="col-sm-4">
                                     
                                    
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <span class="btn btn-primary btn-file m-r-10">
                                            <span class="fileinput-new">Select file</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="file" required="">
                                        </span>
                                        <span class="fileinput-filename"></span>
                                        <a href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>
                                    </div>
                                </div>
                            </div>
                            
                            
                                
                                <button type="submit" class="btn btn-primary btn-sm m-t-10">Submit</button>
                            </form>
                               </div>
                    </div>
                    
                     
                    
                    
                </div>
            </section>
        </section>
        
       <?php $app->getDashboardScript() ; $app->getuploadScript(); ?>
        
    </body>
  
</html>