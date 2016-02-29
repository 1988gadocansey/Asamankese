<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Teacher
 *
 * @author Software Engineer
 */
namespace classes;
class Teacher {
    private $connect;
    public function __construct() {
        global $sql,$season;
           $this->connect=$sql;
          
        
    }
	//get teacher by class
    public function getTeacher($code){
        $query=  $this->connect->Prepare("SELECT * FROM tbl_workers WHERE designation='Teacher' AND emp_number='$code' OR ids='$code'");
        $stmt= $this->connect->Execute( $query);
       if($stmt->RecordCount() > 0){
					
				 
                                    return  $stmt->FetchNextObject();
				 
                                }
    }
    // get the class of a teacher
	public function getTeacher_Class($teacher){
        $query=  $this->connect->Prepare("SELECT * FROM tbl_courses WHERE teacherId='$teacher'");
        $stmt= $this->connect->Execute( $query);
            if($stmt->RecordCount() > 0){
                return $stmt->FetchNextObject();
                  

             }
    }
    // get user info
    public function getUser($code){
                $query=  $this->connect->Prepare("SELECT * FROM tbl_workers AS w JOIN tbl_auth AS a ON w.ids=a.USER WHERE  w.emp_number='$code'");
        $stmt= $this->connect->Execute( $query);
            if($stmt->RecordCount() > 0){
                $s=$stmt->FetchNextObject();
                return  $s->ID; 

             }
                
    }
    // get user_id from auth table
    public function getUser_id($code){
                $query=  $this->connect->Prepare("SELECT * FROM tbl_workers AS w JOIN tbl_auth AS a ON w.ids=a.USER WHERE  w.ids='$code'");
        $stmt= $this->connect->Execute( $query);
            if($stmt->RecordCount() > 0){
                $s=$stmt->FetchNextObject();
                return  $s->USER_ID; 

             }
                
    }
    
    // get user info from auth table
    public function getUsers_auth($user){
        $query=  $this->connect->Prepare("SELECT * FROM tbl_auth WHERE ID='$user'");
        $stmt= $this->connect->Execute( $query);
            if($stmt->RecordCount() > 0){
                return $stmt->FetchNextObject();
                  

             }
    }
    // get teacher by house master
   public function geHouse_Master($teacher){
        $query=  $this->connect->Prepare("SELECT Name,surname,title FROM tbl_workers WHERE ids='$teacher'");
        $stmt= $this->connect->Execute( $query);
            if($stmt->RecordCount() > 0){
                return $stmt->FetchNextObject();
                  

             }
             else{
                 echo "Not avaliable";
             }
    }
	//get teacher by session  ID
    public function getTeacher_ID($code){
        $query=  $this->connect->Prepare("SELECT * FROM tbl_workers AS w JOIN tbl_auth AS a ON w.ids=a.USER WHERE w.designation='Teacher' AND a.ID='$code' ");
        $stmt= $this->connect->Execute( $query);
       if($stmt->RecordCount() > 0){
					
				 
                                    return  $stmt->FetchNextObject();
				 
                                }
    }
    
    
}
