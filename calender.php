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
                 $tb=strtotime($_POST[tbegins]);
                 $te=strtotime($_POST[tends]);
		 if($te>$tb){
	 	 $query=$sql->Prepare("INSERT INTO tbl_academic_year(BEGINS,ENDS,TERM,YEAR)VALUES('$tb','$te','$_POST[term]','$_POST[year]')");
               
                 if($sql->Execute($query)){
                     header("location:calender.php?success=1");
                 }
                 }
                 else{
                 header("location:calender.php?error=1");
                 }
     
	 }
         if(isset($_GET[delete])){
             $query=$sql->Prepare("DELETE FROM tbl_academic_year WHERE ID='$_GET[delete]'");
               
                 if($sql->Execute($query)){
                     header("location:calender.php?success=1");
                 }
         }
        if($_GET[year]){
        $_SESSION[year]=$_GET[year];
        }

        if($_GET[term]){
        $_SESSION[term]=$_GET[term];
        }
 ?>
 <link href="vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
 </script>
  <style>
      #data-table-command  tr:hover{
        
        background-color: #FFFCBE;
    }
      .container {
    width: 1300px;
}
 .md {
    font-size: 17px;
    vertical-align: middle;
    color: #333;
    margin-right: 10px;
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
                                            <h4 class="modal-title">Academic Year Settings</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action="calender.php?add=1" method="POST" class="form-horizontal" role="form">
                                                 <div class="card-body card-padding">
                                                  <div class="form-group">
                                                         <label for="inputPassword3" class="col-sm-2 control-label">Select year</label>
                                                         <div class="col-sm-10">

                                                             <div class="fg-line">
                                                                 <select class='form-control'  name='year'   required=""  >
                                                                    <option value=''>Filter by academic year</option>
                                                                   
                                                                        <?php
                                                                                                       for($i=2008; $i<=date("Y"); $i++){
                                                                                                               $a=$i - 1 ."/". $i;
                                                                                                                       echo "<option value='$a'>$a</option>";

                                                                                                               }


                                                                                                ?>

                                                               </select>

                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="form-group">
                                                         <label for="inputEmail3"    class="col-sm-2 control-label">Term</label>
                                                         <div class="col-sm-10">
                                                             <div class="fg-line">
                                                                  <select class='form-control'  name='term'  style=" "   >
                                                                        <option value=''>Filter by term</option>
                                                                       <option value='all'>All</option>
                                                                           <option value='1'>1</option>
                                                                           <option value='2'>2</option>
                                                                       <option value='3'>3</option>

                                                                   </select>
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="form-group">
                                                         <label for="inputPassword3" class="col-sm-2 control-label">Terms begins</label>
                                                         <div class="col-sm-10">

                                                              <div class="fg-line">
                                                                    <input type="text" required="" name="tbegins"  class="form-control date-picker" id="password"   >
                                                              </div>
                                                         </div>
                                                     </div>
                                                      
                                                       
                                                     <div class="form-group">
                                                         <label for="inputEmail3"    class="col-sm-2 control-label">Term Ends</label>
                                                         <div class="col-sm-10">
                                                             <div class="fg-line">
                                                                 <input type="text"  required=""  name="tends"  class="form-control date-picker"    >
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
							Academic Year Settings
                            </p>
                          <div style="margin-top:-3%;float:right">
                                  <button data-toggle="modal" href="#modalWider" class="btn bgm-pink waves-effect">Add academic year</button>
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
                        <td> &nbsp;</td>
                         
                 <td width="25%">
                    <select class='form-control'  name='year'  style="margin-left: 7px;   " onchange="document.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?year='+escape(this.value);" >
                             <option value=''>Filter by academic year</option>
                            <option value='All Years'>All Years</option>
                                             <?php
                                                                            for($i=2008; $i<=date("Y"); $i++){
                                                                                    $a=$i - 1 ."/". $i;?>
                                                                                             <option <?php if($_SESSION[year]==$a){echo 'selected="selected"'; }?>value='<?php echo $a ?>'><?php echo $a ?></option>";
                                                                             
                                                                                 <?php    } ?>


                                                                     ?>
                
                        </select>
      
                 </td>
                 <td>&nbsp;</td>
                <td width="25%">
                  <select class='form-control'  name='year'  style="margin-left: 2px;    " onchange="document.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?term='+escape(this.value);" >
                              
                            <option value="All Terms">-select term--</option>
                              <option value="1" <?php if($_SESSION[term]=='1'){echo 'selected="selected"'; }?>>1st term</option>
                              <option value="2" <?php if($_SESSION[term]=='2'){echo 'selected="selected"'; }?>>2nd term</option>
                              <option value="3" <?php if($_SESSION[term]=='3'){echo 'selected="selected"'; }?>>3rd term</option>
                
                        </select>

      
                 </td>
            

                      
               <td>&nbsp;</td>
                
            
         
    </tr>  
</table>
 
 
<p>&nbsp;</p>
            </div><!--end .row -->
             
             <?php 
             $term=$_SESSION[term];$year=$_SESSION[year];
               if($term=="All Terms" or $term==""){ $term=""; }else {$term=" and  term = '$term' "  ;}
              
                if($year=="All Years" or $year==""){ $yr=""; }else {$yr=" and year = '$year' "  ;}
                
                     
				   $query= $sql->Prepare( "SELECT * FROM tbl_academic_year WHERE 1    $term $yr ");
                                                
                                 	$stmt =$sql->Prepare($query);
                                                    $out=$sql->Execute($stmt);
                                                    $total=$out->RecordCount();
                                                    if($out->RecordCount()>0){
             ?>
            <p style="color:green"><center>Filter by (<?php echo $end_query;?>) Total records = <?php echo $total; ?></center></p>
                    <div class="table-responsive">
            <table id="data-table-command" class="table table-striped table-vmiddle" >
                            <thead>
                                <tr>
                                    <th data-column-id="kk" data-type="numeric">#</th>
                                     <th data-column-id="ID" data-type="numeric">ID</th>
                                    <th data-column-id="USER" data-type=" ">TERM</th>
                                    <th data-column-id="USERNAME" data-type=" ">ACADEMIC YEAR</th>
                                            
                                     <th data-column-id="LOGIN CONFIGURATION" data-order="asc" style="text-align: ">BEGINGS</th>
                                     <th data-column-id="ACCOUNT STATUS" data-order="asc" style="text-align: ">ENDS</th>
                                     <th  data-column-id="link" data-formatter="link" colspan="2">ACTIONS</th>
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
                                    <td style="text-align:center"><?php  echo $rt[ID] ?></td>
                                    <td style="text-align:center"><?php  echo $rt[TERM] ?></td>
                                    <td style="text-align: "><?php  echo $rt[YEAR] ?></td>
                                     <td style="text-align: "><?php  echo date("l jS \of F Y",$rt[BEGINS]) ?></td>
                                    <td style="text-align: "><?php  echo date("l jS \of F Y",$rt[ENDS]) ?></td>
                                    
                                    
                                
                                
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
        
           <?php  $app->getDashboardScript(); $app->getuploadScript(); ?>
 <script src="vendors/bootgrid/jquery.bootgrid.min.js"></script>
       
        <script src="vendors/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
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
                    formatters: {
						"link": function(column, row)
						{
							 var id = row["ID"];
                                                           
							return "<a title='delete this term'     href=\"calender.php?delete="+id+"  \"> <span class=\"md md-delete\"></span>   </a>";
                                							 

                                                        
						}}
                });
            });
        </script>
        <?php $app->exportScript() ?>
             
    </body>
  
</html>
