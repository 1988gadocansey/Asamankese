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
              
            $col0 = $col[0];
            $col1 = $col[1];
             $col2 = $col[2];
            $col3 = $col[3];
             $col4 = $col[4];
            $col5 = $col[5];
             $col6 = $col[6];
            

            // SQL Query to insert data into DataBase
            $query = $sql->Prepare("INSERT INTO tpoly_students SET INDEXNO='" . $col0 . "',SURNAME='" . $col1 . "',FIRSTNAME='" . $col2 . "',NAME='" . $col3 . "',PROGRAMMECODE='" . $col4 . "',ADDRESS='" . $col5 . "',TELEPHONENO='" . $col6 . "' ");
            
            $a = $sql->Execute($query);
            if ($a) {
                
                
                header("location:students.php?success=1");
                
                 
            }
            else{
                 // header("location:bulk_upload_students.php?error=1");
            }
        }

        fclose($handle);
    }
    else{
        echo "<script>alert('Please upload only csv files')</script>";
    }
}
?>
    <div class="card-body card-padding">
        <form action="phpinfo.php?upload=biodata" role="form" method="POST" enctype="multipart/form-data">
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