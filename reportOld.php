<?php 
         ini_set('display_errors', 0);
         require 'vendor/autoload.php';
         include "library/includes/config.php";
         include "library/includes/initialize.php";
         $help=new classes\helpers();
	 $school3=new classes\School();
	 $school=$school3->getAcademicYearTerm();
         $config=$school3->getConfig();
	 $student=new classes\Student();
         $app=new classes\structure();
         $studentNo=$help->getIndex($_GET[student]);
         $notify=new classes\Notifications();
        
  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Terminal Report</title>
<?php  $app->gethead(); ?>
<style>
    html{
        font-size: 15px;
    }
</style>
</head>
<body>
    
    
   <table width=" " height="" border="0" style=""  >
  <tr>
      <td style="text-align: center;text-transform: uppercase;width: 200px"><h4>Asamankese Senior High School<br/>
              P.O.BOX 110, Asamankese E/R<br/>Tel:</h4>
      </td>
      <td valign="baseline"><img <?php echo $help->picture("studentPhotos/$studentNo.jpg",120)?> style="margin-left: -156px" src="<?php echo "studentPhotos/$studentNo.jpg" ?>" alt="" /></td>
      <u></u>
  </tr>
        
       <tr><td style="text-align: center;"><h4>STUDENTS REPORT</h4></td></tr>
       
       <tr><td>&nbsp;</td></tr>
  <tr>
      
    <th height="47" align="center" valign="top" scope="row"><div align="center">
        <div   style="  ">
          <table  width="934"  border="0" cellspacing="1">
              <tr>
              <td height="21"     scope="row">NAME:</td>
              <th width="" height="21" align="center"   scope="row">
                <?php 
			$thisterm=$school->TERM;
			$thisyear=$school->YEAR;
			  $query=$sql->Prepare("Select *,tbl_class_members.class as stage from tbl_student,tbl_classes,tbl_class_members where tbl_student.ID='$_GET[student]'  and tbl_class_members.student=tbl_student.indexno and tbl_classes.name=tbl_student.class and tbl_class_members.year='$thisyear' and tbl_class_members.term='$thisterm' ");
                        
                          $result=$sql->Execute($query) ; 
                         
                        while($row = $result->FetchRow())
                        { 

                        ?>
             <div align="left"><?php  echo $row['SURNAME'].", ".$row['OTHERNAMES']; ?> </div></th>
              
              
              <td width="" align="center" valign="middle" scope="row"><div align="right" >CLASS :</div></th>
              <th align="center" valign="middle" scope="row"><div align="left"> <?php echo $sta=$row['stage'] ?></div></th>
                 </tr>
            <tr>
              <th height="22" scope="row"><div align="right" class="style11">
                <div align="left">YEAR:</div>
              </div></th>
              <th scope="row"><div align="left"><?php echo $school->YEAR; ?></div></th>
              <td scope="row"><div align="right" class="style11">TERM </div></td>
              <th width="30%" scope="row"><div align="left">: <?php echo $school->TERM; ?></div></th>
            </tr>
            <tr>
              <th height="20" scope="row"><div align="right" class="style11">
                <div align="left"><strong>NO.ON ROLL:</strong></div>
              </div></th>
              <th height="20" scope="row"><div align="left">
                <?php echo $student->getTotalStudent_by_Class($row['class'],$school->YEAR,$school->TERM) ?>
		   
              </div></th>
              <td scope="row"><div align="right" class="style11">PROGRAMME:</div></td>
              <td width="30%" scope="row"><div align=" "><?php  echo $row['PROGRAMME']; ?> </div></th>
             </td>
            </tr>
            <tr>
              <td width="12%" nowrap='nowrap' scope="row"><div align="right" class="style11">
                <div align="left">NEXT TERM BEGINS:</div>
              </div></td>
              <td scope="row"><div align="left">
                
               
                  <?php $term=($school->YEAR)%3; 
                    $newterm= ++$term;
                    if($newterm==1){$newyear=$help->nextyear($school->YEAR);}
                    else{ $newyear=$school->YEAR;}
                     }
                    $stmt=$sql->Prepare("select BEGINS from tbl_academic_year where year='$newyear' and term='$newterm'");
                     
                    $stmt=$sql->Execute($stmt);
                     while($year=$stmt->FetchRow()){
                     echo  date("d/m/Y",$year[BEGINS]);
                     }
                     ?>
                     &nbsp;</div>            <div align="right"></div>            <div align="left"></div></td>
              <td nowrap='nowrap' scope="row"><div align="right" class="style11"></div></td>
              <td scope="row"><div align="left"></div></td>
            </tr>
          </table>
        </div>
        <hr/>
        <h4>Core Subjects</h4>
        <table width="92%" style="font-size:15px" height="" border="1"  class="table table-bordered" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
        <thead style="background-color:#009688;color:#FFFCBE">
          <tr>
            <td  width="198" height="48" ><strong>Subject</strong></td>
              <td  width="122"><div align="center"><strong>Class Score 30%</strong></div></td>
              <td  width="122"><div align="center"><strong>Exam Score 70%</strong></div></td>
              <td  width="122"><div align="center"><strong>Total Score 100%</strong></div></td>
              <td ><div align="center"><strong>Grade</strong></div></td>
              <td ><div align="center">Position</div></td>
              <td ><div align="center"><strong>Class Teacher's Remark  </strong></div></td>
            </tr>
          </thead>
        <tbody>
  
          <tr bordercolor="#AED7FF"    >
            <?php 
		  
		  
		$stmt=$sql->Prepare("select * from tbl_assesments,tbl_courses,tbl_subjects where tbl_assesments.stuId='$_GET[student]' and tbl_assesments.year='$school->YEAR' and tbl_assesments.term='$school->TERM' and tbl_assesments.courseId=tbl_courses.id and tbl_subjects.name=tbl_courses.name order by tbl_subjects.type ASC,tbl_subjects.name ASC");
		print_r($stmt); 
                $stmt=$sql->Execute($stmt);
                $t=$stmt->RecordCount();

                while($r =$stmt->FetchRow())

                {

                ?>
          <tr >
            <td height="43" nowrap='nowrap' ><div align="left"><?php echo $r[name]; ?></div></td>
              <td ><div align="center"><?php echo ($r[test1]+$r[test2]+$r[test3]+$r[test4])*0.3 ;?></div></td>
              <td ><div align="center"><?php echo $r[exam];?></div></td>
              <td ><div align="center"><?php echo $r[total]; $ttotal+=$r[total]; if($r['total']>0){ $cout=$cout+100;}?></div></td>
              <td width="81" >
                <div align="center">
                  <?php 
                   $stmt=$sql->Prepare("select grade,valu,comment from tbl_gradedefinition where   lower <='$r[total]'  and upper >= '$r[total]'") ;
                  $stmt=$sql->Execute($stmt);
                  while($rq= $stmt->FetchRow($stmt)){
				  echo $rq['grade'];
				  $va=$rq['valu'];
				  $co=$rq['comment'];
				  }
				  $aggregade+=$va;
				  ?>
              </div></td>
              <td width="80" ><div align="center"><?php echo $r['posInSubject'];?></div></td>
              <td width="157"  ><div align="center"><?php echo $co;
				  ?></div></td>
              <?php 
				  
    } ?>
          
            <tr>
          
            <td  ><div align="right">Total Score : </div></td>
            <td  ><?php echo $ttotal."/".$cout; ?></td>
            <td  ><div align="right">Average Score : </div></td>
            <td > <?php echo number_format(@($ttotal/$t), 2, '.', ',')."%"; ?> </td>
            <td colspan="2" ><div align="right"></div></td>
            <td >&nbsp;</td>
            </tr>
          </tbody>
        <tfoot>
          </tfoot>
        <tfoot>
          </tfoot>

      </table>
    </div></th>
  </tr>
  <tr>
    <th valign="top" scope="row">      <hr/>
<table width="92%" style=" " height="496" border="0" align="center">
      <tr></tr>
      <tr>
        <td width="291" height="47"><div align="left"><span class="style11">ATTENDANCE</span>:
          <?php 
		
		 $stmt=$sql->Prepare("select * from tbl_class_members where student='$studentNo' and year='$school->YEAR' and term='$school->TERM'");
                  
                 $stmt=$sql->Execute($stmt);
                $t=$stmt->RecordCount();
            while($r =$stmt->FetchRow())

            { echo $r[attendance]; ?>
        </div></td>
        <td width="231"><div align="right">Promoted to : </div></td>
        <td width="243"><div align="left">
          <?php  echo $r['promotedTo']; ?>
        </div>
          <div align="right"></div></td>
      </tr>
      <tr>
        <td  colspan="3"><div align="left"><span class="style11">CONDUCT</span> : 
          <?php  echo $r[conduct]; ?>
          </div></td>
      </tr>
      <tr>
        <td  colspan="3" align="left"><span class="style11">ATTITUDE</span> :
          <?php  echo $r[attitude]; ?></td>
      </tr>
      <tr>
        <td  colspan="3" align="left"><span class="style11">INTEREST</span> :
          <?php  echo $r[interest]; ?></td>
      </tr>
      
      <tr>
        <td  colspan="3"><div align="left">
          <span class="style11">CLASS TEACHER'S REPORT:</span> <?php echo $r[form_mast_report]; ?> 
          </div></td>
      </tr>
      <tr>
        <td  colspan="3"><div align="left">
          <p><span class="style11">HEADMASTER'S REMARKS </span>:<?php echo $r[head_mast_report]; }?></p>
        </div>          
          </label></td>
      </tr>
      <tr>
        <td><p align="center"><img src="images/signature.jpg" alt="..................." width="243" height="90" /></p>          </td>
         
      </tr>
      <tr>
          <td><div align="center"><?PHP  echo $config->SCHOOL_HEAD;?> <br/>(Head Teacher )</div></td>
         
      </tr>
      
    </table></th>
  </tr>
</table>
    <script>
    window.print();
    </script>
</body>