<?php
ini_set('display_errors', 0);
require 'vendor/autoload.php';
include "library/includes/config.php";
include "library/includes/initialize.php";
$help = new classes\helpers();
$school = new classes\School();
$school = $school->getAcademicYearTerm();
$student = new classes\Student();
$app = new classes\structure();
$notify = new classes\Notifications();
$app->gethead();
$teacher = new classes\Teacher();
$teacher = $teacher->getTeacher_ID($_SESSION[ID]);

// adding subjects
if (isset($_POST[save])) {
    
    if (!empty($_POST[first]) && !empty($_POST[second]) && !empty($_POST[third]) && !empty($_POST[fourth])) {
        
        $combinator="$_POST[first]|$_POST[second]|$_POST[third]|$_POST[fourth]";
        
        $query = $sql->Prepare("INSERT INTO tbl_combination SET Combination=" . $sql->Param('e') . ",Subject1=" . $sql->Param('a') . ",Subject2=" . $sql->Param('b') . ",Subject3=" . $sql->Param('c') . ",Subject4=" . $sql->Param('d') . "");

        
        if ($sql->Execute($query, array($combinator,$help->getSubject($_POST[first]), $help->getSubject($_POST[second]), $help->getSubject($_POST[third]), $help->getSubject($_POST[fourth])))) {
            header("location:subject_combinations.php?success=1");
        } else {
            header("location:subject_combinations.php?exist=1");
        }
    } else {
        echo "<script>alert('Please select subject combinations')</script>";
    }
}


if (isset($_GET[delete])) {

                    $stmt = $sql->Prepare("DELETE FROM tbl_combination where  ID =" . $sql->Param('a') . " ");
                    if ($sql->Execute($stmt, array($_GET[delete]))) {
                        header("location:subject_combinations.php?success=1");
                    } else {
                        header("location:subject_combinations.php?error=1");
                    }
                }
?>
 <link href="vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
  
  <style>
     .container {
    width: 1380px;
}
 .md {
    font-size: 17px;
    vertical-align: middle;
    color: #333;
    margin-right: 10px;
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
                       <?php $notify->displayMessage();   ?>
                        
                          <div class="modal fade" id="modalWider" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Subject Combination</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action="subject_combinations.php" method="POST" class="form-horizontal" role="form">
                                                 <div class="card-body card-padding">
                                                  <div class="form-group">
                                                         <label for="inputPassword3" class="col-sm-2 control-label">1st Elective </label>
                                                         <div class="col-sm-10">

                                                             <div class="fg-line">
                                                                 <select class='form-control'  name='first'   required="" style="width:200px" >
                                                                    <option value=''>select first elective</option>
                                                                         <?php 
                                                                                global $sql;

                                                                                  $query2=$sql->Prepare("SELECT * FROM tbl_subjects WHERE type='elective'");


                                                                                  $query=$sql->Execute( $query2);


                                                                               while( $row = $query->FetchRow())
                                                                                 {

                                                                                 ?>
                                                                                 <option value="<?php echo $row['shortcode']; ?>"        ><?php echo $row['name']; ?></option>

                                                                           <?php }?>
                                                                        
                                                                 </select>

                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="form-group">
                                                         <label for="inputEmail3"    class="col-sm-2 control-label">2nd Elective</label>
                                                         <div class="col-sm-10">
                                                             <div class="fg-line">
                                                                   <select class='form-control'  name='second'   required=""  style="width:200px">
                                                                    <option value=''>select first elective</option>
                                                                         <?php 
                                                                                global $sql;

                                                                                  $query2=$sql->Prepare("SELECT * FROM tbl_subjects WHERE type='elective'");


                                                                                  $query=$sql->Execute( $query2);


                                                                               while( $row = $query->FetchRow())
                                                                                 {

                                                                                 ?>
                                                                                 <option value="<?php echo $row['shortcode']; ?>"        ><?php echo $row['name']; ?></option>

                                                                           <?php }?>
                                                                        
                                                                 </select>
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="form-group">
                                                         <label for="inputPassword3" class="col-sm-2 control-label">Thirds Elective</label>
                                                         <div class="col-sm-10">

                                                              <div class="fg-line">
                                                                     
                                                                     <select class='form-control'  name='third'   required="" style="width:200px" >
                                                                    <option value=''>select third elective</option>
                                                                         <?php 
                                                                                global $sql;

                                                                                  $query2=$sql->Prepare("SELECT * FROM tbl_subjects WHERE type='elective'");


                                                                                  $query=$sql->Execute( $query2);


                                                                               while( $row = $query->FetchRow())
                                                                                 {

                                                                                 ?>
                                                                                 <option value="<?php echo $row['shortcode']; ?>"        ><?php echo $row['name']; ?></option>

                                                                           <?php }?>
                                                                        
                                                                 </select>
                                                              
                                                              
                                                              </div>
                                                         </div>
                                                     </div>
                                                      
                                                       
                                                     <div class="form-group">
                                                         <label for="inputEmail3"    class="col-sm-2 control-label">Fourth Elective</label>
                                                         <div class="col-sm-10">
                                                             <div class="fg-line">
                                                                  
                                                                     <select class='form-control'  name='fourth'   required="" style="width:200px" >
                                                                    <option value=''>select first elective</option>
                                                                         <?php 
                                                                                global $sql;

                                                                                  $query2=$sql->Prepare("SELECT * FROM tbl_subjects WHERE type='elective'");


                                                                                  $query=$sql->Execute( $query2);


                                                                               while( $row = $query->FetchRow())
                                                                                 {

                                                                                 ?>
                                                                                 <option value="<?php echo $row['shortcode']; ?>"        ><?php echo $row['name']; ?></option>

                                                                           <?php }?>
                                                                        
                                                                 </select>
                                                             
                                                             </div>
                                                         </div>
                                                     </div>
                                                     
                                                      
                                                 </div>
                                             
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success" name="save">Save</button>
                                            <button type="reset" class="btn btn-warning" data-dismiss="modal">Close</button>
                                        </div>
                                   </form>
                                    </div>
                                </div>
                            </div>
                         
                    </div>
               <div class="section-body">
                      
                    <div class="card">
                        
                        <div class="card-header">
                           <p>
                               Subject Combination
                            </p>
                            <div style="float:right"> <button data-toggle="modal" href="#modalWider" class="btn btn-success waves-effect">Add Subject Combination</button></div>
                        </div>
                        <div class="row">
                     <p>&nbsp;</p>
                        </div><!--end .row -->

                        <?php
                         $query = $sql->Prepare("SELECT * FROM tbl_combination ");


                        $rs = $sql->PageExecute($query, RECORDS_BY_PAGE, CURRENT_PAGE);
                        $recordsFound = $rs->_maxRecordCount;    // total record found
                        if (!$rs->EOF) {
                            ?>
                            <p style="color:green"><center>Total records = <?php echo $recordsFound; ?></center></p>
                            <div class="table-responsive">
                                <table id="data-table-command" class="table table-bordered table-vmiddle table-hover"  >
                                    <thead>
                                        <tr>
                                          <th data-column-id="id" style="text-align:center">ID</th>
                                            
                                            <th data-column-id="Subject" data-type=" " data-toggle="tooltip">Combination</th>
                                            <th style="text-align:center" data-type="string" data-column-id="Class" style="text-align:center">First Subject </th>
                                            <th data-column-id="Teacher">Second Subject</th>
                                            <th data-column-id="Academic Year" data-order="asc" style="text-align:center">Third Subject</th>
                                            <th data-column-id="Term" style="text-align:center">Fourth Subject</th>

                                           <th  data-column-id="link" data-formatter="link">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 0;
                                        while ($rt = $rs->FetchRow()) {
                                            $count++;
                                            ?>
                                            <tr>
                                                  <td visible="false" style="text-align:center"><?php  echo $rt[id] ?></td>
                                                
                                                <td id='no' style="text-align:left"><?php echo $rt[Combination] ?></td>
                                                <td style="text-align:left"><?php echo $rt[Subject1] ?></td>
                                                <td style="text-align:left"><?php echo $rt[Subject2] ; ?></td>
                                                <td style="text-align: "><?php echo $rt[Subject3] ?></td>
                                                <td style="text-align:"><?php echo $rt[Subject4] ?></td>
                                                

                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table></div>
                        <?php
                        } else {
                            echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                Oh snap! Something went wrong. No record to display! Please upload students data
                            </div>";
                        }
                        ?>
                    </div>
               </div>
                </div>



                </div>
          </section>
        </section>


   <?php  $app->getDashboardScript(); $app->getuploadScript(); ?>
 <script src="vendors/bootgrid/jquery.bootgrid.min.js"></script>
       
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
                    formatters: {
						"link": function(column, row)
						{
							 var id = row["id"];
                                                           
							return "<a title='delete this term' onclick=\"return confirm('Are you sure you want to delete this')\"    href=\"subject_combinations.php?delete="+id+"  \"> <span class=\"md md-delete\"></span>   </a>";
                                							 

                                                        
						}}
                });
            });
        </script>
        <?php $app->exportScript() ?>
             
    </body>
  
</html>
