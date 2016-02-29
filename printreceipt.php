<?php 
ini_set('display_errors', 0);
             require 'vendor/autoload.php';
             include "library/includes/config.php";
             include "library/includes/initialize.php";
             $help=new classes\helpers();
             $school=new classes\School();
             $config=$school->getConfig();
             $log=new classes\Login();
             $school=$school->getAcademicYearTerm();
	       $student=new classes\Student();  
            $pupil= $student->getStudent($_GET[student]);
            $teacher=new classes\Teacher();  $teacher2=$teacher->getTeacher_ID($_SESSION[ID]);
            
              $app=new classes\structure();
              $log->setLog("Fees Payment", "$teacher2->NAME.' '.$teacher2->SURNAME has received fees of GHC$_SESSION[amount] From  $pupil->SURNAME  .' '.  $pupil->OTHERNAMES");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>receipt</title>
<link rel="stylesheet" href="assets/css/styles.mincce7.css?=121">
</head>
    <a href="students.php">Goto home</a>
<body style="font-family:tahoma" onload="window.print() ">
    
<table width="847" height="242" border="0" cellspacing="5">
 <?php for($i=1;$i<3;$i++){?> 
 <tr>
  
    <td><table width="200" border="0">
        <tr>
          <td   style="border:dashed"><table width="738" height="191" border="0" cellspacing="7">
            <tr>
              <td colspan="5"><p>&nbsp;</p>
                  <p align="center"><img src="images/printout.JPG" alt="df" style="width:744px;height:191px" /></p></td>
            </tr>
            <tr>
              <td><div align="right"><strong>
                 
                Date</strong></div></td>
              <td colspan="2" style="border-bottom-style:dotted"><?php echo date('D, d/m/Y') ?>&nbsp;</td>
              <td><div style="text-align:right"><strong>Receitpt No</strong></div></td>
              <td style="border-bottom-style:dotted"><?php echo  $_SESSION[receipt]; ?>&nbsp;</td>
            </tr>
             
            <tr>
              <td width="145"  style="text-align:right"><strong>Received from</strong></td>
              <td colspan="4" style="border-bottom-style:dotted"><?php echo  $pupil->SURNAME  ." ".  $pupil->OTHERNAMES  ?>&nbsp;</td>

            </tr>
             <tr>
              <td width="145"  style="text-align:right"><strong>Being</strong></td>
              <td colspan="4" style="border-bottom-style:dotted"> Payment of <?php echo $_GET[type]?> Fees/dues&nbsp;</td>

            </tr>
            <tr>
              <td  style="text-align:right"><strong >Amount Paid</strong></td>
              <td colspan="4" style=" border-bottom-style:dotted"><span style="border-bottom-style:dotted">GH¢<?php $_GET[paid]  ?></span> <?php echo $_GET['paid']; ?>&nbsp;(<span ><?php echo $help->convert($_GET['paid']);  ?>)</span> )</td>
            </tr>
             
            <tr>
              <td rowspan="2">&nbsp;</td>
              <td colspan="2" width="215" style="border-bottom-style:dotted"> </td>
              <td colspan="2">&nbsp;</td>
              <td rowspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2"><?php echo $config->SCHOOL_ACCOUNTANT ?><br/>(Accountant)</td>
              
            </tr>
          </table></td>
        </tr>
      </table></td>
  
  </tr> 
</table>
<?php } ?>
</body>
</html>

 