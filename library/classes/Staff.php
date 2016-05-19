<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Staff
 *
 * @author Senior Software Eng
 */
namespace classes;
class Staff {
    private $connect;
    public function __construct() {
        global $sql;
        $this->connect=$sql;
    }
    // total per gender
    public function getTotalStaff_gender($gender) {
          
       
        $STM2 = $this->connect->Prepare("SELECT COUNT(*) AS TOTAL FROM tbl_workers  WHERE sex='$gender' ");
        $row= $this->connect->Execute($STM2);
        if($row){
         $a=$row->FetchNextObject();
          return $a->TOTAL;
        }
    }
    public function getAllStaff_Statistics() {
          
       
         $males=  $this->getTotalStaff_gender("Male");
         $females=  $this->getTotalStaff_gender("Female");
         $total=$males + $females;
         $percentage_females = round( (($females/$total)*100),2 );
         $percentage_males = round( (($males/$total)*100),2 );
         echo "Males :".$percentage_males ."%  <br/> Females : ".$percentage_females."%";
    }
}
