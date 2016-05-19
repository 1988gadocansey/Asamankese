<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of structure
 *
 * @author Administrator
 */
namespace classes;
use classes\Users;
use classes\helpers;
use classes\Messages;
use classes\School;
class structure  extends skeleton{
     private $user;
     private $sql;
     
    public function __construct() {
        
         
        parent::__construct();
        global $sql,$season;
        
        $this->user=new Users();
        $this->sql=$sql;
       
    }
     
   public function gethead(){
        ?>
         <!DOCTYPE html>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
           <title><?php  $this->getHeaderTitle();?></title>
           <link rel="shortcut icon" href="assets/images/favicon.png">
        <!-- Vendor CSS -->
        <link href="vendors/fullcalendar/fullcalendar.css" rel="stylesheet">
        <link href="vendors/animate-css/animate.min.css" rel="stylesheet">
        <link href="vendors/sweet-alert/sweet-alert.min.css" rel="stylesheet">
        <link href="assets/css/select2.min.css"  rel="stylesheet" type="text/css">
        <!-- CSS -->
        <link href="css/app.min.css" rel="stylesheet">
        <link href="css/bootstrap-fileinput.css" rel="stylesheet">
         <link href="css/jquery.dataTables.min.css" rel="stylesheet">
        <style>
    .ng-valid.ng-dirty{
        border-color: green;
    }
    .ng-invalid.ng-dirty{
        border-color: red;
    }
         
.ng-touched {
    border-color: red;
}
.ng-dirty {
    border-color: pink;
}
table.dataTable th.focus,table.dataTable td.focus{outline:3px solid #337ab7;outline-offset:-1px}

</style>
<script language="javascript" type="text/javascript">
    function printDiv(divID) {
        //Get the HTML of div
        var divElements = document.getElementById(divID).innerHTML;
        //Get the HTML of whole page
        var oldPage = document.body.innerHTML;

        //Reset the page's HTML with div's HTML only
        document.body.innerHTML = 
          "<html><head><title></title></head><body>" + 
          divElements + "</body>";

        //Print Page
        window.print();

        //Restore orignal HTML
        document.body.innerHTML = oldPage;


    }
</script>
    </head>


        <?php
   }
   
   public function getTopRgion(){
       $config=new School();
       $help=new helpers();
         $message=new Messages();
         
         $total=count($notify);
         
        $stmt= $this->user->userDetails();
         $a=$stmt->USERNAME;
         $userpic=$stmt->ID;
         $type=$stmt->USER_TYPE;
       ?>
    <header id="header">
            <ul class="header-inner">
                <li id="menu-trigger" data-trigger="#sidebar">
                    <div class="line-wrap">
                        <div class="line top"></div>
                        <div class="line center"></div>
                        <div class="line bottom"></div>
                    </div>
                </li>
            
                <li class="logo hidden-xs">
                    <a href="dashboard.php"><?php   $row=$config->getConfig(); echo $row->NAME. " &nbsp |&nbsp  " ;echo "<i><small>".$row->SCHOOL_MOTTO."</small></i>"; ?>  </a>
                </li>
                
                <li class="pull-right">
                <ul class="top-menu">
                    <li id="toggle-width">
                        <div class="toggle-switch">
                            <input id="tw-switch"  type="checkbox" hidden="hidden">
                            <label for="tw-switch"   class="ts-helper"></label>
                        </div>
                    </li>
                    <li id="toggle-width">
                        <div class="toggle-switch">
                             
                            <a href="logout.php" onclick="return confirm('Are you sure you want to exit?')"> <i  style="font-size: 28px;
    vertical-align: middle;
    color: white;margin-top: -6px;" class="md-settings-power"></i></a>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="tm-message" href="#"><i class="tmn-counts"><?php echo $message->getNumberOfUnreadMail(); ?></i></a>
                        <div class="dropdown-menu dropdown-menu-lg pull-right">
                            <div class="listview">
                                <div class="lv-header">
                                    Messages
                                </div>
                                <div class="lv-body c-overflow">
                                     
                                    
						 
							  <a class="lv-item" href="inbox.php?ID=<?php echo $_SESSION[ID];?>">
                                                        
                                                        <?php 
                                                        
                                                            $query = "SELECT * FROM tbl_mails WHERE USER_ID=".$this->sql->Param('a')." AND READ_='0'";
   
    
                                                            $stmt = $this->sql->Prepare($query);
                                                            $stmt =$this->sql->Execute($stmt,array($_SESSION[ID]));
                                                          // $obj = $stmt->FetchRow();
                                                           while ($item = $stmt->FetchRow()){
                                                                ?>
                                                             
                                                       <div class="media">
                                                        <div class="pull-left">
                                                            <img class="lv-img-sm" s<?php $pic= $help->pictureid($item[FROM]);   $help->picture("avatars/$pic.jpg",100)?>  src="<?php echo "avatars/$pic.jpg" ?>" alt=" User Pic here" />  
                                                        </div>
                                                        <div class="media-body">
                                                            <div class="lv-title"><?php echo   $message->getSender($item[FROM]); ?></div>
                                                            <small class="lv-small"><?php echo   $item[SUBJECT]; ?></small>
                                                            <small class="lv-small"><?php print   $item[INPUTEDDATE];  ?></small>
                                                        </div>
                                                    </div><hr>
                                                           
                                                        
                                                     <?php }?>
						</a>
					 
                                 </div>
                                <a class="lv-footer" href="inbox.php">View All</a>
                            </div>
                        </div>
                    </li>
                     
                     
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="tm-settings" href="#"></a>
                        <ul class="dropdown-menu dm-icon pull-right">
                            <li>
                                <a data-action="fullscreen" href="#"><i class="md md-fullscreen"></i> Toggle Fullscreen</a>
                            </li>
                            
                        </ul>
                    </li>
                     
                    </ul>
                </li>
            </ul>
            
             
        </header>
    <?php
   }
   
  public function getDashboardScript(){
            ?>
                 <!-- Javascript Libraries -->
        <script src="js/jquery-2.1.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
         
         
        <script src="vendors/flot/plugins/curvedLines.js"></script>
        <script src="vendors/sparklines/jquery.sparkline.min.js"></script>
        <script src="vendors/easypiechart/jquery.easypiechart.min.js"></script>
        
        <script src="vendors/fullcalendar/lib/moment.min.js"></script>
        <script src="vendors/fullcalendar/fullcalendar.min.js"></script>
       
        <script src="vendors/auto-size/jquery.autosize.min.js"></script>
        <script src="vendors/nicescroll/jquery.nicescroll.min.js"></script>
        <script src="vendors/waves/waves.min.js"></script>
        <script src="vendors/bootstrap-growl/bootstrap-growl.min.js"></script>
        <script src="vendors/sweet-alert/sweet-alert.min.js"></script>
         <script src="js/jquery.dataTables.min.js"></script>
        <!-- <script src="js/dataTables.bootstrap.min.js"></script> -->
          
        <script src="js/dataTables.keyTable.min.js"></script>
          
         <script src="js/vue.min.js"></script>
         
 <script src="js/vue-form.min.js"></script>
         <script src="js/angular/angular.min.js"></script>
         <script src="js/select2.min.js"></script>
        <script src="js/functions.js"></script>
        <script>
                 $(document).ready(function(){
                    $('select').select2({ width: "resolve" });


                  });
        </script>
        	<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
 
<script language="javascript" type="text/javascript">
    function printDiv(divID) {
        //Get the HTML of div
        var divElements = document.getElementById(divID).innerHTML;
        //Get the HTML of whole page
        var oldPage = document.body.innerHTML;

        //Reset the page's HTML with div's HTML only
        document.body.innerHTML = 
          "<html><head><title></title></head><body>" + 
          divElements + "</body>";

        //Print Page
        window.print();

        //Restore orignal HTML
        document.body.innerHTML = oldPage;


    }
</script>
         <?php          
         }
         
   
  public function getMenu(){
      $help=new helpers();
         $message=new Messages();
         
         $total=count($notify);
         
        $stmt= $this->user->userDetails();
         $a=$stmt->USERNAME;
         $userpic=$stmt->ID;
         $type=$stmt->USER_TYPE;
      ?>
        <aside id="sidebar">
                <div class="sidebar-inner">
                    <div class="si-inner">
                        <div class="profile-menu" style="">
                            <a href="#">
                                <div class="profile-pic">
                                    <img src="img/profile-pics/1.jpg" alt="">
                                </div>
                                
                                <div class="profile-info">
                                   Welcome <?php echo $a ?>
                                    
                                    <i class="md md-arrow-drop-down"></i>
                                </div>
                            </a>
                            
                            <ul class="main-menu">
                                 
                                <li>
                                    <a href="reset.php"><i class="md md-settings"></i> Settings</a>
                                </li>
                                <li>
                                    <a href="logout.php"><i class="md md-history"></i> Logout</a>
                                </li>
                            </ul>
                        </div>
                        
                        <ul class="main-menu">
                            <?php if($_SESSION['level']=="Administrator"){?>
                                <?php  include("menu.php"); } else{?>
                            <li class="active"><a href="students.php"><i class="md md-home"></i> Home</a></li>
                              <li class='sub-menu'>
                                <a href='#'><i class='md md-layers'></i>Administration Modules</a><ul>
                               
                                    
                               
                                    <li><a href='addStudent.php'>Add Student</a></li>
                                     
                               
                               
                                    <li><a href='students.php'>View Students</a></li>
                                     
                                     <li><a href='broadsheet.php'>Broadsheet</a></li>
                                    
                               
                                     
                               
                                       
                                </ul></li> 
                                
                                 <li class='sub-menu'>
                                <a href='#'><i class='md md-layers'></i>Academics Module</a><ul>
                               
                                    <li><a href='class_list.php'>Class List</a></li>
                                     
                               
                               
                                    <li><a href='print_exam_list.php'>Print Exams Attendance</a></li>
                                     <li><a href='broadsheet.php'>Broadsheet</a></li>
                                    
                               
                               
                                     <?php if($_SESSION['level']=='Head Teacher'){?>
                                    <li><a href='headMasterR.php'>HeadMaster's Remark</a></li>
                                        <?php }?>
                                    <?php if($_SESSION['level']=='Class Teacher'){?>
                                      <li><a href='classTeacherR.php'>Form masters's Remark</a></li>
                                      <?php }?>
                                      <?php if($_SESSION['level']=='House Master'){?>
                                    <li><a href='houseMastersR.php'>House Master's Remark</a></li>
                                   
                                <?php }?>
                                    <li><a href='waec_list.php'>Print WAEC List</a></li>
                                     
                               
                               
                                    <li><a href='terminal_report.php'>Print Report card</a></li>
                                     
                                
                               
                                    <li><a href='assessment.php'>Assessments</a></li>
                                     
                               
                               
                                      
                                </ul></li>
                                <li class='sub-menu'>
                                 <a href='#'><i class='md md-layers'></i>My Account</a><ul>
                               
                                    
                               
                               
                                    <li><a href='logout.php'>Logout</a></li>
                                     
                                </ul></li> 
                                
                                <?php }?>
                           
                        </ul>
                    </div>
                </div>
            </aside>
        
        <?php
  }
  public function getuploadScript(){
      ?>
         <script src="vendors/fileinput/fileinput.min.js"></script>
        <?php
  }
  public function getChats(){
      ?>
        <aside id="chat">
                <ul class="tab-nav tn-justified" role="tablist">
                    <li role="presentation" class="active"><a href="#friends" aria-controls="friends" role="tab" data-toggle="tab">Friends</a></li>
                    <li role="presentation"><a href="#online" aria-controls="online" role="tab" data-toggle="tab">Online Now</a></li>
                </ul>
            
                
                
                 
            </aside>
    <?php
  }
  public function exportScript(){
      ?>
        
          
        <script type="text/javascript" src="js/plugins/tableexport/tableExport.js"></script>
	<script type="text/javascript" src="js/plugins/tableexport/jquery.base64.js"></script>
	<script type="text/javascript" src="js/plugins/tableexport/html2canvas.js"></script>
	<script type="text/javascript" src="js/plugins/tableexport/jspdf/libs/sprintf.js"></script>
	<script type="text/javascript" src="js/plugins/tableexport/jspdf/jspdf.js"></script>
	<script type="text/javascript" src="js/plugins/tableexport/jspdf/libs/base64.js"></script>   
           <script type="text/javascript" src="js/plugins/tableexport/tableExport.js"></script>
	 
	
    
         <?php
  }
}
