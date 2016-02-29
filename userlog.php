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
        $teacher1=new classes\Teacher();  $teacher=$teacher1->getTeacher_ID($_SESSION[ID]);
        if($_GET[classes]){
        $_SESSION[classes]=$_GET[classes];
        }

        if($_GET[course]){
        $_SESSION[course]=$_GET[course];
        }

        if($_GET[year]){
        $_SESSION[year]=$_GET[year];
        }

        if($_GET[term]){
        $_SESSION[term]=$_GET[term];
        }

	  
 ?>
 <link href="vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
  
  <style>
     .container {
    width: 1380px;
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
                      
                    <div class="card">
                        
                        <div class="card-header">
                           <p>
				User Log details
                            </p>
                          <div style="margin-top:-3%;float:right">
 
                               <?php if($teacher->USER_TYPE=='Teacher'){ ?>  <button   class="btn btn-primary waves-effect waves-button dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button><?php }?>
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
                           

              <!--  <table  width=" " border="0">
                    <tr>
                    <form action="" method="post">
                     
                	    <td>&nbsp;</td>
                             <td>&nbsp;</td>
                             
                                <td width="25%">
                                    <select class='form-control'   id='status' name="class"   style="margin-left:6%;Width:60%" onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?classes='+escape(this.value);">
                                 <option value=''>Filter by class</option>
                                          <option value='All Classes'>All Classes</option>
                                      <?php 
                                global $sql;

                                      $query2=$sql->Prepare("SELECT * FROM tbl_classes");


                                      $query=$sql->Execute( $query2);


                                   while( $row = $query->FetchRow())
                                     {

                                     ?>
                                     <option value="<?php echo $row['name']; ?>"  <?php if($_SESSION[classes]==$row['name']){echo 'selected="selected"'; }?>      ><?php echo $row['name']; ?></option>

                               <?php }?>
                                        </select>

                            </td>
                             
				 <td width="25%">
                    <select class='form-control'  name='subject'  style="margin-left:2%; width:55% " onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?course='+escape(this.value);" >
                      <option value=''>Filter subject</option>
                              <option value='All Subjects'>All Subjects</option>
                          <?php 
                            global $sql;

                                $query2=$sql->Prepare("SELECT DISTINCT name FROM tbl_courses");


                                $query=$sql->Execute( $query2);


                             while( $row = $query->FetchRow())
                               {

                               ?>
                               <option <?php if($_SESSION[course]==$row['name']){echo 'selected="selected"'; }?> value="<?php echo $row['name']; ?>"        ><?php echo $row['name']; ?></option>

                        <?php }?>
                            </select>
      
                        </td>
                      
                    <td>&nbsp;</td>
                      <td width="20%">

                        <select class='form-control'  name='term'  style="margin-left:-25%;  width:58% " onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?term='+escape(this.value);" >
                                         <option value=''>Filter by term</option>
                                        <option value='All Terms'>All Terms</option>
                                            <option value='1'<?php if($_SESSION[term]=='1'){echo 'selected="selected"'; }?>>1</option>
                                            <option value='2'<?php if($_SESSION[term]=='2'){echo 'selected="selected"'; }?>>2</option>
                                        <option value='3'<?php if($_SESSION[term]=='3'){echo 'selected="selected"'; }?>>3</option>

                                    </select>

                     </td>
                    <td>&nbsp;</td>
                    <td width="30%">

                        <select class='form-control'  name='year'  style="margin-left:-14%; width:68% " onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?year='+escape(this.value);" >
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
        
                    <td>

                       <!-- <div class="form-action ">
                                <button type="submit" name="submit" class="btn ink-reaction btn-raised btn-primary">Search</button>

                        </div> 
                    </td>
        
                    </tr>  
                </form>
                </table> -->
 
 
                <p>&nbsp;</p>
                            </div><!--end .row -->

             <?php 
               
                   
                $query= $sql->Prepare( "SELECT * FROM tbl_system_log ORDER BY INPUTEDDATE DESC");
                                                
                $stmt =$sql->Prepare($query);
                $out=$sql->Execute($stmt);
                $total=$out->RecordCount();
                if($out->RecordCount()>0){
             ?>
              
                    <div class="table-responsive">
                        <table id="data-table-command" class="table table-bordered table-vmiddle table-hover"  >
                            <thead>
                                <tr>
                                    
                                     <th>NO</th>
                                     <th data-column-id="Student" data-type=" " data-toggle="tooltip">USERNAME</th>
                                     <th data-column-id="Subject" data-type=" " data-toggle="tooltip">EVENT TYPE</th>
                                    <th style="text-align:center" data-type="string" data-column-id="Class" style="">ACTIVITIES</th>
                                   
                                    <th data-column-id="Academic Year" data-order="asc" style="text-align:center">HOSTNAME</th>
                                    <th data-column-id="Term" style="text-align:center">IP ADDRESS</th>
                                     <th data-column-id="Class Score">BROWSER USED</th>
                                    <th data-column-id="Exam Score" data-order="asc" style="text-align:center">MAC ADDRESS</th>
                                     <th data-column-id="Total" data-order="asc" style="text-align:center">DATE TIME</th>
                                      
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                   $count=0;
                                    while($rtmt=$out->FetchRow()){
                                                            $count++;
                                                             						
                                       ?>
                                    <tr>
                                    
                                     <td><?php echo $count ?></td>
                                     <td style="text-align:left"><?php  $user=$teacher1->getUsers_auth($rtmt[USERNAME]);echo $user->USERNAME; ?></td>
                                    <td><?php echo $rtmt[EVENT_TYPE] ?></td>
                                    <td><?php echo $rtmt[ACTIVITIES] ?></td>
                                    <td><?php echo $rtmt[HOSTNAME] ?></td>
                                    <td><?php echo $rtmt[IP] ?></td>
                                    <td><?php echo $rtmt[BROWSER_VERSION] ?></td>
                                    <td><?php echo $rtmt[MAC_ADDRESS] ?></td>
                                    <td><?php echo date("F j, Y, g:i a",  strtotime($rtmt[INPUTEDDATE])) ?></td>
                                    </tr>
                                    <?php }?>
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
                                     var cellValue = row["Classl"]+"&&subject="+ row["Subject"];
                                    return "<a     href=\"list.php?class="+cellValue+"  \"> <span class=\"md md-edit\"></span>   </a>";
                            }
                             }
					 

                });
            });
        </script>
        <?php $app->exportScript() ?>
    </body>
  
</html>
