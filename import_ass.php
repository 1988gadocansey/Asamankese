<?php
ini_set('display_errors', 0);
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

    if(isset($_POST['upload'])){	


//if insert picture button is cliked 

		//check if file path is empty
if (!$_FILES["file"]["name"])  {echo " <font color='red' style='text-decoration:blink'>Please choose a file to upload</font>"; $error=1;}
  //check if file type is jpeg 
  
  //elseif ($_FILES["file"]["type"]!="image/jpeg" and $_FILES["file"]["type"]!="image/pjpeg"  ){echo " <font color='red' style='text-decoration:blink'>Only jpeg formats accepted </font>";   		$error=2;  }
 		elseif (($_FILES["file"]["size"] )>25000000) {echo "Only pictures of size less than 250 kb accepted"; $error=3;  }

	 $name=$_FILES["file"]["name"];
	 //$var= $name.$_SESSION[area];
	 
	 if($error>0){} else{
		 
	 $destination="files/$name";
     move_uploaded_file($_FILES["file"]["tmp_name"],
     $destination);
     if (move_uploaded_file) {
		 
		 # create new parseCSV object.
$csv = new parseCSV();
# Parse '_books.csv' using automatic delimiter detection...
$csv->auto($destination);


 //print_r($csv->data);

foreach ($csv->data as $key => $row){

{
//$exam=number_format($_POST[$], 1, '.', ',');
 $quiz1=number_format($row['Quiz1'], 1, '.', ',');
 $quiz1=number_format($row['Quiz2'], 1, '.', ',');
 $quiz1=number_format($row['Quiz3'], 1, '.', ',');
 $exam=number_format($row['Exam']*.70, 1, '.', ',');
 $indexno=$row[IndexNo];
 
 
 //$comments=$_POST[$comments];
 $tot=$quiz1+$exam;
 
 
	//update grades in quizes and exan and total
	
	
	 $pp=mysql_query("select id from grades where stuId='$indexno' and courseId='$courseid' and class='$_GET[form]'")or die(mysql_error());

if(mysql_num_rows($pp)==1){	
	 $mm="update grades set quiz1='$quiz1',exam='$exam',total='$tot' where  stuId='$indexno' and courseId='$courseid' and class='$_GET[form]'";
	mysql_query($mm) or die(mysql_error());


	
	//mysql_query("update grades set quiz1='$quiz1',exam='$exam',total='$tot' where  id='$id'") or die(mysql_error());
	
	//update students total score in that class for that year inside the class records which is == to the total of all scores in all courses taken in that year
	//first select the total of total scores of all scores in all subject in that year
 $aa="select sum(total) as total from grades where stuId='$indexno' and year='$_SESSION[currentyear]' and term='$_SESSION[currentterm]'";
	$sub=mysql_query($aa)or die(mysql_error());
//echo mysql_num_rows($sub)."?";
	while($u=mysql_fetch_array($sub)){
//echo $u[total]."ID= $student \n ";
	mysql_query("update classmems set total='$u[total]' where stuId='$indexno' and year='$_SESSION[currentyear]' and term='$_SESSION[currentterm]'") or die(mysql_error());
	}
	
} 
 
//$comments=$_POST[$comments];
		 // $tot=$quiz1+$exam+$quiz2;
	//update grades in quizes and exan and total

}
}







$query="SELECT grades.id as id,grades.total as total from students,grades,courses where grades.year='$_SESSION[currentyear]' and grades.term='$_SESSION[currentterm]'  and grades.stuId=students.id and grades.courseId=courses.id and courses.classId='$_GET[form]' and courses.name='$_GET[course]'";		
$query=$query." ORDER BY grades.total desc ";

$inde=0;
$q=mysql_query($query);
 $row=mysql_num_rows($q);
$oldtotal=-1;
$repeat=0;
while($ra=mysql_fetch_array($q)){
$inde++;
$currentotal=$ra['total'];
//check if there is a tie then dont change pos else increse position
if($oldtotal==$currentotal){}else{$in=$inde; }
 $oldtotal=$currentotal;
 $po=$in."/".$row;
//echo "_";
 $ss="update grades set posInSubject='$po' where id='$ra[id]'";
mysql_query($ss) or die(mysql_error());

}




  $query="SELECT id,total from classmems where cname='$_GET[form]' and year='$_SESSION[currentyear]' and term='$_SESSION[currentterm]' ";		
$query=$query." ORDER BY total desc ";

$inde=0;
$q=mysql_query($query);
$row=mysql_num_rows($q);
while($r=mysql_fetch_array($q)){

$inde++;
$currentotal=$r['total'];
//check if there is a tie then dont change pos else increse position
if($oldtotal==$currentotal){}else{$in=$inde; }
 $oldtotal=$currentotal;

  $po=$in."/".$row;
 //echo "_";
  $ii="update classmems  set position ='$po' where id='$r[id]'";
mysql_query($ii) or die(mysql_error());
} 		 




		 
	} 
    		 
}	 
					
					
				}


    $app->gethead();
     
?>
 
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
                
                     
                    <div class="card">
                        <div class="card-header">
                            <h2><header>UPLOAD CONTINUOUS ASSESSMENTS HERE</header>
                            </small></h2>
                        </div>
                        
                        <div class="card-body card-padding">
                            <form action="bulk_upload_students.php?upload=biodata" role="form" method="POST" enctype="multipart/form-data">
                                <div class="row" style="overflow: scroll">
                                          <table class="table table-bordered no-margin" style="">
								<thead>
									<tr>
										<th>NO</th>
										<th>STUDENT INDEXNO</th>
										<th>QUIZ1</th>
										<th>QUIZ1</th>
                                                                                <th>QUIZ1</th>
                                                                                <th>QUIZ1</th>
                                                                                <th>EXAM (100%)</th>
                                                                                 
									</tr>
								</thead>
								<tbody>
									 
								</tbody>
							</table>
                                </div>
                                <div class="row">
                                <div class="col-sm-4">
                                     
                                    
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <span class="btn btn-primary btn-file m-r-10">
                                            <span class="fileinput-new">Select file</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="file" required="">
                                        </span>
                                        <span class="fileinput-filename"></span>
                                        <a href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>
                                    </div>
                                </div>
                            </div>
                            
                            
                                
                                <button type="submit" name="upload" class="btn btn-primary btn-sm m-t-10">Submit</button>
                            </form>
                            <br/>
                            <br/>
                             <em class="text-caption"><a href="BASIC 6_R.M.E_.csv">Click to download assessments template (NB only csv format accepted!!!)</a> </em>
                        </div>
                    </div>
                    
                     
                    
                    
                </div>
            </section>
        </section>
        
       <?php $app->getDashboardScript() ; $app->getuploadScript(); ?>
        
    </body>
  
</html>