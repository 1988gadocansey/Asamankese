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

$query=$sql->Prepare("SELECT tbl_grades.id as id,total,posInSubject ,tbl_student.indexno as stid,tbl_student.surname as surname,tbl_student.othernames as othernames,quiz1,quiz2,quiz3,exam,comments,posInSubject from tbl_student,tbl_grades,tbl_courses where tbl_grades.year='$school->YEAR' and tbl_grades.term='$school->TERM' and tbl_grades.stuId=tbl_student.indexno and tbl_grades.courseId=tbl_courses.id and tbl_courses.classId='$_GET[form]' and tbl_courses.name='$_GET[course]'");		
$query=$query." ORDER BY tbl_student.surname asc,tbl_student.othernames asc";
  
$count=1;
$stmt=$sql->Execute($query);
$array['header'][0]="No.";
$array['header'][1]="IndexNo";
$array['header'][2]="Name";
$array['header'][3]="Quiz1";
$array['header'][4]="Quiz2";
$array['header'][5]="Quiz3";
$array['header'][6]="Exam";
while($row=$stmt->FetchRow($query)){
	$array["$row[stid]"][0]=$count++;
	$array["$row[stid]"][1]=$row['stid'];
	$array["$row[stid]"][2]="$row[surname],$row[othernames]" ;
	$array["$row[stid]"][3]=$row['quiz1']*10;
	$array["$row[stid]"][4]=$row['quiz2']*10;
	$array["$row[stid]"][5]=$row['quiz3']*10;
	$array["$row[stid]"][6]=$row['exam']*10/7;
	}
	$csv = new parseCSV();
	$filename="$_GET[form]_$_GET[course]"."_$term.csv";
	$csv->output (true, $filename, $array);

?>
