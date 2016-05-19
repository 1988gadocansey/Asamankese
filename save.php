<?php
session_start();
echo $student=$_SESSION['indexno'];
if($_SESSION['indexno']){
if(isset($GLOBALS["HTTP_RAW_POST_DATA"])){
	$jpg = $GLOBALS["HTTP_RAW_POST_DATA"];
	$img = $_GET["img"];
	$filename = "studentPics/$student.jpg";
	file_put_contents($filename, $jpg);
} else{
	echo "Encoded JPEG information not received.";
}

}

if(isset($GLOBALS["HTTP_RAW_POST_DATA"])){
	$jpg = $GLOBALS["HTTP_RAW_POST_DATA"];
	$img = $_GET["img"];
	$filename = "workerPics/$_SESSION[emp_number].jpg";
	file_put_contents($filename, $jpg);
} else{
	echo "Encoded JPEG information not received.";
}
?>