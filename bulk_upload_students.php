<?php
ini_set('display_errors', 1);
    require 'vendor/autoload.php';
    include "library/includes/config.php";
     include "library/includes/initialize.php";
    $app=new classes\structure();
    $notify=new classes\Notifications();
    $help=new classes\helpers();
    $config = new classes\School();
    $school = $config->getAcademicYearTerm();
    if (isset($_GET[upload]) == "biodata") {

    // upload students cv
    //check if file path is empty
    $extension = end(explode(".", basename($_FILES['file']['name'])));
    if ($extension == 'csv') {


        $destination = "uploads/students.csv";
        //Import uploaded file to Database
        $handle = fopen($_FILES['file']['tmp_name'], "r");

        move_uploaded_file($_FILES["file"]["tmp_name"], $destination);



        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            
            $num = count($data);

            for ($c = 0; $c < $num; $c++) {
                $col[$c] = $data[$c];
            }
             $query=$sql->Prepare("SELECT * FROM indexno");
            $stmt=$sql->Execute($query);
            $row=$stmt->FetchNextObject();
            if($col[0]==""){
            $col1 =  $help->getIndexNo($col[8]).$row->NO;
            }else{
               $col1=$col[0];
            }
            $col2 = $col[1];
            $col3 = $col[2];
            $col4 = $col[3];
            $col5 = age($col[4],'eu');
            $col6 = $col[5];
            $col7 = $col[6];
            $col8 = $col[7];
            $col9 = $col[8];
            $col10 = $col[9];
            $col11 = $col[10];
            $col12 = $col[11];
            

            // SQL Query to insert data into DataBase
            $query = $sql->Prepare("INSERT INTO tbl_student(INDEXNO,SURNAME,OTHERNAMES,GENDER,DOB,PHONE,CONTACT_ADDRESS,CLASS,PROGRAMME,DEPARTMENT,HOUSE,STUDENT_TYPE) VALUES('" . $col1 . "','" . $col2 . "','" . $col3 . "','" . $col4 . "','" . $col5 . "','" . $col6 . "','" . $col7 . "','" . $col8 . "','" . $col9 . "','" . $col10 . "','" . $col11 . "','" . $col12 . "')");
            
            $a = $sql->Execute($query);
            if ($a) {
                
                $now= $sql->Prepare("INSERT INTO tbl_class_members(CLASS,STUDENT,YEAR,TERM) values(".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').")");
               $sql->Execute($now,array($col8,$col1,$school->YEAR,$school->TERM));
                 $query=$sql->Prepare("UPDATE indexno SET no=no+1");   
                if($sql->Execute($query)){
             
                header("location:students.php?success=1");
                
                }
            }
            else{
                  header("location:bulk_upload_students.php?error=1");
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
                            <h2><header>UPLOAD BULK STUDENTS BIODATA HERE (Template)</header>
                            </small></h2>
                        </div>
                        
                        <div class="card-body card-padding">
                            <form action="bulk_upload_students.php?upload=biodata" role="form" method="POST" enctype="multipart/form-data">
                                <div class="row" style="overflow: scroll">
                                          <table class="table table-bordered no-margin" style="">
								<thead>
									<tr>
										<th>Index No</th>
										<th>SURNAME</th>
										<th>OTHERNAMES</th>
										 
                                                                                <th>GENDER</th>
                                                                                <th>DOB(d/m/Y)</th>
                                                                                <th>PHONE</th>
                                                                                <th>ADDRESS</th>
                                                                                <th>CLASS</th>
                                                                                <th>PROGRAMME</th>
                                                                                <th>DEPARTMENT</th>
                                                                                <th>HOUSE</th>
                                                                                 
                                                                                <th>HOUSE STATUS</th>
                                                                                
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
                            <br/>
                            <br/>
                            <em class="text-caption"><a href="uploads/students.csv">Click to download biodata excel template</a> </em>
                        </div>
                    </div>
                    
                     
                    
                    
                </div>
            </section>
        </section>
        
       <?php $app->getDashboardScript() ; $app->getuploadScript(); ?>
        
    </body>
  
</html>