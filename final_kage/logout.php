<?php
ob_start();
     require 'vendor/autoload.php';
      include "library/includes/config.php";
     global $session,$sql;
     $auth= new classes\Login();
     $date=  strtotime(NOW);
     $stmt=$sql->Prepare("UPDATE tbl_auth SET LAST_LOGOUT='$date' WHERE ID='$_SESSION[ID]'");
     $sql->Execute($stmt);
     $auth->logout("out");
     
     