<?php
	header("Content-Type: text/xml");
	//header('Content-Type: text/xml');
header("Cache-Control: no-cache, must-revalidate");
//A date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");


	$table=$_GET[table];
	$rol=$_GET[rol];
	$input =( $_GET['input'] );
	echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
echo "<results>";

$query="SELECT  FROM $table where $rol like '%$input%' ORDER BY  $rol ASC ";		  
$sql = mysql_query($query,$all) or die (mysql_error());

while($r = mysql_fetch_array($sql))

{
		echo"	<rs>".$r[$rol]."</rs>";}
	echo "</results>";
	
?>