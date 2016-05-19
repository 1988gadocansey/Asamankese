<?php
 
/**
 * Handle all info about  students
 * 18/09/2014
 * @author Gad Ocansey
 */
namespace classes;
 

class Student {
     private $connect;
    public function __construct() {
        global $sql;
        $this->connect=$sql;
    }
    /**
     * @access public
     * @param string $index number ie the secondary key
     */
     public function getStudent($ID) {
          
       
        $STM2 = $this->connect->Prepare("SELECT * FROM tpoly_students  WHERE INDEXNO='$ID' ");
        $row= $this->connect->Execute($STM2);
        if($row){
        return $row->FetchNextObject();
        }
    }
    
    /**
     * Get total type of bill paid
     * @access public
     * @param string index number
     * @param int term
     * @param string year
     */
    public function getBill_Arears($student,$term,$year,$type){
        
    }

    /**
     * @access public
     * @param string ID the first primary key of student
     */
    public function getStudent_key($key) {
          
       
        $STM2 = $this->connect->Prepare("SELECT * FROM tpoly_students  WHERE ID='$key' ");
        $row= $this->connect->Execute($STM2);
        if($row){
        return $row->FetchNextObject();
        }
    }
    
    
    
    /* get bill per class
     *  requires term and year
     */
    public function getBill_per_class($term,$year,$class) {
          
       
        $STM2 = $this->connect->Prepare("SELECT * FROM tpoly_students  WHERE INDEXNO='$ID' ");
        $row= $this->connect->Execute($STM2);
        if($row){
        return $row->FetchNextObject();
        }
    }
    public function getClass($class) {
          
       if($class!=""){
        $STM2 = $this->connect->Prepare("SELECT name FROM tbl_classes  WHERE id='$class' ");
        $row= $this->connect->Execute($STM2);
         
        $a=$row->FetchRow() ;
        return $a[name];
       }
       else{
           $STM2 = $this->connect->Prepare("SELECT id FROM tbl_classes   ");
        $row= $this->connect->Execute($STM2);
         $arr=array();
          while($a=$row->FetchRow()){
              $arr[]=$a[id];
          }
        return $arr;
       }
         
    }
    // total per gender
    public function getTotalStudent_gender($gender) {
          
       
        $STM2 = $this->connect->Prepare("SELECT COUNT(*) AS TOTAL FROM tpoly_students  WHERE GENDER='$gender' ");
        $row= $this->connect->Execute($STM2);
        if($row){
         $a=$row->FetchNextObject();
          return $a->TOTAL;
        }
    }
      
    public function getAllStudents() {
          
       
        $STM2 = $this->connect->Prepare("SELECT * FROM tpoly_students  ");
        $row= $this->connect->Execute($STM2);
        if($row){
        return $row->FetchNextObject();
        }
    }
    
    // population statistics
     public function getAllStudents_Statistics() {
          
       
         $males=  $this->getTotalStudent_gender("Male");
         $females=  $this->getTotalStudent_gender("Female");
         $total=$males + $females;
         $percentage_females = round( (($females/$total)*100),2 );
         $percentage_males = round( (($males/$total)*100),2 );
         echo "Males :".$percentage_males ."%  <br/> Females : ".$percentage_females."%";
    }
	
	// get total students in a particular class
	 public function getTotalStudent_by_Class($class,$year,$term) {
          
       
        $STM2 = $this->connect->Prepare("SELECT COUNT(*) AS TOTAL FROM tbl_class_members WHERE YEAR='$year' AND TERM='$term' AND CLASS='$class' ");
        $row= $this->connect->Execute($STM2);
        if($row){
         $a= $row->FetchNextObject();
		 return $a->TOTAL;
        }
		else{
				return 0;
			}
       }
       
       public function getTotalStudent($year,$term) {
          
       
        $STM2 = $this->connect->Prepare("SELECT COUNT(*) AS TOTAL FROM tbl_classes WHERE YEAR='$year' AND TERM='$term' ");
        $row= $this->connect->Execute($STM2);
        if($row){
         $a= $row->FetchNextObject();
		 return $a->TOTAL;
        }
		else{
				return 0;
			}
       }
       
       // get gender by class
       
       public function getTotalStudent_by_gender($input,$class) {
          
       
        $STM2 = $this->connect->Prepare("SELECT COUNT(*) AS TOTAL FROM tbl_student WHERE GENDER='$input' AND CLASS='$class' ");
        $row= $this->connect->Execute($STM2);
        if($row){
         $a= $row->FetchNextObject();
		 return $a->TOTAL;
        }
		else{
				return 0;
			}
       }
}
 $stu=new Student();
 