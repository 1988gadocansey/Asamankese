 <?php
 ini_set('display_errors', 0);
    require 'vendor/autoload.php';
    include "library/includes/config.php";
     include "library/includes/initialize.php";
     global $sql;
    $app=new classes\structure();
    $help=new classes\helpers();
    
    $notify=new classes\Notifications();
    $teacher=new classes\Teacher();
    if(isset($_POST[save])){
        $data="SET house=".$sql->Param('a').", master=".$sql->Param('b')."";
        $stmt=$sql->Prepare("INSERT INTO tbl_house   $data   ");
        if($sql->Execute($stmt,array($_POST['house'],$_POST['teacher'] ))){
            header("location:houses.php?success=1");
        }
        else{
            header("location:houses.php?error=1");
        }
         
        
    }
    if(isset($_GET[delete])){
       $stmt=$sql->Prepare("DELETE FROM  tbl_house  WHERE ID=".$sql->Param('a')."  ");
        if($sql->Execute($stmt,array($_GET['delete'] ))){
            header("location:houses.php?success=1");
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
                                            <h4 class="modal-title">Add House</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action="houses.php" method="POST" class="form-horizontal" role="form">
                                                 <div class="card-body card-padding">
                                                     <div class="form-group">
                                                         <label for="inputEmail3"    class="col-sm-2 control-label">Name</label>
                                                         <div class="col-sm-10">
                                                             <div class="fg-line">
                                                                 <input type="text" class="form-control input-sm" id="" name="house"placeholder="House name" required="">
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="form-group">
                                                         <label for="inputPassword3" class="col-sm-2 control-label"> House master</label>
                                                         <div class="col-sm-10">

                                                             <div class="fg-line">
                                                                 <select class='form-control' placeholder="select worker"  name='teacher' required="" placeholder="select house master"   >
                                                                     <option>select teacher</option>
                                                                     <?php 
                                                                    global $sql;

                                                                          $query2=$sql->Prepare("SELECT * FROM tbl_workers WHERE designation='Teacher'");


                                                                          $query=$sql->Execute( $query2);


                                                                       while( $row = $query->FetchRow())
                                                                         {

                                                                         ?>
                                                                         <option value="<?php echo $row['ids']; ?>"        ><?php echo $row['surname']." ,".$row['Name']; ?></option>

                                                                   <?php }?></select>
                                                             </div>
                                                         </div>
                                                     </div>
                                                                                        
                                                 </div>
                                             
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="save" class="btn btn-success">Save</button>
                                            <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                   </form>
                                    </div>
                                </div>
                            </div>
                    <div class="card">
                        
                        <div class="card-header">
                           <p>
                               View Houses (Sections) 
                            </p>
                            <div style="margin-top:-3%;float:right">
                               
                                <a data-toggle="modal" href="#modalWider"  class="btn bgm-orange waves-effect"> Create House<i class="md md-add"></i></a>
                                 <button   class="btn btn-primary waves-effect waves-button dropdown-toggle" data-toggle="dropdown">Export Data<i class="md md-save"></i> </button>
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
                         
                            <?php 

                                   $stmt =$sql->Prepare( "SELECT * FROM tbl_house $end_query ");
                                            $out=$sql->Execute($stmt);
                                            $total=$out->RecordCount();
                                            if($out->RecordCount()>0){
                             ?>
            <p style="color:green"><center> Total records = <?php echo $total; ?></center></p>
                    <div class="table-responsive">
            <table id="data-table-command" class="table table-striped table-vmiddle" >
                            <thead>
                                <tr>
                                  
                                    <th data-column-id="key" data-type="numeric" data-order="asc"  data-identifier="true">No</th>
                                    <th data-column-id="">No</th>
                                    <th data-column-id="House" data-order="asc">House</th>
                                     <th data-column-id="Total Student"  >Total Student</th>
                                      
                                    <th data-column-id="House Master"  >House Master(Mistress)</th>
                                     
                                    
                                     <th  data-column-id="link" data-formatter="link">Action</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count=0;
                                    while($rt=$out->FetchRow()){
                                                            $count++;
                                       ?>
                                      <tr>
                                    <td data-visible='false' ><?php  echo $rt[id]; ?></td>
                                    <td><?php  echo $count; ?></td>
                                    
                                    <td><?php  echo $rt[house]; ?></td>
                                    <td><?php  echo $help->getTotal_per_House($rt[id]); ?></td>
                                     
                                    <td><?php   $t_object=$teacher->geHouse_Master($rt[master]); echo $t_object->TITLE." ". $t_object->SURNAME ." ".$t_object->NAME; ?></td>
                                     
                                    
                                
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
        
         <?php  $app->getDashboardScript() ; $app->getuploadScript(); ?>
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
                    },
                     caseSensitive: false,
                          formatters: {
                                    "link": function(column, row)
                                    {
                                             var cellValue = row["key"]+"&&subject="+row["Subject"];
                                            return "<a href=\"houses.php?delete="+cellValue+"\"> <span class=\"md md-edit\"></span>   </a>";
                                    }
                                 }
					 

                });
            });
        </script>
         <?php $app->exportScript() ?>
    </body>
  
</html>