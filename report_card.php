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
         $teacher=new classes\Teacher();   
                
        
  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Terminal Report</title>
<?php  $app->gethead(); ?>
<style>
    html{
        font-size: 14px;
    }
    #report{
       
        border: #ff9900;
         border-style: solid;
         display: table;
        border-collapse: separate;
        border: solid 1px #98BF21;
        line-height: 1.4em;
        border-collapse:separate;
    }
    #report td ,th{
        border: 1px solid #98BF21;
        padding: 3px 7px 2px;
        background-color: #EAF2D3;
        padding: 3px 7px 2px;
    }
</style>
</head>
<body>
    <?php
     
      $thisterm = $school->TERM;
    $thisyear = $school->YEAR;
    $query = $sql->Prepare("Select *,tbl_class_members.class as stage from tbl_student,tbl_classes,tbl_class_members where tbl_student.ID='$_GET[student]'  and tbl_class_members.student=tbl_student.indexno and tbl_classes.name=tbl_student.class and tbl_class_members.year='$thisyear' and tbl_class_members.term='$thisterm' ");

    $result = $sql->Execute($query);
    $row = $result->FetchNextObject();
    $term = ($school->YEAR) % 3;
    $newterm = ++$term;
    if ($newterm == 1) {
        $newyear = $help->nextyear($school->YEAR);
    } else {
        $newyear = $school->YEAR;
    }
    ?>
    <table align="center"  >
        <tr>
            <td><img src="images/logo1.png" style="width:90px;height: auto"/></td>
            <td style="text-align: center;text-transform: uppercase;width: 460px"><h4>Asamankese Senior High School<br/>
              P.O.BOX 110, Asamankese E/R<br/>Tel:</h4>
                <hr style="color:black">
      </td>
             <td valign="baseline"><img <?php echo $help->picture("studentPhotos/$studentNo.jpg",120)?> style="margin-left: 103px" src="<?php echo "studentPhotos/$studentNo.jpg" ?>" alt="" /></td>
      
        </tr>
        <tr>
            <td colspan="5" style="border-color:#ff9900">
                <div style='margin-left: 243px;'><h4> <STUDENT REPORT<h4></div>
            </td>
        </tr>
    </table>
    <div style="margin-left: 494px;background-color: #ff9900;padding:6px;width: 200px;color:white"><b><?php echo $row->SURNAME.' '.$row->FIRTNAME.' '.$row->OTHERNAMES; ?></b></div>
    <br/>
    <center><table id="transcript" class='table table-vmiddle'>

            <tr>
                 <td  colspan=""><div align="left"><span class="rp">CLASS</span> : 
                <?php echo strtoupper($row->CLASS); ?>
                </div></td>  
                
                 <td>&nbsp;</td>
                 
                <td  colspan=""><div align="left"><span class="rp">TERM</span> : 
                <?php echo$school->TERM; ?>
                </div></td>
                 <td>&nbsp;</td>
                 
                <td  colspan=""><div align="left"><span class="rp">CLOSING DATE</span> : 
                 <?php
                    $terms=$sql->Prepare("select ENDS from tbl_academic_year where year='$school->YEAR' and term='$school->TERM'");
                    //print_r($terms);
                    $tterms=$sql->Execute($terms);
                     while($y=$tterms->FetchRow()){
                     echo   date('d/m/Y',$y[ENDS]);
                     }
                     ?>
                </div></td>
                
            </tr>
             <tr>
                 <td  colspan=""><div align="left"><span class="rp">YEAR</span> : 
                <?php echo strtoupper($school->YEAR); ?>
                </div></td>  
                 <td>&nbsp;</td>
                 
                <td  colspan=""><div align="left"><span class="rp">STUDENT ID</span> : 
                <?php echo$row->INDEXNO; ?>
                </div></td>
                 <td>&nbsp;</td>
                 
                <td  colspan=""><div align="left"><span class="rp">REOPENING</span> : 
                 <?php
                    $terms=$sql->Prepare("select ENDS from tbl_academic_year where year='$school->YEAR' and term='$school->TERM'");
                    //print_r($terms);
                    $tterms=$sql->Execute($terms);
                     while($y=$tterms->FetchRow()){
                     echo   date('d/m/Y',$y[ENDS]);
                     }
                     ?>
                </div></td>
                
            </tr>
            
            
                <tr>
                 <td  colspan=""><div align="left"><span class="rp">PROGRAMME</span> : 
                <?php echo $row->PROGRAMME; ?>
                </div></td>  
                 <td>&nbsp;</td>
                 
                <td  colspan=""><div align="left"><span class="rp">HOUSE</span> : 
                <?php echo$row->HOUSE; ?>
                </div></td>
                 <td>&nbsp;</td>
                 
                <td  colspan=""><div align="left"><span class="rp">POSITION IN CLASS</span> : 
                   
                <?php echo$row->POSITION; ?>
                </div></td>
                </div></td>
                
            </tr>
     </table></center>
    
        <hr/>
         
        <table width="92%" style="font-size:15px" height="" border="1"  class="table table-bordered" cellpadding="1" border="1" id='report' bordercolor="#FFFFFF">
        <thead >
          <tr>
            <td  width="198" height="48" ><strong>Core Subjects</strong></td>
              <td  width="122"><div align="center"><strong>Class Score 30%</strong></div></td>
              <td  width="122"><div align="center"><strong>Exam Score 70%</strong></div></td>
              <td  width="122"><div align="center"><strong>Total Score 100%</strong></div></td>
              <td><div align="center"><strong>Grade</strong></div></td>
              <td><div align="center"><strong>Position</strong></div></td>
              <td><div align="center"><strong>Remarks  </strong></div></td>
              <td><div align="center"><strong>Sign  </strong></div></td>
            </tr>
          </thead>
        <tbody>
  
          <tr>
            <?php 
		  
		  
		$stmt22=$sql->Prepare("select * from tbl_assesments,tbl_courses,tbl_subjects where tbl_assesments.stuId='$_GET[student]' and tbl_assesments.year='$school->YEAR' and tbl_assesments.term='$school->TERM' and tbl_assesments.courseId=tbl_courses.id and tbl_subjects.name=tbl_courses.name and tbl_subjects.type='core' order by tbl_subjects.type ASC,tbl_subjects.name ASC");
		 
                $stmt21=$sql->Execute($stmt22);
                $t=$stmt21->RecordCount();

                while($r =$stmt21->FetchRow())

                {

                ?>
          <tr>
            <td height="43" nowrap='nowrap' ><div align="left"><?php echo $r[name]; ?></div></td>
              <td ><div align="center"><?php $_SESSION[teach]=$r[teacherId];echo ($r[test1]+$r[test2]+$r[test3]+$r[test4])*0.3 ;?></div></td>
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
              <td width="157"  ><div align="center"><?php echo strtoupper($teacher->getSignature($_SESSION[teach]));
                  ?></div></td>
              <?php 
				  
             } ?>
          </tr>
              <!--  Electives -->
              <tr><td><div align="left" style="margin-left:5px"><h4>Elective Subjects<h4></div></td></tr>
     <?php 
		  
		  
		$stmt2=$sql->Prepare("select * from tbl_assesments,tbl_courses,tbl_subjects where tbl_assesments.stuId='$_GET[student]' and tbl_assesments.year='$school->YEAR' and tbl_assesments.term='$school->TERM' and tbl_assesments.courseId=tbl_courses.id and tbl_subjects.name=tbl_courses.name and tbl_subjects.type='elective' order by tbl_subjects.type ASC,tbl_subjects.name ASC");
		  
                $stmt3=$sql->Execute($stmt2);
                $t=$stmt3->RecordCount();

                while($r =$stmt3->FetchRow())

                {
                     

                ?>
          <tr>
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
              <td width="157"  ><div align="center"><?php echo strtoupper($teacher->getSignature($r[teacherId]));
                  ?></div></td>
              <?php 
				  
             } ?>
          </tr>
            <tr>
          
            <td  ><div align="right">Total Score : </div></td>
            <td  ><?php echo $ttotal."/".$cout; ?></td>
            <td  ><div align="right">Average Score : </div></td>
            <td > <?php echo number_format(@($ttotal/$t), 2, '.', ',')."%"; ?> </td>
            <td colspan="2" ><div align="right"></div></td>
            <td >&nbsp;</td>
            </tr>
          </tr>
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
        <td width="291" height="47"><div align="left"><span class="rp">ATTENDANCE</span>:
          <?php 
		
		 $stmt=$sql->Prepare("select * from tbl_class_members where student='$studentNo' and year='$school->YEAR' and term='$school->TERM'");
                  
                 $stmt=$sql->Execute($stmt);
                $t=$stmt->RecordCount();
            while($r =$stmt->FetchRow())

            { echo $r[attendance]; ?>
        </div></td>
        <td width="231"><div align="right">PROMOTED TO : </div></td>
        <td width="243"><div align="left">
          <?php  echo $r['promotedTo']; ?>
        </div>
          <div align="right"></div></td>
      </tr>
      <tr>
        <td  colspan=""><div align="left"><span class="rp">CONDUCT</span> : 
          <?php  echo $r[conduct]; ?>
          </div></td>
      
        <td  colspan="" align="left"><span class="rp">ATTITUDE</span> :
          <?php  echo $r[attitude]; ?></td>
       
        <td    align="left"><span class="rp">INTEREST</span> :
          <?php  echo $r[interest]; ?></td>
      </tr>
      
      <tr>
        <td><div align="left">
          <span class="rp">FORM MASTER'S REMARK:</span> <?php echo $r[house_mast_report]; ?> 
          </div></td>
      </tr>
      <tr>
        <td><div align="left">
          <span class="rp">HOUSE MASTER'S REMARK:</span> <?php echo $r[form_mast_report]; ?> 
          </div></td>
      </tr>
      <tr>
        <td><div align="left">
          <p><span class="rp">HEAD OF INSTITUTION'S REMARKS </span>:<?php echo $r[head_mast_report]; }?></p>
        </div>          
          </label></td>
      </tr>
      <tr>
          <td style="" colspan="4"align="center"> <img src="images/signature.jpg" alt="..................."style="width:234px;height: auto" />          
         
      
           <div align="center"><?PHP  echo $config->SCHOOL_HEAD;?> <br/>(Head Teacher )</div></td>
         
      </tr>
      
    </table></th>
  </tr>
</table>
<div align="center"><small>Powered by DEK IT Consult(Softbox) | Elmina-Cape Coast C/R Tel:+244505284060,+233241999094 www.dekITC.com</small></div>
    <script>
    window.print();
    </script>
</body>