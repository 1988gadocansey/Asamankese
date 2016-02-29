<?php


namespace classes;
use classes\Core;
/**
 * Description of Menu
 *
 * @author Administrator
 */
class Menu {
     public function __construct() {
          
     }
     /**
      * This function displays the
      * menus in the system and will be used
      * for access control and permission system
      */
     public function loadMenu(){
       if($_SESSION['person'] =='staff'){
                $con=  Core::getInstance();
                $STM2 = $con->dbh->query("SELECT * FROM tbl_main_menu ORDER BY ID ASC ");
                $result = $STM2->fetchAll();
                 echo "<nav id='main_menu'><ul>";

                foreach ($result as $output)
                        {
                             extract($output);
                            $parent=$ID;
                             echo "<li class='first_level'>{$MENU}";

                                $STMT = $con->dbh->query("SELECT * FROM sub_menu WHERE parentid='$parent' ORDER BY position  ASC ");
                                $row = $STMT->fetchAll();
                                foreach ($row as $values)
                                    {
                                        extract($values);
                                        echo"
                                            <ul>

                                                <li><a href='{$link}'>{$name}</a></li>


                                            </ul>";
                                    }

                             echo"</li>";



                        }
                        echo"</ul></nav>";
       }
       //else he is a student then load student menus
       else{
         echo"  <nav id='main_menu'>
                <ul>
                    <li class='first_level'>
                        <a href='dashboard.php'>
                            <span class='icon_house_alt first_level_icon'></span>
                            <span class='menu-title'>Dashboard</span>
                        </a>
                    </li>
                    <li class='first_level'>
                        <a href='javascript:void(0)'>
                            <span class='icon_document_alt first_level_icon'></span>
                            <span class='menu-title'>Students Section</span>
                        </a>
                        <ul>
                            <li class='submenu-title'>Forms</li>
                            <li><a href='statement_result.php'>Statement of Result</a></li>
                             
                            <li><a href='course_registration.php'>Course Registration</a></li>
                             
                            
                        </ul>
                    </li>
                     
                     
                     <li class='first_level'>
                        <a href='javascript:void(0)'>
                            <span class='el-icon-user bs_ttip first_level_icon'></span>
                            <span class='menu-title'>Account</span>
                            
                        </a>
                        <ul>
                            
                           
                            <li><a href='logout.php'>Logout</a></li>
                             
                        </ul>
                    </li>
                </ul>
                 
            </nav>"
            ;
       }
     }
}

$a=new Menu();
echo $a->loadMenu();