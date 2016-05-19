 <?php
 ini_set('display_errors', 0);
    require 'vendor/autoload.php';
    include "library/includes/config.php";
     include "library/includes/initialize.php";
    $app=new classes\structure();
     if(isset($_GET[data])){
         $pass=md5($_POST[password]);
         $stmt=$sql->Prepare("UPDATE tbl_auth SET USERNAME='$_POST[username]',PASSWORD='$pass' WHERE ID='$_SESSION[ID]'");
         if($sql->Execute($stmt)){
             header("location:reset.php?success=1");
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
                            <h2>Reset Account  </h2>
                        </div>
                        
                        <div class="card-body card-padding">
                             <form action="reset.php?data" method="POST" class="form-horizontal" role="form">
                                                 <div class="card-body card-padding">
                                                     <div class="form-group">
                                                         <label for="inputEmail3"    class="col-sm-2 control-label">Username</label>
                                                         <div class="col-sm-10">
                                                             <div class="fg-line">
                                                                 <input type="text" class="form-control input-sm" id="" name="username"  required="" value="<?php echo $_SESSION[USERNAME] ?>">
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="form-group">
                                                         <label for="inputPassword3" class="col-sm-2 control-label">New Password</label>
                                                         <div class="col-sm-10">

                                                             <div class="fg-line">
                                                                 <input type="password" id="password" name ="password" required="" class="form-control input-sm" id=" "  >
                                                             </div>
                                                         </div>
                                                     </div>
                                                      <div class="form-group">
                                                         <label for="inputPassword3" class="col-sm-2 control-label">Confirm Password</label>
                                                         
                                                         <div class="col-sm-10">
                                                             <span id="spryconfirm1">
                                                             <div class="fg-line">
                                                                 <input type="password" name ="confirm" id="confirm" required="" class="form-control input-sm" id=" "  >
                                                             </div>
                                                             <span class="confirmRequiredMsg"><br/>
                                                Enter the same  password as above</span><span class="confirmInvalidMsg"><br />The passwords don't match.</span></span>
                                                         </div>
                                                     </div>
               
                                                      
                                                 </div>
                                             
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-link">Save changes</button>
                                            <button type="reset" class="btn btn-link" data-dismiss="modal">Close</button>
                                        </div>
                                   </form>
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
         <link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />
            <link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css" /> 
            <script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
            <script src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
           <script type="text/javascript">
           
         var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1", {validateOn:["blur"]});
         var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "password", {validateOn:["blur"]});
      </script>
         <script src="vendors/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
        
           <script src="vendors/summernote/summernote.min.js"></script>
        <script src="vendors/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
        <script src="vendors/fileinput/fileinput.min.js"></script>
    </body>
  
</html>