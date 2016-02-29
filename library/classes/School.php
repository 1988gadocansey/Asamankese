<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of School
 *
 * @author Software Engineer
 */
namespace classes;
class School {
    private $connect;
    public function __construct() {
        global $sql,$season;
           $this->connect=$sql;
          
        
    }
    public function getConfig(){
        $query=  $this->connect->Prepare("SELECT * FROM tbl_config");
        $stmt= $this->connect->Execute( $query);
       if($stmt->RecordCount() > 0){
					
				 
                                    return  $stmt->FetchNextObject();
				 
                                }
    }
    public function getAcademicYearTerm(){
        $query=  $this->connect->Prepare("SELECT * FROM tbl_academic_year");
        $stmt= $this->connect->Execute( $query);
       if($stmt->RecordCount() > 0){
					
				 
                                    return  $stmt->FetchNextObject();
				 
                                }
    }
    
}
