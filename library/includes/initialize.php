<?php

//included classes
include "Session.php";
ini_set('session.gc_maxlifetime', 1);
ini_set('session.cookie_lifetime', 0);
header('Content-Type: text/html; charset=utf-8');
mb_internal_encoding('utf-8');
ini_set('upload_max_filesize', '10M');
ini_set('post_max_size', '10M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 300);

if ($_GET["page"] != ""): $page = $_GET["page"];
else: $page = 1;
endif;
define('RECORDS_BY_PAGE', 100);
define('CURRENT_PAGE', $page);
$GenericEasyPagination = new _classes_\GenericEasyPagination(CURRENT_PAGE, RECORDS_BY_PAGE, "eng");
function age($birthdate, $pattern = 'eu') {
    $patterns = array(
        'eu' => 'd/m/Y',
        'mysql' => 'Y-m-d',
        'us' => 'm/d/Y',
        'gh' => 'd-m-Y',
    );

    $now = new DateTime();
    $in = DateTime::createFromFormat($patterns[$pattern], $birthdate);
    $interval = $now->diff($in);
    return $interval->y;
}
