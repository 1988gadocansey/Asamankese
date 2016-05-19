 <?php
 ini_set('display_errors', 0);
    require 'vendor/autoload.php';
    include "library/includes/config.php";
     include "library/includes/initialize.php";
    $app=new classes\structure();
    $query=$sql->Prepare("SELECT * FROM tbl_config");
    $stmt=$sql->Execute($query);
    $row=$stmt->FetchNextObject();
    if(isset($_GET["go"])==1){
         
        if(count($row)==0){
       $query=$sql->Prepare("INSERT INTO tbl_config SET NAME='$_POST[name]',SCHOOL_ACCOUNTANT='$_POST[accountant]',SCHOOL_HEAD='$_POST[head]',SCHOOL_TELEPHONE='$_POST[phone]', SCHOOL_MOTTO='$_POST[motto]', SCHOOL_ADDRESS='$_POST[address]',SCHOOL_EMAIL='$_POST[email]'  ");
        if($sql->Execute($query)){
             
	
            header("location:setup.php?success=4");
        }
        }
        else{
           $query=$sql->Prepare("UPDATE tbl_config SET NAME='$_POST[name]',SCHOOL_TELEPHONE='$_POST[phone]', SCHOOL_MOTTO='$_POST[motto]', SCHOOL_ADDRESS='$_POST[address]',SCHOOL_EMAIL='$_POST[email]'  ");
        if($sql->Execute($query)){
            //$sql->Prepare("DELETE FROM tbl_menu WHERE id='80'");
            header("location:setup.php?success=4&&");
        } 
        }
        
    }
    if(isset($_GET[stage])==2){
          
        $query=$sql->Prepare("UPDATE tbl_config SET  SCHOOL_TYPE='$_POST[type]',SCHOOL_ACCOUNTANT='$_POST[accountant]',SCHOOL_HEAD='$_POST[head]', OPEN_TIME='$_POST[timeon]', CLOSE_TIME='$_POST[timeoff]'  ");
        if($sql->Execute($query)){
           $valid_exts = array('jpeg', 'jpg'); // valid extensions
            $max_size = 250000; // max file size
            $path = 'images/'; // upload directory
             
 
            if( ! empty($_FILES['file']) ) {
		// get uploaded file extension
		$ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
		// looking for format and size validity
		if (in_array($ext, $valid_exts) AND $_FILES['file']['size'] < $max_size) { 
			$path = $path ."printout".'.'.$ext;
			// move uploaded file from temp to uploads directory
			if (move_uploaded_file($_FILES['file']['tmp_name'], $path)) {
			
			 
                        
			 
                         
			}
		} else {
			echo "<script type='text/javascript'>alert('Invalid picture format (upload only jpg) or size greater than 2000kb')</script>";
		}
            }
            header("location:setup.php?success");
        }
        
    }
    $help=new classes\helpers();
    $notify=new classes\Notifications();
     $app->gethead();
 ?>
 <link href="vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
  
<body>
      
     <?php  $app->getTopRgion() ?>
        
        <section id="main">
             <?php $app->getMenu(); ?>
            
              <?php $app->getChats(); ?>
            
            
          <section id="content">
                <div class="container">
                    <div class="block-header">
                       <?php $notify->displayMessage();  ?>
                    
                         
                    </div>
               <div class="section-body">
                     <div class="card">
                        <div class="card-header">
                            <h2>School Configurations <small>Basic Information about your school</small></h2>
                        </div>
                        
                        <div class="card-body card-padding">
                            <div class="form-wizard-basic fw-container">
                                <ul class="tab-nav text-center">
                                    <li><a href="#tab1" data-toggle="tab">School Info 1</a></li>
                                    <li><a href="#tab2" data-toggle="tab">School Info 2</a></li>
                                     
                                </ul>
                                
                                <div class="tab-content">
                                    <div class="tab-pane fade" id="tab1">    
                                         <div class="card">
                         <?php
                         $query=$sql->Prepare("SELECT * FROM tbl_config");
                         $stmt=$sql->Execute($query);
                         $row=$stmt->FetchNextObject();
                         ?>
                                <form action="setup.php?go=1" method="POST" class="form-horizontal" role="form">
                                    <div class="card-body card-padding">
                                        <div class="form-group">
                                            <label for="inputEmail3"    class="col-sm-2 control-label">Name</label>
                                            <div class="col-sm-10">
                                                <div class="fg-line">
                                                    <input type="text" class="form-control input-sm" id="" name="name"placeholder="School Name" required="" value="<?php echo $row->NAME; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Address</label>
                                    <div class="col-sm-10">
                                        
                                        <div class="fg-line">
                                            <input type="text" name ="address" required="" value="<?php echo $row->SCHOOL_ADDRESS; ?>" class="form-control input-sm" id=" " placeholder="School Address">
                                        </div>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Phone</label>
                                    <div class="col-sm-10">
                                        
                                        <div class="fg-line">
                                            <input type="text" name ="phone" required="" value="<?php echo $row->SCHOOL_TELEPHONE; ?>" class="form-control input-sm" id=" " placeholder="School Telephone">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-10">
                                        
                                        <div class="fg-line">
                                            <input type="email" name ="email"  value="<?php echo $row->SCHOOL_EMAIL; ?>" class="form-control input-sm" id=" " placeholder="School Email">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">School Motto</label>
                                    <div class="col-sm-10">
                                        
                                        <div class="fg-line">
                                            <input type="text" name ="motto" required="" value="<?php echo $row->SCHOOL_MOTTO; ?>" class="form-control input-sm" id=" " placeholder="School Motto">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary btn-sm">Add</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab2">
                                        <div class="card">
                        
                         
                             
                                             <form action="setup.php?stage=2" enctype="multipart/form-data"  method="POST" class="form-horizontal" role="form">
                            <div class="card-body card-padding">
                               <!-- <div class="form-group">
                                    <label for="inputEmail3"    class="col-sm-2 control-label">School type</label>
                                    <div class="col-sm-10">
                                        <div class="fg-line">
                                            <select class='form-control'  name='type'    >
                 
                                                    <option value=''>select school type</option>

                                                <option value="1"    <?php if($row->SCHOOL_TYPE==1){echo "selected='selected'";} ?>      >Primary</option>
                                                <option value="2"    <?php if($row->SCHOOL_TYPE==2){echo "selected='selected'";}?>      >Junior High</option>
                                                <option value="3"    <?php if($row->SCHOOL_TYPE==3){echo "selected='selected'";} ?>     >Secondary</option>

                                          </select>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Upload Letterhead</label>
                                    <div class="col-sm-10">
                                        
                                        <div class="fg-line">
                                            <input type="file" name="file" required="" class="form-control input-sm" >
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Headmasters Name</label>
                                    <div class="col-sm-10">
                                        
                                        <div class="fg-line">
                                            <input type="text" name ="head" required="" value="<?php echo $row->SCHOOL_HEAD; ?>" class="form-control input-sm" id=" " placeholder="School headmaster name">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Accountant</label>
                                    <div class="col-sm-10">
                                        
                                        <div class="fg-line">
                                            <input type="text" name ="accountant" required="" value="<?php echo $row->SCHOOL_ACCOUNTANT; ?>" class="form-control input-sm" id=" " placeholder="School headmaster name">
                                        </div>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Open time</label>
                                    <div class="input-group form-group">
                                        <span class="input-group-addon"><i class="md md-access-time"></i></span>
                                            <div class="dtp-container dropdown fg-line">
                                            <input type='text' name="timeon" class="form-control time-picker" data-toggle="dropdown" placeholder="Click here..."  value="<?php echo $row->OPEN_TIME; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">End time</label>
                                    <div class="input-group form-group">
                                        <span class="input-group-addon"><i class="md md-access-time"></i></span>
                                            <div class="dtp-container dropdown fg-line">
                                            <input type='text' name="timeoff" class="form-control time-picker" data-toggle="dropdown" placeholder="Click here..." value="<?php echo $row->CLOSE_TIME; ?>">
                                        </div>
                                    </div>
                                </div>
                                 
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary btn-sm">Add</button>
                                    </div>
                                </div>
                              
                            </div>
                        </form>
                    </div>
                                    </div>
                                     
                                    <ul class="fw-footer pagination wizard">
                                        <li class="previous first"><a class="a-prevent" href="#"><i class="md md-more-horiz"></i></a></li>
                                        <li class="previous"><a class="a-prevent" href="#"><i class="md md-chevron-left"></i></a></li>
                                        <li class="next"><a class="a-prevent" href="#"><i class="md md-chevron-right"></i></a></li>
                                        <li class="next last"><a class="a-prevent" href="#"><i class="md md-more-horiz"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                   			<!-- END VALIDATION FORM WIZARD -->

                </div>
                </div>
                     
                    
                    
                </div>
            </section>
        </section>
        
         
        <?php $app->getDashboardScript() ; $app->getuploadScript(); ?>
        
  <script src="vendors/bootgrid/jquery.bootgrid.min.js"></script>
        <script src="vendors/waves/waves.min.js"></script>
        <!-- Data Table -->
         <!-- Data Table -->
        <script type="text/javascript">
            $(document).ready(function(){
                //Basic Example
                $("#data-table-basic").bootgrid({
                    css: {
                        icon: 'md icon',
                        iconColumns: 'md-view-module',
                        iconDown: 'md-expand-more',
                        iconRefresh: 'md-refresh',
                        iconUp: 'md-expand-less'
                    },
                });
                
                //Selection
                $("#data-table-selection").bootgrid({
                    css: {
                        icon: 'md icon',
                        iconColumns: 'md-view-module',
                        iconDown: 'md-expand-more',
                        iconRefresh: 'md-refresh',
                        iconUp: 'md-expand-less'
                    },
                    selection: true,
                    multiSelect: true,
                    rowSelect: true,
                    keepSelection: true
                });
                
                //Command Buttons
                $("#data-table-command").bootgrid({
                    css: {
                        icon: 'md icon',
                        iconColumns: 'md-view-module',
                        iconDown: 'md-expand-more',
                        iconRefresh: 'md-refresh',
                        iconUp: 'md-expand-less'
                    },
                    formatters: {
                        "commands": function(column, row) {
                            return "<button type=\"button\" class=\"btn btn-icon command-edit\" data-row-id=\"" + row.id + "\"><span class=\"md md-edit\"></span></button> " + 
                                "<button type=\"button\" class=\"btn btn-icon command-delete\" data-row-id=\"" + row.id + "\"><span class=\"md md-delete\"></span></button>";
                        }
                    }
                });
            });
        </script>
       <script src="vendors/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
        <script src="vendors/summernote/summernote.min.js"></script>
        <script src="vendors/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
        <script src="vendors/fileinput/fileinput.min.js"></script>
    </body>
  
</html>