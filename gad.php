<?php
ini_set('display_errors', 1);
        require 'vendor/autoload.php';
        include "library/includes/config.php";
         include "library/includes/initialize.php";
         $help=new classes\helpers();
	  $help->firesms('Hi gadoo', '505284060', 'gadoo');

          $query=$sql->Prepare("UPDATE tbl_assesments");