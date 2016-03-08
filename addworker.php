 <?php
 ini_set('display_errors', 0);
    require 'vendor/autoload.php';
    include "library/includes/config.php";
     include "library/includes/initialize.php";
    $app=new classes\structure();
    $help=new classes\helpers();
    $config=new classes\School();
    $info=$config->getConfig();
    $query=$sql->Prepare("SELECT * FROM tbl_worker_no");
    $stmt=$sql->Execute($query);
     $row=$stmt->FetchNextObject();
     $_SESSION[staff]=$_GET[staff];
     $_SESSION[emp_number]="AGM".date("Y").$row->ID  ; 
       $teacher1=new classes\Teacher();  $teacher=$teacher1->getTeacher_ID($_SESSION[ID]);
       $staff_=$teacher1->getUser($_SESSION[staff]);
   if ($_POST['photo']) {


    if (!$_FILES["files"]["name"]) {
        echo "<script type='text/javascript'> alert( 'Please upload a picture ')</script>";
        ;
        $error = 1;
    } elseif (($_FILES["files"]["size"] ) > 400000) {
        echo "<script type='text/javascript'> alert( 'Maximum picture size is 400kb ')</script>";
        ;
        $error = 3;
    }



    if ($error > 0) {
        
    } else {
        $destination = "workerPics/$_POST[no].jpg";
        move_uploaded_file($_FILES["files"]["tmp_name"], $destination);
        if (move_uploaded_file) {
            header("location:addworker.php?success=$_POST[no]");
        }
    }
}
if(isset($_GET["new"])){
     $_SESSION[id]="";
     $met="";
      $_SESSION[emp_number]="";
    $query=$sql->Prepare("UPDATE tbl_worker_no SET id=id + 1");
       if( $stmt=$sql->Execute($query)){

            $_SESSION[id] ="";
            $query=$sql->Prepare("SELECT * FROM tbl_worker_no");
            $stmt=$sql->Execute($query);
            $row=$stmt->FetchNextObject();
            $_SESSION[emp_number]="AGM".date("Y").$row->ID;
       }
}
$met=$_SESSION[id] ? : $_GET[id] ;
if(isset($_GET[add])==1){
     $met=$_SESSION[id] ? : $_GET[id] ? : $_POST[id];
    
     $dob=strtotime($_POST[dob]);
     
       $_POST[id];
      if(empty($_POST[id]) ){
          
       $query1=$sql->Prepare("INSERT INTO tbl_workers(emp_number,Name,surname,placeofresidence,address,phone,dob,sex,marital,hometown,mother,father,dependentsNo,title,email)VALUES('$_POST[no]','$_POST[othernames]','$_POST[surname]','$_POST[residence]','$_POST[address]', '$_POST[phone]',  '$dob' ,'$_POST[gender]','$_POST[marital]','$_POST[hometown]','$_POST[mother]' , '$_POST[father]','$_POST[dependents]','$_POST[title]','$_POST[email]')") ;

           if( $sql->Execute($query1 )){
              $_SESSION[emp_number]=$_POST[no];
                 
              
               header("location:addworker.php?success=$_POST[no]");
               
               
           }
            
     }
     // then update
     else{
          $query=$sql->Prepare("UPDATE tbl_workers SET   Name='$_POST[othernames]', surname='$_POST[surname]',placeofresidence='$_POST[residence]',address='$_POST[address]', phone='$_POST[phone]',  dob='$dob' ,sex='$_POST[gender]',marital='$_POST[marital]',hometown='$_POST[hometown]',mother='$_POST[mother]' , father='$_POST[father]',dependentsNo='$_POST[dependents]',title='$_POST[title]',email='$_POST[email]' WHERE emp_number='$_POST[no]' ");

           if( $query=$sql->Execute( $query)){
              $_SESSION[emp_number]=$_POST[no];
               print $sql->ErrorMsg();
               
               header("location:addworker.php?success=$_POST[no]");
               
           }
     }
}
if(isset($_GET[page])==2){
     $met=$_SESSION[emp_number] ? : $_GET[success] ? : $_POST[id];
   $_SESSION[id]=$met;
   $hired=  strtotime($_POST[datehired]);
    $query=$sql->Prepare("UPDATE tbl_workers SET designation='$_POST[designation]', ssnit='$_POST[ssnit]', education='$_POST[education]',salary='$_POST[salary]',dateHired='$hired', leaves='$_POST[leave]',    empStatus='$_POST[empStatus]',position='$_POST[position]' ,grade='$_POST[grade]'  WHERE emp_number='$_POST[no]' ");

           if( $query=$sql->Execute( $query)){
               
               print $sql->ErrorMsg();
               $query=$sql->Prepare("UPDATE tbl_worker_no SET id=id + 1");
               if( $stmt=$sql->Execute($query)){
               header("location:addworker.php?success=$_POST[no]");
               
               }
              
               
           }
      
}
if(isset($_GET["del"])){
    
     $query=$sql->Prepare("DELETE FROM tbl_workers WHERE emp_number='$_SESSION[staff]'");
     $stmt=$sql->Execute($query);
     $_SESSION[staff]="";
     if($stmt){
         header("location:viewworkers.php");
     }
 }
// saving permissions
 $a=$_SESSION[emp_number] ? : $_SESSION[staff];
  
 if(isset($_GET[save])){
     $permission=array();  // holds array of permissions
     $a=$_SESSION[emp_number] ? : $_SESSION[staff];
 
     $staff_1= $teacher1->getUser($_POST[staff]) ;
     $count=$_POST[counter];
      $child= $_POST[child];
     $parent= $_POST["parent"];
     
      $child_perm=implode(",", $child);
       $parent_perm=implode(",", $parent);
        $a= $child_perm.",".$parent_perm;
       
       $rtmt=$sql->Prepare("SELECT * FROM tbl_modules WHERE USER_ID='$staff_1' ") ;
       $rtmt=$sql->Execute($rtmt);
       if($rtmt->RecordCount()==0){
        $stmt=$sql->Prepare("INSERT INTO tbl_modules (USER_ID,MODULES) VALUES('$staff_1','$a')  ");
       }
 else {
        $stmt=$sql->Prepare("UPDATE tbl_modules SET MODULES=MODULES+',$a' WHERE USER_ID='$staff_1'");
       }
        if($sql->Execute($stmt)){
         header("location:logout.php");
      }
     
 }
     
    $notify=new classes\Notifications();
     $app->gethead();
 ?>
 <link href="vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
  <script type="text/javascript" src="js/ajax.js"></script>
 <link href="images/ajax.css"  rel="stylesheet" type="text/css">
<script src="js/reader.js" ></script>
  <script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<style>
    .form-control{
        height:23px;
        width: 400px;
    }
    .main{
        font-size: 16px;
         font-weight: bold;
    }
    li{
        list-style: none;
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
                            <h2>Add Staff  <small>Basic Information about staff here</small></h2>
                                      <div style="float:right"><a title="click to delete this student" href="addworker.php?del=<?php   echo $_SESSION[staff] ;?>" onclick="return confirm('Are you sure you want to delete this worker??')"><i class="md md-delete"></i></a></div>
                        </div>
                        
                        <div class="card-body card-padding">
                            <?php
                            if(isset($_GET[update]) || isset($_GET["success"]) || isset($_GET[add]) || isset($_GET[page])){
                                    $staff=  $_GET["success"];
                                     $query=$sql->Prepare("SELECT * FROM tbl_workers WHERE   emp_number='$staff'  ") ;
                                     print_r($query);
                                      $stmt=$sql->Execute($query);
                                      $rows=$stmt->FetchNextObject();
                                   }
                                  elseif(isset($_GET[staff])){
                                      if($_SESSION[emp_number]!=""){
                                          $_SESSION[emp_number]=$_GET[staff];
                                      }
                                        $query=$sql->Prepare("SELECT * FROM tbl_workers WHERE   emp_number='$_SESSION[emp_number]'  ") ;
                   
                                         $stmt=$sql->Execute($query);
                                         $rows=$stmt->FetchNextObject();
                                   }
                                   elseif(isset ($_GET["new"])){

                                  }
                               
                    
                                ?>
                             <div class="form-wizard-basic fw-container">
                                <ul class="tab-nav text-center">
                                    <li><a href="#tab2" data-toggle="tab">Biodata</a></li>
                                     <li><a href="#tab3" data-toggle="tab">Appointment Details</a></li>
                                    <li><a href="#tab1" data-toggle="tab">Photo Upload</a></li>
                                   <li><a href="#tab4" data-toggle="tab">Module Permissions</a></li>
                                   
                                   
                                </ul>
                                
                                <div class="tab-content">
                                    
                                    <div class="tab-pane fade" id="tab2">
                                        
                                            
                                        <div class="row" style="margin-left:20%">
                                            <form action="addworker.php?add=1"  class="form-horizontal" role="form" method="POST">
                             
                                        <div class="card-body card-padding">
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Employee Number</label>
                                                <div class="col-sm-2">
                                                    <div class="fg-line">
                                                        <input type="text" readonly required=""name="no" value="<?php  if(!empty($rows->EMP_NUMBER)){echo $rows->EMP_NUMBER; }else{echo $_SESSION[emp_number];} ?>" class="form-control input-sm" id="input"     >
                                                    </div>
                                                </div>
                                            </div>
                                        <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Title</label>
                                                <div class="col-sm-2">
                                                    <div class="fg-line">
                                                        <select name="title" id="title" class="form-control input-sm" required>
                                                            <option <?php if($rows->TITLE=='Mr.'){echo 'selected="selected"';}?>>Mr.</option>
                                                            <option  <?php if($rows->TITLE=='Mrs.'){echo 'selected="selected"';}?>>Mrs.</option>
                                                            <option <?php if($rows->TITLE=='Miss.'){echo 'selected="selected"';}?>>Miss</option>
                                                          <option <?php if($rows->TITLE=='Rev.'){echo 'selected="selected"';}?>>Rev.</option>
                                                          <option <?php if($rows->TITLE=='Fr.'){echo 'selected="selected"';}?>>Fr.</option>
                                                          <option <?php if($rows->TITLE=='Dr.'){echo 'selected="selected"';}?>>Dr.</option>
                                                          <option <?php if($rows->TITLE=='Elder'){echo 'selected="selected"';}?>>Elder</option>
                                                          <option <?php if($rows->TITLE=='Sir.'){echo 'selected="selected"';}?>>Sir</option>
                                                         </select>
                                                    </div>
                                                </div>
                                            </div>
                                             
                                              
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Surname</label>
                                                <div class="col-sm-2">
                                                    <div class="fg-line">
                                                        <input type="text" required="" value="<?php echo $rows->SURNAME  ?>"name="surname" class="form-control input-sm" id="input"   >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Othernames</label>
                                                <div class="col-sm-2">
                                                    <div class="fg-line">
                                                        <input type="text" required="" value="<?php echo $rows->NAME  ?>"name="othernames" class="form-control input-sm" id="input"   >
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Gender</label>
                                                <div class="col-sm-2">
                                                    <div class="fg-line">
                                                        <select name="gender" id="sex" class="form-control input-sm">
                                                            <option <?php if($rows->SEX=='Male'){echo 'selected="selected"';}?>>Male</option>
                                                            <option <?php if($rows->SEX=='Female'){echo 'selected="selected"';}?>>Female</option>
                                                          </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Marital Status</label>
                                                <div class="col-sm-2">
                                                    <div class="fg-line">
                                                        <select name="marital" id="marital" class="form-control input-sm">
                                                             <option <?php if($rows->MARITAL=='Single'){echo 'selected="selected"';}?>>Single </option>
                                                                <option <?php if($rows->MARITAL=='Married'){echo 'selected="selected"';}?>>Married</option>
                                                                <option <?php if($rows->MARITAL=='Divorced'){echo 'selected="selected"';}?>>Divorced</option>
                                                                <option <?php if($rows->MARITAL=='Separated'){echo 'selected="selected"';}?>>Separated</option>
                                                         </select>
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Date of Birth</label>
                                                <div class="col-sm-2">
                                                    <div class="fg-line">
                                                        <input type="text" required="" value="<?php echo date("Y-m-d",$rows->DOB)  ?>"name="dob" class="form-control input-sm date-picker" id="input"   >
                                                    </div>
                                                </div>
                                            </div>
                                               <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Phone No</label>
                                                <div class="col-sm-2">
                                                    <div class="fg-line">
                                                        <input type="text" required=""name="phone" value="<?php echo $rows->PHONE  ?>"class="form-control input-sm" id="input"   >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Place of residence</label>
                                                <div class="col-sm-2">
                                                    <div class="fg-line">
                                                        <input type="text" required=""name="residence" value="<?php echo $rows->PLACEOFRESIDENCE  ?>"class="form-control input-sm" id="input"   >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Hometown</label>
                                                <div class="col-sm-2">
                                                    <div class="fg-line">
                                                        <input type="text" required=""name="hometown" value="<?php echo $rows->HOMETOWN  ?>"class="form-control input-sm" id="input"   >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Contact Address</label>
                                                <div class="col-sm-2">
                                                    <div class="fg-line">
                                                        <input type="text" required=""name="address" value="<?php echo $rows->ADDRESS  ?>"class="form-control input-sm" id="input"   >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Number of dependants</label>
                                                <div class="col-sm-2">
                                                    <div class="fg-line">
                                                        <input type="text" required=""name="dependents"   id="dependentsNo" value="<?php echo $rows->DEPENDENTSNO  ?>"class="form-control input-sm" id="input"   >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Mothers Name</label>
                                                <div class="col-sm-2">
                                                    <div class="fg-line">
                                                        <input type="text" required=""name="mother"     value="<?php echo $rows->MOTHER ?>"class="form-control input-sm" id="input"   >
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Father's Name</label>
                                                <div class="col-sm-2">
                                                    <div class="fg-line">
                                                        <input type="text" required=""name="father"     value="<?php echo $rows->FATHER ?>"class="form-control input-sm" id="input"   >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Email</label>
                                                <div class="col-sm-2">
                                                    <div class="fg-line">
                                                        <input type="email" required=""name="email"     value="<?php echo $rows->EMAIL ?>"class="form-control input-sm" id="input"   >
                                                    </div>
                                                </div>
                                            </div>
                                           
                                            <input type="hidden" name="id" value="<?php echo $rows->ID  ?>"/>
                                            <div>&nbsp;&nbsp;</div>
                                            <div class="row"><center>
                                                <input  id="proceed" type="submit"  name="submit" value="Save Actvity" class="btn btn-primary btn-large">
                                                <input  id="proceed" type="reset"  name="Clear" value="Clear" class="btn btn-default-bright btn-large">
                                                
                                            </center></div>
                                        </div>
                                     </form>
                                        </div>
                                        
                                        
                                    </div>
                                     <div class="tab-pane fade" id="tab3">
                                         
                                        <div class="card-body card-padding">
                                             <form action="addworker.php?page=2"  class="form-horizontal" role="form" method="POST">
                                                 <div class="row" style="margin-left:20%">
                                      
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Designation</label>
                                                <div class="col-sm-2">
                                                    <div class="fg-line">
                                                         <select class='form-control'  name='designation'    required=""   >
                                                            <option value=''>Choose designation</option>
                                                          
                                                                    <?php 
                                                              global $sql;

                                                                    $query2=$sql->Prepare("SELECT * FROM tbl_designation");


                                                                    $query=$sql->Execute( $query2);


                                                                 while( $row = $query->FetchRow())
                                                                   {

                                                                   ?>
                                                                 <option value="<?php echo $row[designation]; ?>" <?php if($row[designation]==$rows->DESIGNATION){echo 'selected="selected"';}?> ><?php echo $row[designation];?>

                                                             <?php }?>
                                                       
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Grade</label>
                                                <div class="col-sm-2">
                                                    <div class="fg-line">
                                                             <select class='form-control'  name='grade'    required=""   >
                                                            <option value=''>Choose grade</option>
                                                          
                                                                    <?php 
                                                              global $sql;

                                                                    $query2=$sql->Prepare("SELECT * FROM tbl_workersgrade");


                                                                    $query=$sql->Execute( $query2);


                                                                 while( $row = $query->FetchRow())
                                                                   {

                                                                   ?>
                                                                  <option <?php if($r[grade]==$rows->GRADE){echo 'selected="selected"';}?> ><?php echo $row[grade];?></option>

                                                             <?php }?>
                                                       
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                             
                                              
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Education Level</label>
                                                <div class="col-sm-2">
                                                    <div class="fg-line">
                                                        <select class='form-control'  name="education"    >
                                                                <option selected="selected">-Select-</option>
                                                                <option <?php if($rows->EDUCATION=='Junior High School'){echo 'selected="selected"';}?>>Junior High School</option>
                                                                <option <?php if($rows->EDUCATION=='High School / SSSCE'){echo 'selected="selected"';}?>>High School / SSSCE</option>
                                                                <option <?php if($rows->EDUCATION=='Diploma'){echo 'selected="selected"';}?>>Diploma</option>
                                                                <option <?php if($rows->EDUCATION=='HND'){echo 'selected="selected"';}?>>HND</option>
                                                                <option <?php if($rows->EDUCATION=='Degree'){echo 'selected="selected"';}?>>Degree</option>
                                                                <option <?php if($rows->EDUCATION=='Masters'){echo 'selected="selected"';}?>>Masters</option>
                                                                <option <?php if($rows->EDUCATION=='Doctorate'){echo 'selected="selected"';}?>>Doctorate</option>
                                                                <option <?php if($rows->EDUCATION=='A Level'){echo 'selected="selected"';}?>>A Level</option>
                                                                <option <?php if($rows->EDUCATION=='O Level'){echo 'selected="selected"';}?>>O Level</option>
                                                              </select>
                                                    </div>
                                                </div>
                                            </div>
                                             
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Employment Status</label>
                                                <div class="col-sm-2">
                                                    <div class="fg-line">
                                                         <select class="form-control" name="empStatus"  >
                                                            <option <?php if($rows->EMPSTATUS=='Probationary'){echo 'selected="selected"';}?>>Probationary</option>
                                                            <option <?php if($rows->EMPSTATUS=='Permanent'){echo 'selected="selected"';}?>>Permanent</option>
                                                              <option <?php if($rows->EMPSTATUS=='National Service'){echo 'selected="selected"';}?>>National Service</option>
                                                          </select>
                                                    </div>
                                                </div>
                                            </div>
                                              
                                             <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Salary</label>
                                                <div class="col-sm-2">
                                                    <div class="fg-line">
                                                        <input type="text" required="" name="salary"   id="salary"  value="<?php echo $rows->SALARY; ?>" class="form-control input-sm" id="input"   >
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Date hired</label>
                                                <div class="col-sm-2">
                                                    <div class="fg-line">
                                                        <input type="text" required="" name="datehired"      value="<?php echo date("Y-m-d",$rows->DATEHIRED); ?>" class="form-control date-picker" id="input"   >
                                                    </div>
                                                </div>
                                            </div>
                                           <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">SSNIT</label>
                                                <div class="col-sm-2">
                                                    <div class="fg-line">
                                                        <input type="text" required="" name="ssnit"         value="<?php echo $rows->SSNIT; ?>" class="form-control input-sm" id="input"   >
                                                    </div>
                                                </div>
                                            </div>
                                               <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Leave</label>
                                                <div class="col-sm-2">
                                                    <div class="fg-line">
                                                       <select class="form-control" name="leave" id="leave" >
                                                        <option <?php if($rows->LEAVE=='On Leave'){echo 'selected="selected"';}?>>On Leave</option>
                                                        <option <?php if($rows->LEAVE=='On Duty'){echo 'selected="selected"';}?>>On Duty</option>
                                                      </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Position</label>
                                                <div class="col-sm-2">
                                                    <div class="fg-line">
                                                        <select class='form-control'  name="position" >
                                                                 
                                                             <option  >-Select-</option>
                                                          
                                                                    <?php 
                                                              global $sql;

                                                                    $query2=$sql->Prepare("SELECT * FROM tbl_position");


                                                                    $query=$sql->Execute( $query2);


                                                                 while( $row = $query->FetchRow())
                                                                   {

                                                                   ?>
                                                                  <option <?php if($row[position]==$rows->POSITION){echo 'selected="selected"';}?> ><?php echo $row[position];?></option>

                                                             <?php }?>
                                                       
                                                        </select>
                                                         
                                                    </div>
                                                </div>
                                            </div>
                                             
                                        <!--   <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">House Master (Mistress) of</label>
                                                <div class="col-sm-2">
                                                    <div class="fg-line">
                                                         <select class='form-control'  name='house'       >
                                                            <option value=''>select house</option>
                                                          
                                                                    <?php 
                                                              global $sql;

                                                                    $query2=$sql->Prepare("SELECT * FROM tbl_house");


                                                                    $query=$sql->Execute( $query2);


                                                                 while( $row = $query->FetchRow())
                                                                   {

                                                                   ?>
                                                                 <option value="<?php echo $row[id]; ?>" <?php if($row[house]==$rows->HOUSE){echo 'selected="selected"';}?> ><?php echo $row[house];?></option>

                                                             <?php }?>
                                                       
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>-->
                                            <input type="hidden" name="id" value="<?php echo $rows->ID  ?>"/>
                                            <input type="hidden" readonly required=""name="no" value="<?php  if(!empty($rows->EMP_NUMBER)){echo $rows->EMP_NUMBER; }else{echo $_SESSION[emp_number];} ?>" class="form-control input-sm" id="input"     >
                                            <div>&nbsp;&nbsp;</div>
                                            <div class="row"><center>
                                                <input  id="proceed" type="submit"  name="submit" value="Save" class="btn btn-primary btn-large">
                                                <input  id="proceed" type="reset"  name="Clear" value="Clear" class="btn btn-default-bright btn-large">
                                                
                                            </center></div>
                                        </form>
                                        </div>
                                    
                                        
                                    </div>
                                     </div>
                                     
                                    <div class="tab-pane fade" id="tab1">    
                                         
                                         
                                        <form action="" method="POST" enctype="multipart/form-data">
                                                      <input type="hidden" readonly required=""name="no" value="<?php  if(!empty($rows->EMP_NUMBER)){echo $rows->EMP_NUMBER; }else{echo $_SESSION[emp_number];} ?>" class="form-control input-sm" id="input"     >
                                                     <center><p class="text-warning">Only jpeg with maximum size 400kb accepted</p></center>
                                                     
                                            <center>
                                            <div class="fileinput fileinput-new" data-provides="fileinput" align="center">
                                                <div class="fileinput-new thumbnail" style="width: 200px; height: 186px;">
                                                    <img <?php  echo $help->picture("workerPics/$rows->EMP_NUMBER.jpg",191)?>  src="<?php echo file_exists("workerPics/$rows->EMP_NUMBER.jpg") ? "workerPics/$rows->EMP_NUMBER.jpg":"img/user.jpg";?>" alt=" Picture of Staff Here" data-toggle="modal" href="#modalWider"  />
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                                                </div>
                                                <div>
                                                    <span class="btn default btn-file">
                                                        <span class="fileinput-new">
                                                            Select image </span>
                                                        <span class="fileinput-exists btn btn-warning">
                                                            Change </span>
                                                        <input name="files"   type="file" id="files" required="" <?php  if($_SESSION[emp_number]!=""){} else {echo 'disabled="disabled"';} ?> />
                                                                            
                                                        
                                                    </span>
                                                    <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">
                                                        Remove </a>

                                                </div>

                                                <br/>
                                                <input type="submit" name="photo" <?php  if($_SESSION[emp_number]!=""){} else {echo 'disabled="disabled"';} ?> id="photo" value="Upload" class="btn btn-primary" /> 


                                            </div>
                     
                                        </form>
                                         
                                     </div>
                                     
                                    <div class="tab-pane animated fadeIn " id="tab4">    
                                        <center> 
                                            
                               
                                            <form action="addworker.php?save" method="post">
                                  <?php
                                            
                                           $query2 = $sql->prepare("SELECT * FROM tbl_menu WHERE    parentid='0'   ");

                                          
                                          $stmt2 = $sql->Execute( $query2 );
                                          
                                          while($row=$stmt2->fetchRow()){
                                              extract($row);
                                            echo"  <li class='sub-menu'>";
                                            ?>
                                                <hr><div class="main">
                                                <input type="checkbox"  name="parent[]" <?php if($id== $a){echo "checked='checked'";} ?> value="<?php echo $id ?>"/><?php echo $name ?>
                                                </div> <ul> <hr> 


                                                    <?php  $query2 = $sql->prepare("SELECT * FROM tbl_menu WHERE parentid='$id' ");
                                                      $stmt  = $sql->Execute( $query2 );

                                                  while ($row2 = $stmt->FetchRow()){
                                                       extract($row2);
                                                      ?>

                                                                  <input class='' type='checkbox' <?php if($id== $a){echo "checked='checked'";} ?> name='child[]'  value='<?php echo $id ?>'/><?php echo $name ?>
                                                                       
                                                            <?php

                                                  }

 
                                            echo  " </ul></li>";
 
                                          }
                  
 
                              ?>
                                                                   <input type="hidden" value="<?php echo $rows->EMP_NUMBER  ?>" name="staff">                            <button type="submit" class="btn btn-warning">Save permission</button>
                              </form>  
                                    </center>
                                         
                                  </div>
                                 <ul class="fw-footer pagination wizard">
                                         
                                        <li class="previous"><a class="a-prevent" href="#"><i class="md md-chevron-left"></i></a></li>
                                        <li class="next"><a class="a-prevent" href="#"><i class="md md-chevron-right"></i></a></li>
                                         
                                    </ul>
                                 
                           </div>
                            </div>
                        </div>
                    </div>
                   			<!-- END VALIDATION FORM WIZARD -->
                                        
                        
                    <div class="modal fade" id="modalWider" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Photo Upload</h4>
                                        </div>
                                        <div class="modal-body">
<title>Photo booth</title>
                            
<script src="swfobject.js" language="javascript"></script>
</head>
<div id="flashArea" class="flashArea" style="height:100%;"><p align="center">This content requires the Adobe Flash Player.<br /><a href="http://www.adobe.com/go/getflashplayer">
						<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /><br />
    <a href=http://www.macromedia.com/go/getflash/>Get Flash</a></p>
	</div></td>
  </tr>

  <script type="text/javascript">
	var mainswf = new SWFObject("take_picture.swf", "main", "700", "400", "9", "#ffffff");
	mainswf.addParam("scale", "noscale");
	mainswf.addParam("wmode", "window");
	mainswf.addParam("allowFullScreen", "true");
	//mainswf.addVariable("requireLogin", "false");
	mainswf.write("flashArea");
	
  </script>
 <script type="text/javascript">


</script>
                                    </div>
                                </div>
                            </div>

                </div>
                </div>
                     
                    
                    
                </div>
            </section>
        </section>
        
         
        <?php $app->getDashboardScript() ; $app->getuploadScript(); ?>
      
  <script src="vendors/bootgrid/jquery.bootgrid.min.js"></script>
        <script src="js/waves/waves.min.js"></script>
         
       <script src="vendors/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
        <script src="vendors/summernote/summernote.min.js"></script>
        <script src="vendors/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
        <script src="vendors/fileinput/fileinput.min.js"></script>
        <script src="vendors/input-mask/input-mask.min.js"></script>

    </body>
  
</html>
