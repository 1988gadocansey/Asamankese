 <?php
 ini_set('display_errors', 1);
    require 'vendor/autoload.php';
    include "library/includes/config.php";
     include "library/includes/initialize.php";
     global $sql;
    $app=new classes\structure();
    $help=new classes\helpers();
    
    $notify=new classes\Notifications();
    if(isset($_GET[add])==1){
        $stmt=$sql->Prepare("INSERT INTO tbl_program (NAME,CODE,DEPARTMENT) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c')." )");
        if($sql->Execute($stmt,array($_POST['name'],$_POST['code'],$_POST['department']))){
            header("location:program.php?success=1");
        }
        else{
             $stmt=$sql->Prepare("UPDATE tbl_program  SET NAME=".$sql->Param('a').",CODE=".$sql->Param('b').",DEPARTMENT=".$sql->Param('c')."  ");
        if($sql->Execute($stmt,array($_POST['name'],$_POST['code'],$_POST['department']))){
            header("location:program.php?success=1");
        }
        }
        
    }
     $app->gethead();
 ?>
 <link href="vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
 <style type="text/css">
            .dropdown-basic-demo {
                display: inline-block;
                margin: 0 15px 20px 0;
            }
            
            .dropdown-basic-demo .dropdown-menu {
                display: block;
                position: relative;
                transform: scale(1);
                opacity: 1;
                filter: alpha(opacity=1);
                z-index: 0;
            }
            
            .dropdown-btn-demo .dropdown, .dropdown-btn-demo .btn-group, .btn-demo .btn {
                display: inline-block;
                margin: 0 5px 7px 0;
            }

            .modal-preview-demo .modal {
                position: relative; 
                display: block; 
                z-index: 0; 
                background: rgba(0,0,0,0.1);
            }
            
            .margin-bottom > *{
                margin-bottom: 20px;
            }
            
            .popover-demo .popover {
                position: relative;
                display: inline-block;
                opacity: 1;
                margin: 0 10px 30px;
                z-index: 0;
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
                                            <h4 class="modal-title">Add Programs</h4>
                                        </div>
                                        <div class="modal-body">
                               <form action="program.php?add=1" method="POST" class="form-horizontal" role="form">
                                                 <div class="card-body card-padding">
                                                     <div class="form-group">
                                                         <label for="inputEmail3"    class="col-sm-2 control-label">Name</label>
                                                         <div class="col-sm-10">
                                                             <div class="fg-line">
                                                                 <input type="text" class="form-control input-sm" id="" name="name"placeholder="Program Name" required="">
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="form-group">
                                                         <label for="inputPassword3" class="col-sm-2 control-label">Code</label>
                                                         <div class="col-sm-10">

                                                             <div class="fg-line">
                                                                 <input type="text" name ="code" required="" class="form-control input-sm" id=" " placeholder="Enter program code">
                                                             </div>
                                                         </div>
                                                     </div>
                                                      <div class="form-group">
                                                         <label for="inputPassword3" class="col-sm-2 control-label">Department</label>
                                                         <div class="col-sm-10">

                                                             <div class="fg-line">
                                                                 <input type="text" name ="department" required="" class="form-control input-sm" id=" " placeholder="Enter department">
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
							View , Add and Edit programs here
                            </p>
                            <div style="margin-top:-3%;float:right">
                                <button data-toggle="modal" href="#modalWider" class="btn bgm-pink waves-effect">Add Program</button>
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
                            

            <table  width="%" border="0">
                <tr>
                                
                      
                
                <td width="20%">
                 <select class='form-control'  name='department' id='status' onChange="document.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?department='+escape(this.value);"   style="margin-left:205%;Width:60%">
                 <option value=''>Filter by department</option>
                  	  <option value='all'>All</option>
                      <?php 
                global $sql;
 
                      $query2=$sql->Prepare("SELECT DISTINCT DEPARTMENT FROM tbl_program");


                      $query=$sql->Execute( $query2);
                     
                   
                   while( $row = $query->FetchRow())
                     {
                       
                     ?>
                     <option value="<?php echo $row['CODE']; ?>"        ><?php echo $row['NAME']; ?></option>

               <?php }?>
                        </select>
      
            </td>
            
            
        <td>&nbsp;</td>
         <td width=" ">

                       <!-- <select class='form-control'  name='combination' id='status' style="margin-left:-50%;Width:105%" onchange="document.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?combination='+escape(this.value);">
                            <option value=''>Filter by Course comb</option>
                  	  <option value='all'>All</option>
                      <?php 
                global $sql;
 
                      $query2=$sql->Prepare("SELECT * FROM tbl_combination");


                      $query=$sql->Execute( $query2);
                     
                   
                   while( $row = $query->FetchRow())
                     {
                       
                     ?>
                     <option value="<?php echo $row['name']; ?>"        ><?php echo $row['name']; ?></option>

               <?php }?>
                        </select>

                    </td>
                    <td>&nbsp;</td>
               <td width="10%">
             
             
                     <select  class='form-control' style="margin-left:-14%;Width:97%" name='program'  onchange="document.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?program='+escape(this.value);">
                                             
                         <option value=''>Select program</option>
                         <option value='all'>All</option>

                         <?php 
                global $sql;
 
                      $query2=$sql->Prepare("SELECT * FROM tbl_program");


                      $query=$sql->Execute( $query2);
                     
                   
                   while( $row = $query->FetchRow())
                     {
                       
                     ?>
                     <option value="<?php echo $row['CODE']; ?>"        ><?php echo $row['NAME']; ?></option>

               <?php }?>
                        </select>

             
        </td>
        <td width=" ">

                        <select class='form-control'  name='year'  style="margin-left:-10%;Width:87%" onchange="document.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?year='+escape(this.value);" >
                            <option value=''>Filter by graduating year</option>
                  	  <option value='all'>All</option>
                      <?php 
                global $sql;
 
                      $query2=$sql->Prepare("SELECT DISTINCT YEAR_GROUP FROM tbl_student");


                      $query=$sql->Execute( $query2);
                     
                   
                   while( $row = $query->FetchRow())
                     {
                       
                     ?>
                     <option value="<?php echo $row['YEAR_GROUP']; ?>"        ><?php echo $row['YEAR_GROUP']; ?></option>

               <?php }?>
                        </select>

                    </td> -->
         
    </tr>  
</table>
 
 
<p>&nbsp;</p>
            </div><!--end .row -->
             <?php 
             if(isset($_GET['department'])){
               $dept=$_GET['department'];
              
                 
              if(!empty($dept)){
                    echo $end_query="WHERE  DEPARTMENT= '$dept'    ";
                }
                 
                 
                else{
                    
                      
                    $end_query="";
                }
                 
                  
               
        }
                                           $stmt =$sql->Prepare( "SELECT * FROM tbl_program $end_query ");
                                                    $out=$sql->Execute($stmt);
                                                    $total=$out->RecordCount();
                                                    if($out->RecordCount()>0){
             ?>
            <p style="color:green"><center>Filter by (<?php echo $end_query;?>) Total records = <?php echo $total; ?></center></p>
                    <div class="table-responsive">
            <table id="data-table-selection" class="table table-striped table-vmiddle" >
                            <thead>
                                <tr>
                                    <th data-column-id="kk" data-type="numeric"  data-identifier="true">No</th>
                                     
                                    <th data-column-id="CODE" data-order="asc">CODE</th>
                                     <th data-column-id="NAME"  >NAME</th>
                                      
                                    <th data-column-id="DEPARTMENT"  >DEPARTMENT</th>
                                     
                                    <th data-column-id="ACTION" style="text-align: center"> ACTIONS</th>
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
                                    
                                    <td><?php  echo $rt[CODE]; ?></td>
                                    <td><?php  echo $rt[NAME]; ?></td>
                                     
                                    <td><?php  echo $rt[DEPARTMENT]; ?></td>
                                    <td style="text-align: center"><a href="a.php"><span class="md md-delete"></span></a></td>
                                     
                                
                                
                                     </tr>
                                    <?php } ?>
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
        
         
        <?php $app->getDashboardScript() ; $app->getuploadScript(); ?>
        
  <script src="vendors/bootgrid/jquery.bootgrid.min.js"></script>
       
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
                    formatters: {
                        "commands": function(column, row) {
                            return "<button title='delete program' type=\"button\" class=\"btn btn-icon command-edit\" data-row-id=\"" + row.id + "\"><span class=\"md md-delete\"></span></button> " ;
                               
                        }
                    }
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
                            return "<button title='delete program' type=\"button\" class=\"btn btn-icon command-delete\" data-row-id=\"" + row.id + "\"><span class=\"md md-delete\"></span></button> " ;
                               
                        }
                    }
                });
            });
        </script>
         
        <!-- Following is only for demo purpose to trigger colored modals. You may ignore this when you implement -->
        <script type="text/javascript">
            $(document).ready(function(){
                $('body').on('click', '#btn-color-targets > .btn', function(){
                    var color = $(this).data('target-color');
                    $('#modalColor').attr('data-modal-color', color);
                });
            });
        </script>
        <?php $app->exportScript() ?>
    </body>
  
</html>