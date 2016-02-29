<?php
$column = $_GET['selectedList'];
$table = 'tbl_student';
$columns = array(
    array( 'db' => 'INDEXNO', 'dt' => 0 ),
    array( 'db' => 'SURNAME',  'dt' => 1 ,),
    array( 'db' => 'OTHERNAMES',   'dt' => 2 ),
    array( 'db' => 'GENDER',     'dt' => 3 ),
   array( 'db' => 'CLASS',     'dt' => 4 ),
   array( 'db' => 'PROGRAMME',     'dt' => 5 ),
  array( 'db' => 'DEPARTMENT',     'dt' => 6 ),
);
 
//conection:
$link = mysqli_connect("localhost","root","","angel_academy") or die("Error " . mysqli_error($link));
 
//consultation:
 
$query = "SELECT DISTINCT ".$table[$column]['db']." FROM table ORDER BY ".$table[$column]['db']." ASC" or die("Error in the consult.." . mysqli_error($link));
 
//execute the query.
 
$result = $link->query($query);
 
//display information:
 
$rows = array();
$rIdx = 0;
 
while($row = mysqli_fetch_array($result)) {
  $rows[$rIdx] = $row[0];
  $rIdx++;
}
 
if($rows){
  echo json_encode($rows);
}