<?php

//included classes
include "Session.php";
ini_set('session.gc_maxlifetime', 1);
ini_set('session.cookie_lifetime', 0);
header('Content-Type: text/html; charset=utf-8');
mb_internal_encoding('utf-8');
ini_set('upload_max_filesize', '50M');
ini_set('post_max_size', '50M');
ini_set('max_input_time', 10000);
ini_set('max_input_vars', 10000);
 
ini_set('max_execution_time', 10000);

if ($_GET["page"] != ""): $page = $_GET["page"];
else: $page = 1;
endif;
define('RECORDS_BY_PAGE', 100);
define('CURRENT_PAGE', $page);
$GenericEasyPagination = new _classes_\GenericEasyPagination(CURRENT_PAGE, RECORDS_BY_PAGE, "eng");
function age($birthday) {
    list($day, $month, $year) = explode("/", $birthday);
 $year_diff  = date("Y") - $year;
 $month_diff = date("m") - $month;
 $day_diff   = date("d") - $day;
 if ($day_diff < 0 && $month_diff==0) $year_diff--;
 if ($day_diff < 0 && $month_diff < 0) $year_diff--;
 return $year_diff;
}
