 <?php
        ini_set('display_errors', 0);
        require 'vendor/autoload.php';
        include "library/includes/config.php";
        include "library/includes/initialize.php";
        $help=new classes\helpers();
        $school=new classes\School();
        $school=$school->getAcademicYearTerm();
        	   
        $app=new classes\structure();
        $help=new classes\helpers();
        $notify=new classes\Notifications();
        $app->gethead();
        
       
        if($_GET[classes]){
        $_SESSION[classes]=$_GET[classes];
        }

        if($_GET[student]){
        $_SESSION[students]=$_GET[student];
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
    width: 1490px;
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
				Fees Ledger
                            </p>
                          <div style="margin-top:-3%;float:right">
                                 
                               <?php if($teacher->USER_TYPE=='Administrator'){ ?>  <button   class="btn btn-primary waves-effect waves-button dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button><?php }?>
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
                    <select class="tag-select"   data-placeholder="search student by typing his indexno"   style="margin-left:2%; width:39% " onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?student='+escape(this.value);" >
                      <option value=''>Filter by Students</option>
                              <option value='All Students'>All Students</option>
                          <?php 
                            global $sql;

                                $query2=$sql->Prepare("SELECT DISTINCT ID,INDEXNO,SURNAME,OTHERNAMES FROM tbl_student");


                                $query=$sql->Execute( $query2);


                             while( $row = $query->FetchRow())
                               {

                               ?>
                               <option <?php if($_SESSION[students]==$row['ID']){echo 'selected="selected"'; }?> value="<?php echo $row['ID']; ?>"        ><?php echo $row['SURNAME'].",".$row['OTHERNAMES'];  ?></option>

                        <?php }?>
                            </select>
      
                        </td>
                      
                    <td>&nbsp;</td>
                      <td width="20%">

                        <select class='form-control'  name='term'  style="margin-left:10%;  width:58% " onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?term='+escape(this.value);" >
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

                        </div> -->
                    </td>
        
                    </tr>  
                </form>
                </table>
 
 
                <p>&nbsp;</p>
                            </div><!--end .row -->

             <?php 
              
                $class=$_SESSION[classes];
                $term=$_SESSION[term];
                $student=$_SESSION[student];
                $year=$_SESSION[year];
                if($term=="All Terms" or $term==""){ $ter=""; }else {$term=" and TERM = '$term' "  ;}
                if($student=="All Students" or $student==""){ $inse=""; }else {$inse=" and STUDENT = '$student' "  ;}
                if($year=="All Years" or $year==""){ $ins=""; }else {$ins=" and YEAR = '$year' "  ;}
                if($class=="All Classes" or $class=="" ){ $in=""; }else {$in=" and CLASS = '$class' "  ;}

                   
                $query="SELECT  * FROM tbl_fee_ledger  WHERE 1 AND VIEW='1' $term $inse $ins $in GROUP BY STUDENT ";
                                                
                    $page=new classes\OS_Pagination($query, $query) ;
                    $stmt= $page->paginate() ;
                if($stmt->RecordCount()>0){
             ?>
                            <form action="payment_records.php?sub=1" method="POST">
                    <div class="table-responsive">
                        <table id="data-table-command" class="table table-bordered table-vmiddle table-hover"  >
                            <thead>
                                <tr>
                                    
                                     <th  data-order="asc">No</th>
                                     <th data-column-id="Receipt" data-type=" " data-toggle="tooltip">Receipt No</th>
                                     <th data-column-id="Receipient" data-type=" " data-toggle="tooltip">Received By</th>
                                     <th data-column-id="Date" data-type=" " data-toggle="tooltip">Date</th>
                                    <th style="text-align:center" data-type="string" data-column-id="Class" style="text-align:center">Class</th>
                                   
                                    <th data-column-id="Index Number" data-order="asc" style="text-align:center">Student ID</th>
                                    <th data-column-id="Student Name" style="text-align:center">Student Name</th>
                                     <th data-column-id="Bank Draft No">Bank Draft</th>
                                    <th data-column-id="B/F" data-order="asc" style="text-align:center">Balance B/F(GH¢)</th>
                                     <th data-column-id="Total Paid" data-order="asc" style="text-align:center">Total Paid (GH¢)</th>
                                     <th data-column-id="Balance" data-order="" style="text-align:center">Balance C/D (GH¢)</th>
                                      
                                </tr>
                            </thead>
                            <p align="center"style="color:red">Total Records - <?php echo $stmt->RecordCount() ?></p>
                            <tbody>
                                <?php
                                
                                   $count=0;
                                    while($rtmt=$stmt->FetchRow()){
                                                            $count++;
                                                            $teacher=new classes\Teacher();  $teacher2=$teacher->getTeacher_ID($rtmt[RECEIVED_BY]);
                                                            $student=new classes\Student();	
                                                            $pupil=$student->getStudent_key($rtmt[STUDENT]);
                                       ?>
                                    <tr>
                                    
                                     <td><?php echo $count ?></td>
                                     <td><?php echo $rtmt[RECEIPT] ?></td>
                                    <td style="text-align:left"><?php  echo $teacher2->SURNAME.", ". $teacher2->NAME ?></td>
                                    <td><?php echo date("d/m/Y",strtotime($rtmt[INPUTEDDATE])) ?></td>
                                    <td><?php echo $rtmt["CLASS"] ?></td>
                                    <td><?php echo $pupil->INDEXNO ?></td>
                                    <td><?php echo $pupil->SURNAME.",".$pupil->OTHERNAMES ?></td>
                                    <td><?php echo $rtmt[CHEQUE_NO] ?: "Paid by Cash"; ?></td>
                                    <td><?php $bd+=$pupil->BILLS; echo $pupil->BILLS ?></td>
                                    <td> <?php $bp+=$pupil->BILLS_PAID;echo $pupil->BILLS_PAID; ?> </td>
                                     <td> <?php $owing+=$pupil->BILLS_OWING; echo $pupil->BILLS_OWING; ?> </td>
                                     
                                    </tr>
                                    <?php }?>
                                    <tr >
                                        <td >&nbsp;</td>
                                        <td >&nbsp;</td>
                                        <td >&nbsp;</td>
                                        <td >&nbsp;</td>
                                         <td >&nbsp;</td>
                                          <td >&nbsp;</td>
                                        <td >&nbsp;</td>
                                        <td >&nbsp;</td>
                                    <td  colspan=""><div align=""><span class="style11">Total balance b/d</span> : 
                                  <?php echo number_format($bd, 2, '.', ',') ?>
                                    </div></td>
                                     
                                     
                                      

                                <td align=""><span class="style11">Total Paid</span> :
                                  <?php echo number_format($bp, 2, '.', ',') ?></td>
                               
                                <td   align=""><span class="style11">Total Owing</span> :
                                  <?php echo number_format($owing, 2, '.', ',') ?></td>
                                    </tr>
                               
                            </tbody>
                          </table> </form>
<br/>
                         <center><div class="pagination"> <?php echo $page->renderFullNav() ?> </div></center>
</div>
                                    <?php }else{
                  echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                Oh snap! Something went wrong. No record to display! Please 
                            </div>";
             }?>
                    </div>
                </div>
                </div>

                    
                    
                </div>
            </section>
        </section>
        
         
        <?php  $app->getDashboardScript() ; $app->getuploadScript(); ?>
      <script src="vendors/bootstrap-select/bootstrap-select.min.js"></script>
        <script src="vendors/chosen/chosen.jquery.min.js"></script>
       
 <script src="vendors/bootgrid/jquery.bootgrid.min2.js"></script>
       
           
       
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
						"input": function(column, row)
						{
							 var id = row["ID"];
                                                           
							return "<input type='text' name='edit[]' />";
                                							 

                                                        
						}}
					 

                });
            });
        </script>
        <?php $app->exportScript() ?>
    </body>
  
</html>
