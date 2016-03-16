<?php
ini_set('display_errors',0);
     require 'vendor/autoload.php';
     include "library/includes/config.php";
     include "library/includes/initialize.php"; 
     include('parsecsv.lib.php');
     $help=new classes\helpers();
     $school=new classes\School();
     $school=$school->getAcademicYearTerm();
     $student=new classes\Student();
       		   
     $app=new classes\structure();
     $help=new classes\helpers();
     $notify=new classes\Notifications();

$query=$sql->Prepare("SELECT tbl_assesments.id as id,total,posInSubject ,tbl_student.indexno as stid,tbl_student.surname as surname,tbl_student.othernames as othernames,test1,test2,test3,exam,comments,posInSubject from tbl_student,tbl_assesments,tbl_courses where tbl_assesments.year='$school->YEAR' and tbl_assesments.term='$school->TERM' and tbl_assesments.stuId=tbl_student.id and tbl_assesments.courseId=tbl_courses.id and tbl_courses.classId='$_GET[form]' and tbl_courses.id='$_GET[course]'");		
$query1=$query." ORDER BY tbl_student.surname asc,tbl_student.othernames asc";
 
$count=1;
$stmt=$sql->Execute($query1);
$array['header'][0]="No.";
$array['header'][1]="IndexNo";
$array['header'][2]="Name";
$array['header'][3]="Class Work";
 
$array['header'][6]="Exam";
while($row=$stmt->FetchRow()){
	$array["$row[stid]"][0]=$count++;
	$array["$row[stid]"][1]=$row['stid'];
	$array["$row[stid]"][2]="$row[surname],$row[othernames]" ;
	$array["$row[stid]"][3]=$row['test1'];
	 
	$array["$row[stid]"][6]=$row['exam'];
	}
	$csv = new parseCSV();
	$filename="$_GET[form]_$_GET[course]"."_$term.csv";
	$csv->output (true, $filename, $array);

?>
