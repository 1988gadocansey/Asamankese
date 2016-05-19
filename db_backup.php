<?php

 ini_set('display_errors', 0);
    require 'vendor/autoload.php';
    include "library/includes/config.php";
     include "library/includes/initialize.php";
      include 'DBBackup.class.php';
    $app=new classes\structure();
    $help=new classes\helpers();
    $config=new classes\School();
    $info=$config->getConfig();
    
    
    
    // handles database backup
   
$db = new DBBackup(array(
	'driver' => 'mysql',
	'host' => '127.0.0.1',
	'user' => 'root',
	'password' => '',
	'database' => 'phylio_school_management_system'
));
$backup = $db->backup();
if(!$backup['error']){
	// If there isn't errors, show the content
	// The backup will be at $var['msg']
	// You can do everything you want to. Like save in a file.
	// $fp = fopen('file.sql', 'a+');fwrite($fp, $backup['msg']);fclose($fp);
	echo nl2br($backup['msg']);
    //header("location:students.php");
} else {
	echo 'An error has ocurred.';
}