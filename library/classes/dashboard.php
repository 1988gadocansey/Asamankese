<?php
 
/**
 * Intereactive dashboard display
 * Charts and graphs
 *
 * @author Administrator
 */
namespace classes;
use classes\Core;
class dashboard {
    public function __construct() {
        
    }
    public function getSemYear($year,$term)
    {
                 $con=  Core::getInstance();
                    
                  $STM2 = $con->dbh->query("SELECT   *  FROM tbl_academic_constraints WHERE STATUS='1' AND YEAR='$year' AND SEMESTER='$term'");
                  $result = $STM2->fetchAll();
               foreach ($result as $output){
                   return $output;
               }
         
    }           
    public function getTotalRegistered($program,$level ){
         $a=$this->getSemYear();
        
                  $con=  Core::getInstance();
                   $row1 = array();
                  $STM2 = $con->dbh->query("select distinct stuId,program from grades WHERE year='$a[YEAR]' AND term='$a[SEMESTER]' AND level='$level' AND program='$program' ");
                  $result = $STM2->fetchAll();
                  
               foreach ($result as $output)
                {
                    $row[0] =  $output[program];
                            $row[1] =count($result);
                            array_push($row1,$row); 
                      
                 }
                  print json_encode($row1, JSON_NUMERIC_CHECK);
               
        }
}
