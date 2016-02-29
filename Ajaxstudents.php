<?php

	//header('Content-Type: text/xml');
header("Cache-Control: no-cache, must-revalidate");
//A date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

ini_set('display_errors', 0);
    require 'vendor/autoload.php';
    include "library/includes/config.php";
global $sql;

		$input =$_GET['2'];
	
		echo "[";

 $query=$sql->Prepare("SELECT * FROM tbl_student WHERE( id like '%$input%' or SURNAME like '%$input%' or OTHERNAMES like '%$input%' )   ORDER BY  ID ASC ");		  
$sql = $sql->Execute($query);

while($r = $sql->FetchRow($sql))

{
	echo "{ name: \"$r[OTHERNAMES] $r[SURNAME] \", outstand: \"$r[OUTSTANDING]\",id: \"$r[ID]\",pic:\"studentPics/$r[INDEXNO].jpg\",form: \"$r[CLASS]\" },";

		}
	echo "]";
	
?>
 