<?php
ini_set('display_errors', 0);
require 'vendor/autoload.php';
include "library/includes/config.php";
include "library/includes/initialize.php";
$help = new classes\helpers();
$school3 = new classes\School();
$school = $school3->getAcademicYearTerm();
$config = $school3->getConfig();
$student = new classes\Student();
$app = new classes\structure();
$studentNo = $help->getIndex($_GET[student]);
$notify = new classes\Notifications();
$grade=new classes\Grades();
     
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>GREAT ASSASCO - Transcript</title>
        
 <link href="css/app.min.css" rel="stylesheet">
     
         <link href="vendors/animate-css/animate.min.css" rel="stylesheet">
             
                  <style>
                      body{
                          background-color: white;
                      }
                      #transcript{
                           
                      }
                  </style>
        <body onload="show_clock()">
            <div>
                <div>





                    <div id='maind'>

                        <center>

                         <U>
                                       ASAMANKESE SENIOR HIGH SCHOOL
                                       <br/>
                                        STUDENTS RECORDS AND MANAGEMENT INFORMATION SECTION
                                        <BR/>OFFICIAL TRANSCRIPT

                                    </U> </center>

                            
            <?php
            
                $query=$sql->Prepare("SELECT * FROM tbl_student WHERE INDEXNO='$studentNo'");
                $stmt=$sql->Execute($query);
                $row=$stmt->FetchNextObject();
            
            ?>
                            
       <center><table id="transcript" class=''>

           <tr>
               <td class='aou'>STUDENT NAME:</td> 
               <td class='edu'><?php  echo $row->SURNAME.", ".$row->OTHERNAMES; ?></td>  
               <th width="11%" colspan="2" rowspan="4" align="center" valign="middle" scope="row"><img <?php echo $help->picture("studentPhotos/$studentNo.jpg", 130) ?> style="margin-left:-70%" src="<?php echo "studentPhotos/$studentNo.jpg" ?>" alt="" /></th>
           </tr>

           <tr><td class='aou'>INDEX NO:</td>    <td class='edu'><?php echo $row->INDEXNO ?></td>    </tr>
           <tr><td class='aou'>GENDER:</td>    <td class='edu'><?php echo $row->GENDER ?></td>    </tr>
           <tr><td class='aou'>CLASS:</td>    <td class='edu'><?php echo $row->CLASS ?> </td>    </tr>
           <tr><td class='aou'>PROGRAMME:</td>    <td class='edu'><?php echo $row->PROGRAMME ?></td>    </tr>
            <tr><td class='aou'>HOUSE:</td>    <td class='edu'><?php echo $row->HOUSE ?></td>    </tr>
       
           
           </table></center>
                            <hr>
                             <?php
                             
                             $stmt=$sql->Prepare("select distinct year from tbl_assesments where stuId='$_GET[student]'" );
                             
                             $rtmt=$sql->Execute($stmt);
        while($row=$rtmt->FetchRow()){
                for($i=1;$i<=3;$i++){
            $class=$sql->Prepare("SELECT class from tbl_class_members where student='$studentNo' and year='$row[year]' and term='$i'") ;
             
            $fetch=$sql->Execute($class);
            $classSize=$fetch->RecordCount();
            
            while($arr=$fetch->FetchRow()){

            echo "<div class='text-bolder'><h6>YEAR : $row[year]   TERM : $i FORM : $arr[class]<h6></div>";
             
            }
            $ttotal=0;
            $t=0;
            $aggregade=0;    
            ?>
<table class="table table-condensed table-striped">
    
    <thead class='ui-corner-top'>
        <th>SUBJECT</th>

                                            <th style='width:15%;' class='ui-corner-top'>MARKS SCORED</th>
                                            <th style='width:15%;' class='ui-corner-top'>POSITION</th>
                                            <th style='width:15%;' class='ui-corner-top'>GRADE</th>
                                            <th style='width:15%;text-align:left;padding-left:1%;' class='ui-corner-top'>REMARKS</th>
    </thead>
    <tbody>
         <?php 
		  
		  
       $query=$sql->Prepare("select * from tbl_assesments,tbl_courses where tbl_assesments.stuId='$_GET[student]' and tbl_assesments.year='$row[year]' and tbl_assesments.term='$i' and tbl_assesments.courseId=tbl_courses.id");
       
       $rs=$sql->Execute($query);

        if($rs->RecordCount()>0){

        while($row = $rs->FetchRow())

        {

        ?>
                  <tr>
                    <td><div><?php echo $row[name]; ?></div></td>
                    <td><div><?php echo $row[total]?></div></td>
                    <td><div><?php echo $row[posInSubject];?></div></td>
                    <td><div><?php $a= $grade->getGradeValue($row[total]);echo $a->GRADE; $ttotal+=$row[total]; ?></div></td>
                    <td><div>
                      <?php $stmt=$sql->Prepare("select grade,valu ,comment from tbl_gradedefinition where   lower <=$row[total]  and upper >= $row[total]   ")  ;
                      $rt=$sql->Execute($stmt);
                      while($out= $rt->FetchRow()){
				  echo $out['comment'];
				  $va=$out['valu'];
				  }
				  $aggregade+=$va;
				  ?>
                    </div>                      <div></div></td>
                    <?php 
				  
								  } ?>
                  </tr>
                  <tr >
                      <td colspan="1"><div align="right" class="style16">TOTAL SCORE: </div></td>
                    <td><span class="style16"><?php echo $ttotal; ?></span></td>
                    <td colspan="2"  ><div align="left" class="style16">AVERAGE SCORE: <?php echo $ttotal/$classSize; ?></div>                      </td>
                    <td><span class="style16">AGGREGATE : <?php echo $aggregade; ?></span></td>
                    </tr>
                </tbody>
                <tfoot>
                </tfoot>
                <tfoot>
                </tfoot>
              </table>              
                <p>&nbsp;</p>
                </td>
    </tbody>                            

</table>

        <?php }
        else{echo "<div>No assessment records for this term</div>";}
                
        
        
                
                
                }
        }?>

                      
                               
        </body>














