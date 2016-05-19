<?php
ini_set('display_errors', 0);
    require 'vendor/autoload.php';
    include "library/includes/config.php";
     include "library/includes/initialize.php";
    $app=new classes\structure();
    $student=new classes\Student();
    $staff=new classes\Staff();
    $app->gethead();
    
     
?>
 
    <body>
        <style>
            small{
                color:white;
                    text-decoration: none;
            }
        </style>
         <?php  $app->getTopRgion() ?>
        
        <section id="main">
             <?php $app->getMenu(); ?>
            
              <?php $app->getChats(); ?>
            
            
            <section id="content">
                <div class="container">
                    <div class="block-header">
                        <h2>Dashboard</h2>
                        
                        
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h2>Smart Links <small>School Management and Administration just got easier with Phylio</small></h2>
                            
                             
                        </div>
                        
                        <div class="card-body">
                            <div class="" style="">
                                 <table border=0 style='width:100%;height:100%;'>
                                        <tr><td colspan=14 class='notice ui-corner-top' style='padding:1%;'> </td></tr>
                                        <tr> 
                                            <td> <img id='staff_image'  style="width: 46px; " src='images/sta.png' class='dash_image' /></td>  
                                            <td ><span style="margin-left:-41%">Students</span></td>

                                                <td> <img id='student_image'   src='images/backup.png' class='dash_image' /></td>
                                                <td><span style="margin-left:-22%">System Backup</span></td>

                                                <td><a href='records_fees.php'> <img id='accounts_image'   src='images/statistics.png' class='dash_image' /></a></td>
                                                <td><span style="margin-left:-41%">Statistics</span></td>

                                                <td> <img id='transcript_image'   src='images/student_transcipt.png' class='dash_image' /></td>
                                                <td><span style="margin-left:-24%">Assessments</span></td>



                                                <td> <img id='mock'  src='images/finance.png' style="width: 50px;height: 50px" class='dash_image' /></td>  
                                                


                                                <td> <img id='mock_report' style="width: 46px;height: 46px" src='images/setting_tools.png' class='dash_image' /></td>  
                                                <td><span style="margin-left:-24%">Settings</span></td>


                                         </tr>

                              </table>
                                
                            </div>
                        </div>
                    </div>
                    
                    <div class="mini-charts">
                        <div class="row">
                            <div class="col-sm-6 col-md-3">
                                <div class="mini-charts-item bgm-cyan">
                                    <div class="clearfix">
                                        <table>
                                            <tr>
                                                <td>
                                        <div class="count">
                                            <small>Total Students Population</small>
                                            <img src="images/sta.png" style="width:47%;height: 51%"/><small>Males:<?php echo $a=$student->getTotalStudent_gender("Male") ?></small>
                                        
                                        </div>
                                                </td><td>
                                                    <img src="images/use.png" style="margin-top: 20%"/><small>Females:<?php echo $b=$student->getTotalStudent_gender("Female") ?></small>
                                                </td>
                                                <td>Total = <?php echo $student->getTotalStudent_gender("Male")  + $a=$student->getTotalStudent_gender("Female")  ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-6 col-md-3">
                                <div class="mini-charts-item bgm-lightgreen">
                                    <div class="clearfix">
                                        <div class="chart stats-bar-2"></div>
                                        <div class="count">
                                            <small>Staff count</small>
                                            <small>Males=<?php   $a=$staff->getTotalStaff_gender("Male");echo $a; ?></small> 
                                         <small>Female=<?php   $b=$staff->getTotalStaff_gender("Female") ;echo $b;  ?><br/>
                                             <?php echo "Total = ". ($staff->getTotalStaff_gender("Male"))  + ($staff->getTotalStaff_gender("Female")) ?></small> 
                                         
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-6 col-md-3">
                                <div class="mini-charts-item bgm-orange">
                                    <div class="clearfix">
                                        <div class="chart stats-line"></div>
                                        <div class="count">
                                            <small>Total Students Population</small>
                                            <small><?php echo $student->getAllStudents_Statistics()?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-6 col-md-3">
                                <div class="mini-charts-item bgm-bluegray">
                                    <div class="clearfix">
                                        <div class="chart stats-line-2"></div>
                                        <div class="count">
                                            <small>Total Staff Population</small>
                                            <small><?php echo $staff->getAllStaff_Statistics()?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                     
                        </div>
                    </div>
                    
                    <div class="row" >
                        <div class="col-sm-5" style="margin-left:8%">
                            <!-- Calendar -->
                            <div id="calendar-widget"></div>
                            
                             
                        </div>
                        
                        <div class="col-sm-5">
                             <!-- Recent Posts -->
                            <div class="card">
                                <div class="card-header ch-alt m-b-20">
                                    <h2>Term Settings <small>Vacation days settings,holidays..</small></h2>
                                    <ul class="actions">
                                        <li>
                                            <a href="#">
                                                <i class="md md-cached"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="md md-file-download"></i>
                                            </a>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#" data-toggle="dropdown">
                                                <i class="md md-more-vert"></i>
                                            </a>
                                            
                                             
                                        </li>
                                    </ul>
                                    
                                    <button class="btn bgm-cyan btn-float"><i class="md md-add"></i></button>
                                </div>
                                
                                <div class="card-body">
                                    <div class="listview">
                                        <a class="lv-item" href="#">
                                            <div class="media">
                                                <div class="pull-left">
                                                    <img class="lv-img-sm" src="img/profile-pics/1.jpg" alt="">
                                                </div>
                                                <div class="media-body">
                                                    <div class="lv-title">David Belle</div>
                                                    <small class="lv-small">Vacation days settings,holidays..</small>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="lv-item" href="#">
                                            <div class="media">
                                                <div class="pull-left">
                                                    <img class="lv-img-sm" src="img/profile-pics/2.jpg" alt="">
                                                </div>
                                                <div class="media-body">
                                                    <div class="lv-title">Jonathan Morris</div>
                                                    <small class="lv-small">Nunc quis diam diamurabitur at dolor elementum, dictum turpis vel</small>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="lv-item" href="#">
                                            <div class="media">
                                                <div class="pull-left">
                                                    <img class="lv-img-sm" src="img/profile-pics/3.jpg" alt="">
                                                </div>
                                                <div class="media-body">
                                                    <div class="lv-title">Fredric Mitchell Jr.</div>
                                                    <small class="lv-small">Phasellus a ante et est ornare accumsan at vel magnauis blandit turpis at augue ultricies</small>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="lv-item" href="#">
                                            <div class="media">
                                                <div class="pull-left">
                                                    <img class="lv-img-sm" src="img/profile-pics/4.jpg" alt="">
                                                </div>
                                                <div class="media-body">
                                                    <div class="lv-title">Glenn Jecobs</div>
                                                    <small class="lv-small">Ut vitae lacus sem ellentesque maximus, nunc sit amet varius dignissim, dui est consectetur neque</small>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="lv-item" href="#">
                                            <div class="media">
                                                <div class="pull-left">
                                                    <img class="lv-img-sm" src="img/profile-pics/4.jpg" alt="">
                                                </div>
                                                <div class="media-body">
                                                    <div class="lv-title">Bill Phillips</div>
                                                    <small class="lv-small">Proin laoreet commodo eros id faucibus. Donec ligula quam, imperdiet vel ante placerat</small>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="lv-footer" href="#">Edit</a>
                                    </div>
                                </div>
                            
                            
                        </div>
                    </div>
                </div>
            </section>
        </section>
        
         <?php $app->getDashboardScript()  ?>
        
    </body>
  
</html>