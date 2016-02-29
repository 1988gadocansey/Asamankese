<?php
namespace classes;
 
class Users {
    private $connect;
     public function __construct() {
         global $sql,$season;
          
         $this->connect=$sql;
     }
     // returns array of details about users
     public function  userDetails( ){
         $query = "SELECT * FROM tbl_auth  WHERE ID =".$this->connect->Param('a')." ";
			$stmt = $this->connect->Prepare($query);
			 $stmt = $this->connect->Execute($stmt,array($_SESSION["ID"]));
			  print $this->connect->ErrorMsg();
			
			if($stmt){		

				if($stmt->RecordCount() > 0){
					
				 
                                    return  $stmt->FetchNextObject();
				 
                                }
                        }
                         
     }
     
          
}
