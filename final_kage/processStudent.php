<?php
session_start();
ini_set('display_errors', 0);
 
 

$student=$_SESSION['indexno'];
$stmt = $sql->Prepare("select ID,CLASS,SUBJECT_COMBINATIONS from tbl_student WHERE INDEXNO='$student' ");
$output = $sql->Execute($stmt);
$year = $school->YEAR;
$term = $school->TERM;
while ($rt = $output->FetchRow()) {



    if ($rt['SUBJECT_COMBINATIONS'] != "") {
        $combinator = explode("|", $rt['SUBJECT_COMBINATIONS']);

        
        $input = $sql->Prepare("select tbl_courses.id as ID from tbl_courses,tbl_subjects where classId='$rt[CLASS]' and tbl_courses.name=tbl_subjects.name and tbl_subjects.type='elective' and (tbl_subjects.shortcode='$combinator[0]' or tbl_subjects.shortcode='$combinator[1]' or tbl_subjects.shortcode='$combinator[2]' or tbl_subjects.shortcode='$combinator[3]') ");
         
        $out = $sql->Execute($input);
        
        while ($row = $out->FetchRow()) {
           
            $rmt = $sql->Prepare("select * from tbl_assesments where courseId='$row[ID]' and stuId='$rt[ID]' and year='$year' and term='$term'");
            
            $rts = $sql->Execute($rmt);
              
            if ($rts->RecordCount() > 0) {
                  
            } else {
                
                $query12 = $sql->Prepare("insert into tbl_assesments(courseId,stuId,class,year,term) values('$row[ID]', '$rt[ID]', '$rt[CLASS]', '$year', '$term' )");
                
                $sql->Execute($query12);
            }
        }



        $input = $sql->Prepare("select tbl_courses.id as ID from tbl_courses,tbl_subjects where classId='$rt[CLASS]' and tbl_courses.name=tbl_subjects.name and tbl_subjects.type='core'");

        $rtmt = $sql->Execute($input);
        while ($rt = $rtmt->FetchRow()) {

            $in = $sql->Prepare("select * from tbl_assesments where courseId='$rt[ID]' and stuId='$rt[ID]' and year='$year' and term='$term'");
             
            $qt = $sql->Execute($in);
             if ($qt->RecordCount() > 0) {
                
            } else {
                 $stmt22 = $sql->Prepare("select ID,CLASS,SUBJECT_COMBINATIONS from tbl_student WHERE INDEXNO='$student' ");
                 print_r($stmt22);
                 $ss=$sql->Execute( $stmt22);
                 $rw=$ss->FetchNextObject();
                 $inner = $sql->Prepare("insert into tbl_assesments(courseId,stuId,class,year,term) values('$rt[ID]', '$rw->ID', '$rw->CLASS', '$year', '$term' )");
                 print_r($inner);
                 $sql->Execute($inner);
            
            }
        }
    }

// else he is not having any combination
    else {

        $query = $sql->Prepare("SELECT tbl_courses.id as ID from tbl_courses where classId='$rt[CLASS]' ");
        $rtmt = $sql->Execute($query);

        while ($row = $rmt->FetchRow()) {

            $in = $sql->Prepare("SELECT * from tbl_assesments where courseId='$row[ID]' and stuId='$rt[ID]' and year='$year' and term='$term'");
            $exe = $sql->Execute($in);
            if  ($exe->RecordCount() > 0) {
                
            } else {
                $query22 = $sql->Prepare("insert into tbl_assesments(courseId,stuId,class,year,term) values( '$row[ID]', '$rt[ID]', '$rt[CLASS]', '$year', '$term' ");
                $sql->Execute($query22);
            }
        }
    }
}

 
