<?php
/**
 * Copyright (C) 2014-20115 SoftBox Ghana - Lead Engineer - Gad Ocansey
 *
 * This file is Phylio.
 *
 * Phylio is a propriatory software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Phylio  is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Halalan.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace classes;

/**
 * Description of Grades
 *
 * @author Senior Software Eng
 */
class Grades {
    private $connect;
    public function __construct() {
        global $sql;
        $this->connect=$sql;
    }
    public function __clone() {
        
    }
    public function __destruct() {
        
    }

    public function getGradeValue($grade) {
          
       
        $STM2 = $this->connect->Prepare("select grade,comment from tbl_gradedefinition where   lower <='$grade' and upper >= '$grade'   ");
        $row= $this->connect->Execute($STM2);
                if($row){
                      $output= $row->FetchNextObject();
                      return $output ;
                }
		 
       }
       
}
