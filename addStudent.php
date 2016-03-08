 <?php
 ini_set('display_errors', 0);
require 'vendor/autoload.php';
include "library/includes/config.php";
include "library/includes/initialize.php";
$app = new classes\structure();
$help = new classes\helpers();
$config = new classes\School();
$info = $config->getConfig();
$year = (date("Y") - 1) . "/" . date("Y");
$_SESSION[indexno] = $_GET[indexno] ? : $_GET[success];
$_SESSION[del] = $_GET["del"];
$teacher = new classes\Teacher();
$teacher = $teacher->getTeacher_ID($_SESSION[ID]);
$school = $config->getAcademicYearTerm();
$query = $sql->Prepare("SELECT * FROM indexno");
$stmt = $sql->Execute($query);
$row = $stmt->FetchNextObject();
if (empty($_SESSION[code])) {
    $_SESSION[code] = $row->no;
}
if((isset($_GET[indexno]))&& empty($_SESSION[indexno])){
          $_SESSION[indexno]=$_GET[indexno];
      }
      
    
   if(isset($_POST['insertpic'])){	

 
if (!$_FILES["files"]["name"])  {echo "<script>alert('Please choose a file to upload')</script>"; $error=1;}
  //check if file type is jpeg 
  //elseif ($_FILES["files"]["type"]!="image/jpeg" and $_FILES["file"]["type"]!="image/pjpeg"  ){echo " <font color='red' style='text-decoration:blink'>Only jpeg formats accepted </font>";   		$error=2;  }
 		elseif (($_FILES["files"]["size"] )>400000) {echo "<script>alert('Only pictures of size less than 400 kb accepted')</script>"; $error=3;  }

	 
	 
	 if($error>0){} else{
	 $destination="studentPhotos/$_SESSION[indexno].jpg";
     move_uploaded_file($_FILES["files"]["tmp_name"],
     $destination);
     if (move_uploaded_file) {//echo "<font color='red' style='text-decoration:blink'> Picture uploaded  successfully </font>" ;
	 header("location:addStudent.php?success=$_SESSION[indexno]&upload");
         
     } 
    		 
}	 
					
					
}

if(isset($_GET["del"])){
     $query=$sql->Prepare("DELETE FROM tbl_student WHERE INDEXNO='$_SESSION[del]'");
     $stmt=$sql->Execute($query);
     $_SESSION[del]="";
     if($stmt){
         header("location:students.php");
     }
 }
if(isset($_GET["new"])){
    
     $_SESSION[indexno]="";
     $met="";
    $query=$sql->Prepare("UPDATE indexno SET no=no + 1");
   if( $stmt=$sql->Execute($query)){
    
     $_SESSION[id] ="";
     $query=$sql->Prepare("SELECT * FROM indexno");
    $stmt=$sql->Execute($query);
    $row=$stmt->FetchNextObject();
    $_SESSION[code]=$row->NO;
   }
}
 
if(isset($_GET[add])==1){
    $query=$sql->Prepare("SELECT * FROM indexno");
    $stmt=$sql->Execute($query);
    $row=$stmt->FetchNextObject();
    
    $index=$help->getIndexNo($_POST[programme]).$row->NO;
 echo $_SESSION[indexno]=$index;
   echo $_POST[dob];
      $rt=$sql->Prepare("SELECT * FROM tbl_student WHERE ID='$_POST[id]'");
     $rt=$sql->Execute($rt);
      $age=age($_POST[dob]);
       print_r( $_POST[department],$_POST[programme],$_POST[combination],$_POST[dob],$_POST[surname],$_POST[othername],$_POST[gender],$index,$age,$_POST[type],$_POST[region],$_POST[hometown],$_POST[country],$_POST[house] , $_POST[class_admitted],$_POST[religion],$_POST[contact_address],$_POST[disability],$_POST[email],$_POST[date_admitted],$year,$_POST["class"]);
   
      if(empty($_POST[id]) ){
    $newStudent=0; // he is a new student
    $query=$sql->Prepare("INSERT INTO tbl_student SET STATUS=".$sql->Param('y2k').", DEPARTMENT=".$sql->Param('azz').",PROGRAMME=".$sql->Param('ass').", SUBJECT_COMBINATIONS=".$sql->Param('ay').",  DOB=".$sql->Param('a').", SURNAME=".$sql->Param('b')."  , OTHERNAMES=".$sql->Param('c').", GENDER=".$sql->Param('d').",INDEXNO=".$sql->Param('e').",AGE=".$sql->Param('f').",STUDENT_TYPE=".$sql->Param('g')." ,REGION=".$sql->Param('h').",HOMETOWN=".$sql->Param('i').",NATIONALITY=".$sql->Param('j').",HOUSE=".$sql->Param('l').",CLASS_ADMITED=".$sql->Param('m').",RELIGION=".$sql->Param('n').",CONTACT_ADDRESS=".$sql->Param('o').",DISABILITY=".$sql->Param('p').",EMAIL=".$sql->Param('q').",DATE_ADMITED=".$sql->Param('r').",YEAR_GROUP=".$sql->Param('s').",CLASS=".$sql->Param('z')." ");
            
           if( $query=$sql->Execute( $query,array($_POST[status],$_POST[department],$_POST[programme],$_POST[combination],$_POST[dob],$_POST[surname],$_POST[othername],$_POST[gender],$index,$age,$_POST[type],$_POST[region],$_POST[hometown],$_POST[country],$_POST[house] , $_POST[class_admitted],$_POST[religion],$_POST[contact_address],$_POST[disability],$_POST[email],$_POST[date_admitted],$year,$_POST["class"]))){
            
               $_SESSION[indexno]=$index;
               
               // check if student exist already in class
               $a=$sql->Prepare("SELECT * FROM tbl_class_members WHERE student='$index' AND term='$school->TERM' AND year='$school->YEAR'");
               $aa=$sql->Execute($a);
               $bb=$aa->FetchNextObject();
               if(count($bb)==0){
                   
               
              $now= $sql->Prepare("INSERT INTO tbl_class_members(CLASS,STUDENT,YEAR,TERM) values(".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').")");
                
               $sql->Execute($now,array($_POST["class"],$index,$school->YEAR,$school->TERM));
               }
                $query=$sql->Prepare("UPDATE indexno SET no=no+1");   
                if($sql->Execute($query)){
                    
                    if($newStudent==0){
                        include('./processStudent.php');
                    }
             header("location:addStudent.php?success=$_SESSION[indexno]");
                }
              
              else{
                   print $sql->ErrorMsg();
              }
           }
     }
     // then update
     else{
         echo "update";
         $newStudent=1; // he is already in the system
         
          $in=$sql->Prepare("SELECT SUBJECT_COMBINATIONS,CLASS FROM tbl_student where INDEXNO='$_SESSION[indexno]'");
          $out=$sql->Execute($in);
          $output=$out->FetchNextObject($out);
          $previouscombination=$output->SUBJECT_COMBINATIONS;
	  $previousClass=$output->CLASS;
   
          if ($previouscombination != $_POST[combination] or $previousClass != $_POST['class']) {


            $query = $sql->Prepare("delete from grades where stuId='$_SESSION[indexno]' and year='$school->YEAR' and term='$school->TERM'");
            $sql->Execute($query);
            $changecourse = 1;
        }








        $query=$sql->Prepare("UPDATE tbl_student SET STATUS=".$sql->Param('y2k').", DEPARTMENT=".$sql->Param('azz').",PROGRAMME=".$sql->Param('ass').", SUBJECT_COMBINATIONS=".$sql->Param('ay').", DOB=".$sql->Param('a').", SURNAME=".$sql->Param('b')."  , OTHERNAMES=".$sql->Param('c').", GENDER=".$sql->Param('d').",AGE=".$sql->Param('f').",STUDENT_TYPE=".$sql->Param('g')." ,REGION=".$sql->Param('h').",HOMETOWN=".$sql->Param('i').",NATIONALITY=".$sql->Param('j').",HOUSE=".$sql->Param('l').",CLASS_ADMITED=".$sql->Param('m').",RELIGION=".$sql->Param('n').",CONTACT_ADDRESS=".$sql->Param('o').",DISABILITY=".$sql->Param('p').",EMAIL=".$sql->Param('q').",DATE_ADMITED=".$sql->Param('r').",YEAR_GROUP=".$sql->Param('s')." ,CLASS=".$sql->Param('z')." WHERE ID='$_POST[id]' ") ;
         print_r(array($_POST[dob],$_POST[surname],$_POST[othername],$_POST[gender],$_POST[indexno],$age,$_POST[type],$_POST[region],$_POST[hometown],$_POST[country],$_POST[program],$_POST[house] , $_POST[class_admitted],$_POST[religion],$_POST[contact_address],$_POST[disability],$_POST[email],$_POST[date_admitted],$year,$_POST["class"]));
           if( $sql->Execute( $query,array($_POST[status],$_POST[department],$_POST[programme],$_POST[combination],$_POST[dob],$_POST[surname],$_POST[othername],$_POST[gender],$age,$_POST[type],$_POST[region],$_POST[hometown],$_POST[country],$_POST[house] , $_POST[class_admitted],$_POST[religion],$_POST[contact_address],$_POST[disability],$_POST[email],$_POST[date_admitted],$year,$_POST["class"]))){
              $_SESSION[indexno]=$_POST[indexno];
               
              
                   $stmt= $sql->Prepare("UPDATE tbl_class_members SET CLASS=".$sql->Param('bc').",STUDENT=".$sql->Param('cc').",YEAR=".$sql->Param('dc').",TERM=".$sql->Param('ee')." WHERE STUDENT=".$sql->Param('ff')."");
              
                  if($sql->Execute($stmt,array($_POST["class"],$_POST[indexno],$school->YEAR,$school->TERM,$_SESSION[indexno]))){
                   
                       
                          include('./processStudent.php');
                       
                      
                     
                      //header("location:addStudent.php?success=$_SESSION[indexno]&&update");
                      
                  }
                  else{
                       print $sql->ErrorMsg();
                  }
               
               header("location:addStudent.php?success=$_SESSION[indexno]&&update");
               
           }
     }
}
if(isset($_GET[page])==2){
        
     $rt=$sql->Prepare("SELECT * FROM tbl_student WHERE ID='$_POST[id]'");
     $rt=$sql->Execute($rt);
   
             
           $query=$sql->Prepare("UPDATE tbl_student SET  GUARDIAN_NAME=".$sql->Param('a').", GUARDIAN_ADDRESS=".$sql->Param('b')."  , GUARDIAN_PHONE=".$sql->Param('c').", GUARDIAN_RELATIONSHIP=".$sql->Param('d')." WHERE ID='$_POST[id]'");
   
           if($sql->Execute( $query,array($_POST[name],$_POST[address],$_POST[phone],$_POST[relationship] ))){
              
               print $sql->ErrorMsg();
               
               header("location:addStudent.php?success=$_POST[indexno]&&guardian");
               
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
    }
    .md {
    font-size: 17px;
    vertical-align: middle;
    color: #333;
    margin-right: 10px;
}
</style>
<body ng-app="formApp" ng-controller="formController">
      
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
                            <h2>Add Students/Pupils <small>Basic Information about pupils here</small></h2>
                            <div style="float:right"><a title="click to delete this student" href="addStudent.php?del=<?php   if(!empty($_GET[indexno])){$person=$_GET[indexno];}else{ $person=$_SESSION[indexno];}echo $person ;?>" onclick="return confirm('Are you sure you want to delete this student')"><i class="md md-delete"></i></a></div>
                        </div>
                        
                        <div class="card-body card-padding">
                            <div class="form-wizard-basic fw-container">
                                <ul class="tab-nav text-center">
                                   
                                    <li><a href="#tab2" data-toggle="tab">Biodata</a></li>
                                    <li><a href="#tab3" data-toggle="tab">Guardian Information</a></li>
                                   
                                     <li><a href="#tab1" data-toggle="tab">Picture Upload</a></li>
                                </ul>
                                <?php
                              if($_GET[update] ||  $_GET["indexno"] ||  $_GET["success"] || $_GET[add] || $_GET[page]){
                      
                                 $query=$sql->Prepare("SELECT * FROM tbl_student WHERE     INDEXNO='$_SESSION[indexno]'  ");
                   
                                  $stmt=$sql->Execute($query);
                                 $rows=$stmt->FetchNextObject();
                                   }
                                  elseif( $_GET["new"]){

                                  }
                              
                                  elseif(!$_GET[update] ||  !$_GET["indexno"] ||  !$_GET["success"]||!$_GET['new']){
 

                                       // $_SESSION[id] ="";
                                       /* $query=$sql->Prepare("SELECT * FROM indexno");
                                       $stmt=$sql->Execute($query);
                                       $row=$stmt->FetchNextObject();
                                       $_SESSION[indexno]=$help->getIndexNo($program).$row->NO;*/
                                       

                                  }
                                   
                                ?>
                                
                                <div class="tab-content">
                                    
                                    <div class="tab-pane fade" id="tab2">
                                        <form action="addStudent.php?add=1" class="form-horizontal" method="POST" id="biodata"  >
                                                      
                                            <div class="row" align="center"  >
                                 
                                                <div class="col-sm-4">                       
                                    <div class="input-group">
                                        <span class="input-group-addon">Student No</i></span>
                                        <div class="fg-line">
                                            <input type="text" class="form-control" readonly="readonly"  name="indexno" value="<?php   if(!empty($rows->INDEXNO)){ echo $rows->INDEXNO;}else{ echo $_SESSION[indexno]; }?>">
                                        </div>
                                    </div>
                                                    <input type="hidden" class="form-control"    name="id" value="<?php   $rows->ID;?>">
                                     
                                    <br/>
                                    
                                    <div class="input-group">
                                         <span class="input-group-addon">Date of birth</span>
                                            <div class="dtp-container dropdown fg-line">
                                                <input type='text'name="dob" class="form-control date-picker" title="date of birth" required="" data-toggle="dropdown" value="<?php echo $rows->DOB ?>" >
                                        </div>
                                          
                                    </div>
                                    
                                    <br/>
                                    
                                    <div class="input-group">
                                        <span class="input-group-addon">Class</i></span>
                                        <div class="fg-line">
                                            <select class='form-control'  name='class'    required="">
                                                            <option value=''>select class</option>
                                                           
                                                      <?php 
                                                global $sql;

                                                      $query2=$sql->Prepare("SELECT * FROM tbl_classes");


                                                      $query=$sql->Execute( $query2);


                                                   while( $row = $query->FetchRow())
                                                     {

                                                     ?>
                                                     <option value="<?php echo $row['name']; ?>" <?php  if( $row['name']==$rows->CLASS){echo'selected="selected"';}?>       ><?php echo $row['name']; ?></option>

                                               <?php }?>
                                                       
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <br/>
                                    
                                    <div class="input-group">
                                        <span class="input-group-addon">Class Admitted</i></span>
                                        <div class="fg-line">    
                                            <select class='form-control'  name='class_admitted'    required="">
                                                            <option value=''>select class admitted</option>
                                                           
                                                      <?php 
                                                global $sql;

                                                      $query2=$sql->Prepare("SELECT * FROM tbl_classes");


                                                      $query=$sql->Execute( $query2);


                                                   while( $row = $query->FetchRow())
                                                     {

                                                     ?>
                                                     <option value="<?php echo $row['name']; ?>" <?php  if( $row['name']==$rows->CLASS_ADMITED){echo'selected="selected"';}?>       ><?php echo $row['name']; ?></option>

                                               <?php }?>
                                                       
                                            </select>
                                        </div>
                                    </div>
                                    <br/>
                                     <div class="input-group">
                                        <span class="input-group-addon">Disability</span>
                                        <div class="fg-line">
                                                        <select class='form-control' name='disability'  >
                                                        <option value='None'>None</option>
												
		                                         <option <?php if($rows->DISABILITY=='Blind'){ echo 'selected="selected"'; }?> >Blind</option>
		                                        <option <?php if($rows->DISABILITY=='Deaf'){ echo 'selected="selected"'; }?> >Deaf</option>
		                                        <option <?php if($rows->DISABILITY=='Dumb'){ echo 'selected="selected"'; }?> >Dumb</option>
		                                             
		                                        </select>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="input-group">
                                         <span class="input-group-addon">Date Admitted</i></span>
                                            <div class="dtp-container dropdown fg-line">
                                                <input type='text' class="form-control date-picker" data-toggle="dropdown"   name="date_admitted" value="<?php echo $rows->DATE_ADMITED?>">
                                        </div>
                                           
                                    </div>
                                    
                                    <br/>
                                       <div class="input-group">
                                       <span class="input-group-addon">Department</span>
                                        <div class="fg-line">
                                            <select class='form-control'  name='department'  placeholder="Department"  required=""   >
                                                            <option value=''>Choose Department</option>
                                                          
                                                      <?php 
                                                global $sql;

                                                      $query2=$sql->Prepare("SELECT DEPARTMENT FROM tbl_program");


                                                      $query=$sql->Execute( $query2);


                                                   while( $row = $query->FetchRow())
                                                     {

                                                     ?>
                                                     <option value="<?php echo $row['DEPARTMENT']; ?>" <?php if($rows->DEPARTMENT== $row['DEPARTMENT']){echo "selected='selected'";} ?>>  <?php echo $row['DEPARTMENT']; ?></option>

                                               <?php }?>
                                                       
                                            </select>
                                           
                                        </div>
                                          
                                    </div>
                                </div>
                                
                                <div class="col-sm-4">                       
                                    <div class="input-group">
                                        <span class="input-group-addon">Surname</i></span>
                                        <div class="fg-line">
                                            <input type="text" class="form-control"   name="surname" value="<?php echo $rows->SURNAME ?>" required="">
                                        </div>
                                         
                                    </div>
                                    
                                    <br/>
                                    
                                    <div class="input-group">
                                        <span class="input-group-addon">Student type</i></span>
                                        <div class="fg-line">
                                            <select class='form-control'  name='type'   required="" >
                 
                                                    <option value=''>select student type</option>

                                                <option value="Boarding"    <?php if($rows->STUDENT_TYPE=="Boarding"){echo "selected='selected'";} ?>      >Boarding</option>
                                                <option value="Day"    <?php if($rows->STUDENT_TYPE=="Day"){echo "selected='selected'";}?>      >Day</option>
                   

                                          </select>
                                        </div>
                                        
                                    </div>
                                    
                                    <br/>
                                    
                                    <div class="input-group">
                                        <span class="input-group-addon">Region</i></span>
                                        <div class="fg-line">
                                            <select class='form-control'  name='region'    required="">
                                                            <option value=''>Choose region</option>
                                                          
                                                   <?php 
                                                global $sql;

                                                      $query2=$sql->Prepare("SELECT * FROM tbl_regions");


                                                      $query=$sql->Execute( $query2);


                                                   while( $row = $query->FetchRow())
                                                     {

                                                     ?>
                                                     <option value="<?php echo $row['NAME']; ?>" <?php if($rows->REGION==$row['NAME']){echo "selected='selected'";} ?>        ><?php echo $row['NAME']; ?></option>

                                                    <?php }?>
                                                       
                                            </select>
                                        </div>
                                        
                                    </div>
                                    
                                    <br/>
                                    
                                    <div class="input-group">
                                        <span class="input-group-addon"> Nationality</i></span>
                                        <div class="fg-line">    
                                                     <select class='form-control'  name='country'    required="">
                                                            <option value=''>Choose Nationality</option>
                                                          
                                                      <?php 
                                                      global $sql;

                                                      $query2=$sql->Prepare("SELECT * FROM tbl_country");


                                                        $query=$sql->Execute( $query2);


                                                     while( $row = $query->FetchRow())
                                                       {

                                                       ?>
                                                       <option value="<?php echo $row['Name']; ?>"   <?php if($rows->NATIONALITY==$row['Name']){echo "selected='selected'";} ?>      ><?php echo $row['Name']; ?></option>

                                                    <?php }?>
                                                       
                                                   </select>
                                        </div>
                                       
                                    </div>
                                    <br/>
                                    <div class="input-group">
                                        <span class="input-group-addon">Religion</i></span>
                                        <div class="fg-line">
                                           <select class='form-control'  name='religion' placeholder="Religion"  required="" >
                 
                                                    <option value=''>select religion</option>

                                                <option value="Christianity"    <?php if($rows->RELIGION=="Christianity"){echo "selected='selected'";} ?>      >Christianity</option>
                                                <option value="Muslim"    <?php if($rows->RELIGION=="Islam"){echo "selected='selected'";}?>      >Islam</option>
                                                <option value="Muslim"    <?php if($rows->RELIGION=="ATR"){echo "selected='selected'";}?>      >ATR</option>

                                          </select>
                                        </div>
                                    </div>
                                    <br/>
                                     <div class="input-group">
                                        <span class="input-group-addon">Contact Address</i></span>
                                        <div class="fg-line">
                                            <input type="text" class="form-control" name="contact_address"   required="" value="<?php echo $rows->CONTACT_ADDRESS;?>">
                                        </div>
                                           
                                    </div>
                                    <br/>
                                       <div class="input-group">
                                       <span class="input-group-addon">Programme</span>
                                        <div class="fg-line">
                                            <select class='form-control'  name='programme'  placeholder="Programme"  required=""   >
                                                            <option value=''>Choose Programme</option>
                                                          
                                                      <?php 
                                                global $sql;

                                                      $query2=$sql->Prepare("SELECT NAME FROM tbl_program");


                                                      $query=$sql->Execute( $query2);


                                                   while( $row = $query->FetchRow())
                                                     {

                                                     ?>
                                                     <option value="<?php echo $row['NAME']; ?>" <?php if($rows->PROGRAMME== $row['NAME']){echo "selected='selected'";} ?>>  <?php echo $row['NAME']; ?></option>

                                               <?php }?>
                                                       
                                            </select>
                                           
                                        </div>
                                          
                                    </div>
                                </div>
                                
                                <div class="col-sm-4">                       
                                    <div class="input-group">
                                         <span class="input-group-addon"> Othernames</i></span>
                                        <div class="fg-line">
                                            <input type="text" class="form-control"   name="othername" required="" value="<?php echo $rows->OTHERNAMES?>">
                                        </div>
                                        
                                    </div>
                                    
                                    <br/>
                                    
                                    <div class="input-group">
                                        <span class="input-group-addon">Hometown</i></span>
                                        <div class="fg-line">
                                            <input type="text" class="form-control" name="hometown"  required="" value="<?php echo $rows->HOMETOWN ?>">
                                        </div>
                                        
                                    </div>
                                    
                                    <br/>
                                    
                                    <div class="input-group">
                                        <span class="input-group-addon">Pupil lives with</span>
                                        <div class="fg-line">
                                                            <select class='form-control'  name='program'  placeholder="Program" <?php if($info->SCHOOL_TYPE==3){echo "required=''";} ?> >
                                                            <option   <?php if($rows->PROGRAMME=="Mother"){echo "selected='selected'";} ?> value='Mother'>Mother</option>
                                                             <option  <?php if($rows->PROGRAMME=="Parent"){echo "selected='selected'";} ?> value='Parent'>Parent</option>
                                                             <option  <?php if($rows->PROGRAMME=="Father"){echo "selected='selected'";} ?> value='Father'>Father</option>
                                                             <option  <?php if($rows->PROGRAMME=="Guardian"){echo "selected='selected'";} ?> value='Guardian'>Guardian</option>
                                
                                                       
                                            </select>
                                        </div>
                                        
                                    </div>
                                    
                                    <br/>
                                    
                                    <div class="input-group">
                                        <span class="input-group-addon">Gender</span>
                                        <div class="fg-line">    
                                           <select class='form-control'  name='gender' placeholder="Gender"  required="" >
                 
                                                    <option value=''>select gender</option>

                                                <option value="Male"    <?php if($rows->GENDER=="Male"){echo "selected='selected'";} ?>      >Male</option>
                                                <option value="Female"    <?php if($rows->GENDER=="Female"){echo "selected='selected'";}?>      >Female</option>
                   

                                          </select>
                                        </div>
                                         
                                    </div>
                                   </div>
                                                 
                                    
                                  <div class="col-sm-4">   
                                      <br/>
                                    <div class="input-group">
                                       <span class="input-group-addon">House</span>
                                        <div class="fg-line">
                                            <select class='form-control'  name='house'  placeholder="House"  required=""  onClick="beginEditing(this);" onBlur="finishEditing();" >
                                                            <option value=''>Choose House</option>
                                                          
                                                      <?php 
                                                global $sql;

                                                      $query2=$sql->Prepare("SELECT * FROM tbl_house");


                                                      $query=$sql->Execute( $query2);


                                                   while( $row = $query->FetchRow())
                                                     {

                                                     ?>
                                                     <option value="<?php echo $row['id']; ?>" <?php if($rows->HOUSE== $row['id']){echo "selected='selected'";} ?>>  <?php echo $row['house']; ?></option>

                                               <?php }?>
                                                       
                                            </select>
                                           
                                        </div>
                                          
                                    </div>
                                    
                                    <br/>
                                    
                                      <div class="input-group">
                                       <span class="input-group-addon">Subject Combination</span>
                                        <div class="fg-line">
                                            <select class='form-control'  name='combination'  placeholder="subjects combination"  required=""   >
                                                            <option value=''>Choose subjects</option>
                                                          
                                                      <?php 
                                                global $sql;

                                                      $query2=$sql->Prepare("SELECT * FROM tbl_combination");


                                                      $query=$sql->Execute( $query2);


                                                   while( $row = $query->FetchRow())
                                                     {

                                                     ?>
                                                     <option value="<?php echo $row['Combination']; ?>" <?php if($rows->SUBJECT_COMBINATIONS== $row['Combination']){echo "selected='selected'";} ?>>  <?php echo $row['Combination']; ?></option>

                                               <?php }?>
                                                       
                                            </select>
                                           
                                        </div>
                                          
                                    </div>
                                    
                                       <br/>
                                       <div class="input-group">
                                       <span class="input-group-addon">Status</span>
                                        <div class="fg-line">
                                            <select class='form-control'  name='status'  placeholder="status of student"  required=""   >
                                                            <option value=''>Choose status</option>
                                                            
                                                 <option value='In School'<?php if($rows->STATUS=='In School'){echo 'selected="selected"'; }?>>In School</option>
                                        <option value='Alumni'<?php if($rows->STATUS=='Alumni'){echo 'selected="selected"'; }?>>Alumni</option>
                                        <option value='Deffered'<?php if($rows->STATUS=='Deffered'){echo 'selected="selected"'; }?>>Deffered</option>
                                        <option value='Dead'<?php if($rows->STATUS=='Dead'){echo 'selected="selected"'; }?>>Dead</option>
                                        <option value='Suspended'<?php if($rows->STATUS=='Suspended'){echo 'selected="selected"'; }?>>Suspended</option>
                                        <option value='Rasticated'<?php if($rows->STATUS=='Rasticated'){echo 'selected="selected"'; }?>>Rasticated</option>

                                                        
                                            </select>
                                           
                                        </div>
                                          
                                    </div>
                                </div>
                                  <div class="col-sm-4">                       
                                   
                                    
                                   
                                    
                                    <br/>
                                    
                                    <input type="hidden"  name="id" value="<?php echo $rows->ID; ?>"/>
                                    <input type="hidden"  name="index" value="<?php echo $rows->INDEXNO; ?>"/>
                                </div>
                                                
                                                
                                                
                                         
                                   </div> 
                                            <div>&nbsp;&nbsp;</div>
                                            <div class="row"><center>
                    <input  id="proceed" type="submit"  name="submit" value="Save" class="btn btn-success btn-large">
                    <input type="reset" class="btn btn-warning btn-large" value="Clear">
                                                            </center></div>
         
                                  </form>
                                        
                                    </div>
                                     <div class="tab-pane fade" id="tab3">
                                         
                        
                                            
                                        <div class="row">
                                            <form action="addStudent.php?page=2" id="addActivity"class="form-horizontal" role="form" method="POST">
                             
                                        <div class="card-body card-padding">
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Guardian Name</label>
                                                <div class="col-sm-10">
                                                    <div class="fg-line">
                                                        <input type="text" required=""name="name" value="<?php echo $rows->GUARDIAN_NAME  ?>" class="form-control input-sm" id="input"     >
                                                    </div>
                                                </div>
                                            </div>
                                        
                                             
                                              
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Guardian Phone</label>
                                                <div class="col-sm-10">
                                                    <div class="fg-line">
                                                        <input type="text" required="" value="<?php echo $rows->GUARDIAN_PHONE  ?>"name="phone" class="form-control input-sm" id="input"   >
                                                    </div>
                                                </div>
                                            </div>
                                               <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Guardian Address</label>
                                                <div class="col-sm-10">
                                                    <div class="fg-line">
                                                        <input type="text" required=""name="address" value="<?php echo $rows->GUARDIAN_ADDRESS  ?>"class="form-control input-sm" id="input"   >
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden"  name="indexno" value="<?php echo $rows->INDEXNO; ?>"/>
                                             
                                            <div class="input-group">
                                                    <span class="input-group-addon">Guardian Relationship to Pupil</span>
                                                    <div class="fg-line">
                                                        <select class='form-control' id="ghg"  name='relationship'   required="" >
                                                                        <option <?php if($rows->GUARDIAN_RELATIONSHIP=="Mother"){echo "selected='selected'";} ?>   value='Mother'>Mother</option>
                                                                         <option <?php if($rows->GUARDIAN_RELATIONSHIP=="Parent"){echo "selected='selected'";} ?>  value='Parent'>Parent</option>
                                                                         <option <?php if($rows->GUARDIAN_RELATIONSHIP=="Father"){echo "selected='selected'";} ?>  value='Father'>Father</option>
                                                                         <option <?php if($rows->GUARDIAN_RELATIONSHIP=="Relative"){echo "selected='selected'";} ?> value='Relative'>Relative</option>


                                                        </select>
                                                    </div>
                                                    
                                                </div>
                                           
                                            <input type="hidden" name="id" value="<?php echo $rows->ID  ?>"/>
                                             <input type="hidden" name="indexno" value="<?php echo $rows->INDEXNO  ?>"/>
                                            <div>&nbsp;&nbsp;</div>
                                            <div class="row"><center>
                                                <input  id="proceed" type="submit"  name="submit" value="Save" class="btn btn-primary btn-large">
                                                <input  id="proceed" type="reset"  name="Clear" value="Clear" class="btn btn-default-bright btn-large">
                                                
                                            </center></div>
                                        </div>
                                     </form>
                                        </div>
                                        
                                    </div>
                                     
                                    <div class="tab-pane fade" id="tab1">    
                                         
                                        <?php
                                         
                                        ?>
                                        <form action="" method="POST" enctype="multipart/form-data">
                                            <center><p class="text-warning">Only jpeg with maximum size 400kb accepted</p></center>
                                                     
                                            <center>
                                            <div class="fileinput fileinput-new" data-provides="fileinput" align="center">
                                                <div class="fileinput-new thumbnail" style="width: 200px; height: 186px;">
                                                    <img <?php echo $help->picture("studentPhotos/$person.jpg", 191) ?>  src="<?php echo file_exists("studentPhotos/$person.jpg") ? "studentPhotos/$person.jpg" : "img/user.jpg"; ?>" alt=" Picture of Student Here" data-toggle="modal" href="#modalWider"  />    
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                                                </div>
                                                <div>
                                                    <span class="btn default btn-file">
                                                        <span class="fileinput-new">
                                                            Select image </span>
                                                        <span class="fileinput-exists btn btn-warning">
                                                            Change </span>
                                                        <input type="file" name="files" required="">
                                                    </span>
                                                    <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">
                                                        Remove </a>

                                                </div>

                                                <br/>
                                                <input type="submit" class="btn btn-primary" name="insertpic" <?php if ($person != "") {
    
                                                } else {
                                                    echo 'disabled="disabled"';
                                                } ?> id="" value="Upload" />


                                            </div>


                                                         
                                                     
                                       
                                                 
                                             </form>
                                          <div class="form-group">
                                              <br/>
                                            <?php      if($_SESSION[level]=="Administrator" ){?>  
                                               <div class="col-sm-offset-2 col-sm-10"><center>
                                        <a  style="margin-left:-177px"href="addStudent.php?new" class="btn btn-success btn-sm">Add New Student</a>
                                              </center>    </div>
                                            <?php } ?>  
                                          </div> 
</center>
                                            </div>
                                </div>
                                         
                                   
                                    <ul class="fw-footer pagination wizard">
                                         
                                        <li class="previous"><a class="a-prevent" href="#"><i class="md md-chevron-left"></i></a></li>
                                        <li class="next"><a   ng-disabled="biodata.$invalid" class="a-prevent" href="#"><i class="md md-chevron-right"></i></a></li>
                                         
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                   			<!-- END VALIDATION FORM WIZARD -->
                                        
                   <?php      if($_SESSION[level]=="Administrator"){?>
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

                   </div><?php  }?>
                </div>
                     
                    
                    
                </div>
            </section>
        </section>
        
         
        <?php $app->getDashboardScript() ; $app->getuploadScript(); ?>
      
         <script src="js/waves/waves.min.js"></script>
         
       <script src="vendors/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
        <script src="vendors/summernote/summernote.min.js"></script>
        <script src="vendors/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
        <script src="vendors/fileinput/fileinput.min.js"></script>
    
            <script type="text/javascript">
            $('#submit').click(function(ev){

                $.post('biodata.php', $("#biodata").serialize(), function(data) {
                   
                });
                $.post('biodata.php', $("#biodata2").serialize(), function(data) {
                      
                });
            });
           </script>
             <script>
// define angular module/app
		var formApp = angular.module('formApp', []);

		// create angular controller and pass in $scope and $http
		function formController($scope, $http) {

			// create a blank object to hold our form information
			// $scope will allow this to pass between controller and view
			 
                         $scope.fname = "<?php echo $rows->FIRSTNAME ?>";
                         $scope.surname = "<?php echo $rows->SURNAME ?>";
                         $scope.title = "<?php echo $rows->TITLE ?>";
                         $scope.gender= "<?php echo $rows->GENDER ?>";
                         $scope.phone= "<?php echo $rows->PHONE ?>";
                         $scope.dob= "<?php echo date("d/m/Y",$rows->DOB) ?>";
                         $scope.marital= "<?php echo $rows->MARITAL_STATUS ?>";
                         $scope.nationality= "<?php echo $rows->NATIONALITY ?>";
                         $scope.region= "<?php echo $rows->REGION ?>";
                         $scope.hometown= "<?php echo $rows->HOMETOWN ?>";
                         $scope.disability= "<?php echo $rows->PHYSICALLY_DISABLED ?>";
                         $scope.region= "<?php echo $rows->REGION ?>";
                         $scope.religion= "<?php echo $rows->RELIGION ?>";
                         $scope.address= "<?php echo $rows->ADDRESS ?>";
                         $scope.email= "<?php echo $rows->EMAIL ?>";
                         $scope.guardian= "<?php echo $rows->GURDIAN_NAME?>";
                         $scope.gaddress= "<?php echo $rows->GURDIAN_ADDRESS?>";
                         $scope.gphone= "<?php echo $rows->GURDIAN_PHONE?>";
                         $scope.goccupation= "<?php echo $rows->GURDIAN_OCCUPATION?>";
                         $scope.grelationship= "<?php echo $rows->RELATIONSHIP_TO_APPLICANT?>";
                         $scope.residential= "<?php echo $rows->POSTAL_ADDRESS ?>";
                         $scope.bond= "<?php echo $rows->BOND ?>";
                         $scope.entry_type= "<?php echo $rows->ENTRY_TYPE ?>";
                         $scope.entry_qualification= "<?php echo $rows->ENTRY_QUALIFICATION ?>";
                         $scope.first_choice= "<?php echo $rows->FIRST_CHOICE ?>";
                         $scope.second_choice= "<?php echo $rows->SECOND_CHOICE ?>";
                         $scope.preference= "<?php echo $rows->SESSION_PREFERENCE ?>";
                         $scope.qualification= "<?php echo $rows->QUALIFICATION ?>";
			// process the form
			$scope.processForm = function() {
                            
				$http({
			        method  : 'POST',
			        url     : 'biodata.php',
			        data    : $.param($scope.formData),  // pass in data as strings
			        headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
			    })
			        .success(function(data) {
			            console.log(data);

			             
			            	// if successful, bind success message to message
			               
                                         
			                 
			             
			        });

			};

		}

	 
</script> 
</body>
  
</html>
