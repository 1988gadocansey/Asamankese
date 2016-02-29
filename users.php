 <?php
         ini_set('display_errors', 0);
         require 'vendor/autoload.php';
         include "library/includes/config.php";
         include "library/includes/initialize.php";
         $help=new classes\helpers();
	 $school=new classes\School();
	 $school=$school->getAcademicYearTerm();
	 $student=new classes\Student();
      		   
        $app=new classes\structure();
        $help=new classes\helpers();
        $notify=new classes\Notifications();
         $app->gethead();
	 if(isset($_GET[add])){
		 $date=strtotime(NOW);
                 $password=md5($_POST[password]);
	 	$stmt=$sql->Prepare("INSERT INTO  tbl_auth (USER,USER_SINCE,USER_TYPE,USERNAME,PASSWORD,NET_ADD) VALUES('$_POST[user]','$date','$_POST[designation]','$_POST[username]','$password','$_POST[ip]')");
               
                if($sql->Execute($stmt)){
                    header("location:users.php?success=1");
                }
     
	 }
         if($_GET[status]){
        $_SESSION[status]=$_GET[status];
        }

        if($_GET[designation]){
        $_SESSION[designation]=$_GET[designation];
        }

         
 ?>
 <link href="vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
 <script src="js/jquery.js"></script>
 <script src="js/jquery_003.js"></script>
  <script type="text/javascript">
 function getSubject(str)
{
if (str=="")
  {
  document.getElementById("subject").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("subject").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getSubject.php?ID="+str,true);
xmlhttp.send();
}

</script>
  <style>
     .container {
    width: 1400px;
}
 </style>
  
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
                     <div class="modal fade" id="modalWider" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Create Users</h4>
                                        </div>
                                        <div class="modal-body">
                               <form action="users.php?add=1" method="POST" class="form-horizontal" role="form">
                                                 <div class="card-body card-padding">
                                                  <div class="form-group">
                                                         <label for="inputPassword3" class="col-sm-2 control-label">Workers</label>
                                                         <div class="col-sm-10">

                                                             <div class="fg-line">
                                                            <select class='form-control'    required="" name="user" >
                                                                     <option value=''>select worker</option>
                                                                           
                                                                          <?php 
                                                                    global $sql;
                                                     
                                                                          $query2=$sql->Prepare("SELECT * FROM tbl_workers");
                                                    
                                                    
                                                                          $query=$sql->Execute( $query2);
                                                                         
                                                                       
                                                                       while( $rt = $query->FetchRow())
                                                                         {
                                                                           
                                                                         ?>
                                                                         <option value="<?php echo $rt['ids']; ?>"        ><?php   echo $rt[title]." ". $rt[surname]." ".$rt[Name]; ?></option>
                                                    
                                                                   <?php }?>
                                                                            </select>
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="form-group">
                                                         <label for="inputEmail3"    class="col-sm-2 control-label">Username</label>
                                                         <div class="col-sm-10">
                                                             <div class="fg-line">
                                                                <input type="text" required=""name="username"  class="form-control input-sm" id="input"   >
                                                            </div>
                                                         </div>
                                                     </div>
                                                     <div class="form-group">
                                                         <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                                                         <div class="col-sm-10">

                                                              <div class="fg-line">
                                                                    <input type="password" required="" name="password"  class="form-control input-sm" id="password"   >
                                                              </div>
                                                         </div>
                                                     </div>
                                                      <div class="form-group">
                                                      <span id="spryconfirm1">
                                                         <label for="inputPassword3" class="col-sm-2 control-label">Confirm Password</label>
                                                         <div class="col-sm-10">

                                                              <div class="fg-line">
                                                                    <input type="password" required="" name=" "  class="form-control input-sm" id="confirm"   >
                                                              </div>
                                                               <span class="confirmRequiredMsg"><br />
           													Enter the same  password as above</span><span class="confirmInvalidMsg"><br />The passwords don't match.</span></span>
                                                         </div>
                                                           
                                                     </div>
                                                      <div class="form-group">
                                                         <label for="inputPassword3" class="col-sm-2 control-label">User Role</label>
                                                         <div class="col-sm-10">

                                                             <div class="fg-line">
                                                            <select class='form-control'    required="" name="designation" >
                                                                     <option value=''>select role</option>
                                                                      <option value='Teacher'>Teacher</option>
                                                                       <option value='Data Entry clerk'>Data Entry clerk</option>
                                                                        <option value='Bursar'>Bursar</option>
                                                                         <option value='Administrator'>Administrator</option>
                                                                           
                                                                        
                                                             </select>
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="form-group">
                                                         <label for="inputEmail3"    class="col-sm-2 control-label">Login IP</label>
                                                         <div class="col-sm-10">
                                                             <div class="fg-line">
                                                                <input type="text"    name="ip"  class="form-control input-mask" data-mask="000.000.000.000" placeholder="eg: 000.000.000.000"  >
                                                            </div>
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
                            </div>
                    <div class="card">
                        
                        <div class="card-header">
                           <p>
							Assign Teachers to courses here
                            </p>
                          <div style="margin-top:-3%;float:right">
                                  <button data-toggle="modal" href="#modalWider" class="btn bgm-pink waves-effect">Create new user</button>
                                 <button   class="btn btn-primary waves-effect waves-button dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                                        <ul class="dropdown-menu">
                                            
                                            <li><a href="#" onClick ="$('#data-table-command').tableExport({type:'csv',escape:'false'});"><img src='img/icons/csv.png' width="24"/> CSV</a></li>
                                            <li><a href="#" onClick ="$('#data-table-command').tableExport({type:'txt',escape:'false'});"><img src='img/icons/txt.png' width="24"/> TXT</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#" onClick ="$('#data-table-command').tableExport({type:'excel',escape:'false'});"><img src='img/icons/xls.png' width="24"/> XLS</a></li>
                                            <li><a href="#" onClick ="$('#data-table-command').tableExport({type:'doc',escape:'false'});"><img src='img/icons/word.png' width="24"/> Word</a></li>
                                            <li><a href="#" onClick ="$('#data-table-command').tableExport({type:'powerpoint',escape:'false'});"><img src='img/icons/ppt.png' width="24"/> PowerPoint</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#" onClick ="$('#data-table-command').tableExport({type:'png',escape:'false'});"><img src='img/icons/png.png' width="24"/> PNG</a></li>
                                            <li><a href="#" onClick ="$('#data-table-command').tableExport({type:'pdf',escape:'false'});"><img src='img/icons/pdf.png' width="24"/> PDF</a></li>
                                        </ul>
                            </div>
                        </div>
                        <div class="row">
                           

                <table  width=" " border="0">
                    <tr>

                         <td>&nbsp;</td>
                <td width="25%">
                 <select class='form-control'  name='year'  style="margin-left:16%; width:55% " onchange="document.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?designation='+escape(this.value);" >
                            <option value=''>Filter job type</option>
                  	  <option value='all'>All</option>
                      <?php 
                global $sql;
 
                      $query2=$sql->Prepare("SELECT DISTINCT USER_TYPE FROM tbl_auth");


                      $query=$sql->Execute( $query2);
                     
                   
                   while( $row = $query->FetchRow())
                     {
                       
                     ?>
                     <option value="<?php echo $row['USER_TYPE']; ?>"  <?php if($_SESSION[designation]==$row['USER_TYPE']){echo 'selected="selected"'; }?>       ><?php echo $row['USER_TYPE']; ?></option>

               <?php }?>
                        </select>
      
            </td>
            

                      
               <td>&nbsp;</td>
                <td width="25%">
                <select class='form-control'  name='status'  style="margin-left:16%;  " onchange="document.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?status='+escape(this.value);" >
                            <option value=''>Filter status</option>
                  	        <option <?php if($_SESSION[status]=='all'){echo 'selected="selected"'; }?>  value='all'>All</option>
                      		<option  <?php if($_SESSION[status]=='1'){echo 'selected="selected"'; }?> value='1'>Enabled</option>
                                <option  <?php if($_SESSION[status]=='0'){echo 'selected="selected"'; }?> value='0'>Disabled</option>
                           
                        </select>
      
            </td>
            
            
        <td>&nbsp;</td>
         <td width="20% ">

                       
                    </td>
                    <td>&nbsp;</td>
               <td width="20%">
             
             
                      
        </td>
        <td width="20%">

            

                    </td>
         
    </tr>  
</table>
 
 
<p>&nbsp;</p>
            </div><!--end .row -->
             
             <?php 
                    if($_SESSION[designation]=="all" or $_SESSION[designation]==""){ $type=""; }else {$type=" WHERE    USER_TYPE = '$_SESSION[designation]' "  ;}
                 if($_SESSION[status]=="all" or $_SESSION[status]==""){ $status=""; }else {$status=" AND ACTIVE = '$_SESSION[status]' "  ;}
                    
                    
                  
                  
				  $_SESSION[last_query]=  $query= $sql->Prepare( "SELECT * FROM `tbl_auth` $type $status     ");
                                                
											 	$stmt =$sql->Prepare($query);
                                                    $out=$sql->Execute($stmt);
                                                    $total=$out->RecordCount();
                                                    if($out->RecordCount()>0){
             ?>
            <p style="color:green"><center>Filter by (<?php echo $end_query;?>) Total records = <?php echo $total; ?></center></p>
                    <div class="table-responsive">
            <table id="data-table-command" class="table table-striped table-vmiddle table-hover" >
                            <thead>
                                <tr>
                                    <th data-column-id="kk" data-type="numeric">#</th>
                                    <th data-column-id="USER" data-type=" ">WORKER</th>
                                    <th data-column-id="USERNAME" data-type=" ">USERNAME</th>
                                    <th style="text-align:center" data-type="string" data-column-id="USER POSITION" style="text-align:center">USER POSITION</th>
                                    <th data-column-id="USER DESIGNATION">USER DESIGNATION</th>
                                    <th data-column-id="USER SINCE" data-order="asc" style="text-align:center">USER SINCE</th>
                                     
                                     <th data-column-id="LOGIN CONFIGURATION" data-order="asc" style="text-align:center">LOGIN (IP ADD)</th>
                                     <th data-column-id="ACCOUNT STATUS" data-order="asc" style="text-align:center">ACCOUNT STATUS</th>
                                     <th data-column-id="LAST LOGIN" data-order="asc" style="text-align:center">LAST LOGIN</th>
                                      <th data-column-id="LAST LOGIN" data-order="asc" style="text-align:center">LAST LOGOUT</th>
                                    
                                     
                                     <th data-column-id="commands" data-formatter="input" data-sortable="false"> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count=0;
                                    while($rt=$out->FetchRow()){
                                                            $count++;
                                       ?>
                                      <tr>
                                    <td><?php  echo $count; ?></td>
                                     <td><?php  $teacher=new classes\Teacher(); $teacher=$teacher->getTeacher($rt[USER]);  echo $teacher->NAME." " .$teacher->SURNAME; ?></td>
                                     <td><?php  echo $rt[USERNAME];$_SESSION[ID]=$rt[ID]; ?></td>
                                     
                                 
                                    <td><?php  $teacher=new classes\Teacher(); $teacher=$teacher->getTeacher($rt[USER]);  echo $teacher->POSITION; ?></td>
                                      <td style="text-align:center"><?php  echo $rt[USER_TYPE] ?></td>
                                    <td style="text-align:center"><?php  echo date("d/m/Y",$rt[USER_SINCE] )?></td>
                                    <td style="text-align:center"><?php  echo $rt[NET_ADD] ?></td>
                                    <td style="text-align:center"><?php    if($rt[ACTIVE]==1){echo"Enabled";}else{echo "Disabled";} ?></td>
                                    <td style="text-align:center"><?php  echo date("d/m/Y h:m:s",$rt[LAST_LOGIN]) ?></td>
                                    <td style="text-align:center"><?php  echo date("d/m/Y h:m:s",$rt[LAST_LOGOUT]) ?></td>
                                    
                                    
                                
                                
                                     </tr>
                                    <?php }  ?>
                            </tbody>
            </table></div>
                                    <?php }else{
                  echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                Oh snap! Something went wrong. No record to display! Please upload students data
                            </div>";
             }?>
                    </div>
                </div>
                </div>
                     
                    
                    
                </div>
            </section>
        </section>
        
         
        <?php  $app->getDashboardScript() ; $app->getuploadScript(); ?>
        <script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css" />	 

        <script src="vendors/bootstrap-select/bootstrap-select.min.js"></script>
        <script src="vendors/chosen/chosen.jquery.min.js"></script>
	 <script src="vendors/input-mask/input-mask.min.js"></script>
  <script src="vendors/bootgrid/jquery.bootgrid.min.js"></script>
       
        <!-- Data Table -->
         <!-- Data Table -->
        <script type="text/javascript">
            $(document).ready(function(){
                
                
                //Command Buttons
                $("#data-table-command").bootgrid({
                    css: {
                        icon: 'md icon',
                        iconColumns: 'md-view-module',
                        iconDown: 'md-expand-more',
                        iconRefresh: 'md-refresh',
                        iconUp: 'md-expand-less'
                    }
                     
                });
            });
        </script>
        <?php $app->exportScript() ?>
            <script type="text/javascript">
 var sprypassword2 = new Spry.Widget.ValidationPassword("sprypassword2", {validateOn:["blur"]});
  
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1", {validateOn:["blur"]});
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "password", {validateOn:["blur"]});
</script>
    </body>
  
</html>
