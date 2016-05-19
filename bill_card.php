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
         $help=new classes\helpers();
         $notify=new classes\Notifications();
        
  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bill Printing</title>
<?php  $app->gethead(); ?>
<style>
    html{
        font-size: 15px;
    }
</style>
</head>
<body>
    
   <table width="81%" height="" border="0" style="" align="center">
  <tr>
      <th height="121" align="center" valign="bottom" scope="row"><img src="images/printout.png" alt="banner" width="92%" height="220" /></th>
  </tr>
       <tr><td>&nbsp;</td></tr>
  <tr>
      
    <th height="47" align="center" valign="top" scope="row"><div align="center">
        <div class="curve" style="border:thick;">
          <table  width="934"  border="0" cellspacing="1">
              <tr>
              <th height="21" align="center"    valign="middle" scope="row"><p align="left" class=" ">NAME:</p></th>
              <th width="32%" height="21" align="center" valign="middle" scope="row">
                <?php 
			$thisterm=$school->TERM;
			$thisyear=$school->YEAR;
			  $query=$sql->Prepare("Select *,tbl_class_members.class as stage from tbl_student,tbl_classes,tbl_class_members where tbl_student.indexno='$_GET[student]'  and tbl_class_members.student=tbl_student.indexno and tbl_classes.name=tbl_student.class and tbl_class_members.year='$thisyear' and tbl_class_members.term='$thisterm' ");
                        $result=$sql->Execute($query) ; 
                         
                        while($row = $result->FetchRow())
                        { 

                        ?>
             <div align="left"><?php  echo $row['SURNAME'].", ".$row['OTHERNAMES']; ?> </div></th>
              <th width="15%" align="center" valign="middle" scope="row"><div align="right" class="style11">CLASS :</div></th>
              <th align="center" valign="middle" scope="row"><div align="left"> <?php echo $sta=$row['stage'] ?></div></th>
              <th width="11%" colspan="2" rowspan="4" align="center" valign="middle" scope="row"><img <?php echo $help->picture("studentPics/$_GET[student].jpg",120)?> style="margin-left:-70%" src="<?php echo "studentPics/$_GET[student].jpg" ?>" alt="" /></th>
            </tr>
            <tr>
              <th height="22" scope="row"><div align="right" class="style11">
                <div align="left">YEAR:</div>
              </div></th>
              <th scope="row"><div align="left"><?php echo $school->YEAR; ?></div></th>
              <th scope="row"><div align="right" class="style11">TERM </div></th>
              <th width="30%" scope="row"><div align="left">: <?php echo $school->TERM; ?></div></th>
            </tr>
            <tr>
              <th height="20" scope="row"><div align="right" class="style11">
                <div align="left"><strong>NO.ON ROLL:</strong></div>
              </div></th>
              <th height="20" scope="row"><div align="left">
                <?php echo $student->getTotalStudent_by_Class($row['class'],$school->YEAR,$school->TERM) ?>
		   
              </div></th>
              <th scope="row"><div align="right" class="style11">DATE:</div></th>
              <th scope="row"><div align="left"><?php echo date('D, d/m/Y') ?></div></th>
            </tr>
            <tr>
              <th width="12%" nowrap='nowrap' scope="row"><div align="right" class="style11">
                <div align="left">NEXT TERM BEGINS:</div>
              </div></th>
              <th scope="row"><div align="left">
                
               
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
                     &nbsp;</div>            <div align="right"></div>            <div align="left"></div></th>
              <th nowrap='nowrap' scope="row"><div align="right" class="style11"></div></th>
              <th scope="row"><div align="left"></div></th>
            </tr>
          </table>
        </div>
        <hr/>
        <table width="92%" style="font-size:15px" height="" border="1"  class="table table-bordered" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF">
        <thead style="background-color:#009688;color:#FFFCBE">
          <tr>
            <td  width="198" height="48" ><strong>Subject</strong></td>
              <td  width="122"><div align="center"><strong>Class Score 50%</strong></div></td>
              <td  width="122"><div align="center"><strong>Exam Score 50%</strong></div></td>
              <td  width="122"><div align="center"><strong>Total Score 100%</strong></div></td>
              <td ><div align="center"><strong>Grade</strong></div></td>
              <td ><div align="center">Position</div></td>
              <td ><div align="center"><strong>Class Teacher's Remark  </strong></div></td>
            </tr>
          </thead>
        <tbody>
  
          <tr bordercolor="#AED7FF"    >
            <?php 
		  
		  
		$stmt=$sql->Prepare("select * from tbl_grades,tbl_courses,tbl_subjects where tbl_grades.stuId='$_GET[student]' and tbl_grades.year='$school->YEAR' and tbl_grades.term='$school->TERM' and tbl_grades.courseId=tbl_courses.id and tbl_subjects.type='core' and tbl_subjects.name=tbl_courses.name");
		$stmt=$sql->Execute($stmt);
                $t=$stmt->RecordCount();

                while($r =$stmt->FetchRow())

                {

                ?>
          <tr bordercolor="#AED7FF"  bgcolor="<?php echo (((++$AltColors1) % 2) == 0) ? "#F7F0DB" : "#FFFFFF"; ?>"  >
            <td height="43" nowrap='nowrap' ><div align="left"><?php echo $r[name]; ?></div></td>
              <td ><div align="center"><?php echo ($r[quiz1]+$r[quiz2]+$r[quiz3]+$r[quiz4]) ;?></div></td>
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
		
		 $stmt=$sql->Prepare("select * from tbl_class_members where student='$_GET[student]' and year='$school->YEAR' and term='$school->TERM'");
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