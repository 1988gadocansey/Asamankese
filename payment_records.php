 <?php
        ini_set('display_errors', 0);
        require 'vendor/autoload.php';
        include "library/includes/config.php";
        include "library/includes/initialize.php";
        $help=new classes\helpers();
        $school=new classes\School();
        $school=$school->getAcademicYearTerm();
        $teacher=new classes\Teacher();  $teacher=$teacher->getTeacher_ID($_SESSION[ID]);
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
if(isset($_GET[sub])){
           
                   $nulifier=$_POST[edit_amount];
		   $student=$_POST[student];
                   $index=$_POST[index];
		  $fee_type=$_POST[fee_type];
		   $counter=$_POST[counter];
                  $year=$_POST[year];
                  $term=$_POST[term];
                  //$amount_pta=array();
                  //$amount_acadmic=array();
                  //$others=array();
                  for($i=0;$i<count($student);$i++){
                     echo $id_=$index[$i];
                       $nulifier_=$nulifier[$i];
                        $student_=$student[$i];
                        $fee_type_=$fee_type[$i];
                      $term_=$term[$i];
                        $year_=$year[$i];
                    if($fee_type_[$i]=='PTA'){
                        $amount_pta=$nulifier_;
                    }
                    elseif($fee_type_[$i]=='Academic'){
                        $amount_acadmic=$nulifier_;
                    }
                    else{
                        $others=$nulifier_;
                    }
                  $query=$sql->Prepare("UPDATE tbl_fee_ledger SET AMOUNT='$nulifier_',NULLIFIER='$nulifier_'   WHERE ID='$id_'  ");
                      
                     print_r(     $stmt=$sql->Prepare("UPDATE tbl_student SET ACADEMIC_OWING=ACADEMIC_OWING-'$amount_acadmic',PTA_OWING=PTA_OWING-'$amount_pta',OTHER_BILLS=OTHER_BILLS-'$others',BILLS_PAID=BILLS_PAID-'$nulifier_',BILLS_OWING=BILLS-BILLS_PAID WHERE ID='$student_'"));
                  
                      if($sql->Execute($query) && $sql->Execute($stmt)){
                          header("location:payment_records.php?success=1");
                      }
                     
                  }
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
				Fees Payment Records
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

                   
                $query="SELECT  * FROM tbl_fee_ledger  WHERE 1 AND VIEW='1' $term $inse $ins $in  ";
                                                
                    $page=new classes\OS_Pagination($query, $query) ;
                    $stmt= $page->paginate() ;
                if($stmt->RecordCount()>0){
             ?>
                            <form action="payment_records.php?sub=1" method="POST">
                    <div class="table-responsive">
                        <table id="data-table-commandW" class="table table-bordered table-vmiddle table-hover"  >
                            <thead>
                                <tr>
                                    
                                     <th  data-order="asc">No</th>
                                     <th data-column-id="Receipt" data-type=" " data-toggle="tooltip">Receipt No</th>
                                     <th data-column-id="Receipient" data-type=" " data-toggle="tooltip">Received By</th>
                                     <th data-column-id="Date" data-type=" " data-toggle="tooltip">Date</th>
                                    <th style="text-align:center" data-type="string" data-column-id="Class" style="text-align:center">Class</th>
                                   
                                    <th data-column-id="Index Number" data-order="asc" style="text-align:center">Student ID</th>
                                    <th data-column-id="Student Name" style="text-align:center">Student Name</th>
                                     <th data-column-id="Fee Type">Fee Type</th>
                                    <th data-column-id="B/F" data-order="asc" style="text-align:center">Balance B/F(GH¢)</th>
                                     <th data-column-id="Total Paid" data-order="asc" style="text-align:center">Total Paid (GH¢)</th>
                                     <th data-column-id="Balance" data-order="" style="text-align:center">Balance C/D (GH¢)</th>
                                      <th data-column-id="Student Name" style="text-align:center">Amount</th>
                                     <th data-column-id="Term">Term</th>
                                     <th data-column-id="Year">Year</th>
                                      <th data-column-id="input" data-formatter="input" style="text-align:center">Transaction Nulifier</th>
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
                                    <td><?php echo $rtmt[FEE_TYPE]; ?></td>
                                    <td><?php echo $pupil->BILLS ?></td>
                                    <td> <?php echo $pupil->BILLS_PAID; ?> </td>
                                     <td> <?php echo $pupil->BILLS_OWING; ?> </td>
                                     <td><?php echo $rtmt[AMOUNT] ?></td>
                                       <td><?php echo $rtmt[TERM] ?></td>
                                       <td><?php echo $rtmt[YEAR] ?></td>
                                       <td><input type='text' name='edit_amount[]' />
                                                                <input type='hidden' name='term[]' id='ter'value='<?php echo $rtmt["TERM"] ?>' />
                                                                <input type='hidden' name='index[]' id='ter'value='<?php echo $rtmt["ID"] ?>' />
                                                                <input type='hidden' name='year[]' id='yr'value='<?php echo $rtmt["YEAR"] ?>' />
                                                                <input type='hidden' name='fee_type[]' id='fee' value='<?php echo $rtmt["FEE_TYPE"] ?>' />
                                                                <input type='hidden' name='student[]'id='stud' value='<?php echo $rtmt["STUDENT"] ?>' />
                                				</td>
                                    </tr>
                                    <?php }?>
                            </tbody>
                          </table> 
                        <br/>
                         <center><div class="pagination"> <?php echo $page->renderFullNav() ?> </div></center>
                              <center><div style="position: fixed;  bottom: 0px;left: 43%  ">
                                <p>
                                  
                                  <label>
                                    <input  type="submit" name="submit" id="submit" class="btn btn-success" value="UPDATE RECORDS" />
                                    </label>
                                   
                                </p>
                                  </div></center>
                            </form></div>
                                    <?php }else{
                  echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                Oh snap! Something went wrong. No record to display
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
							 var student = row["Index Number"];
                                                          var fee_type = row["Fee Type"];
                                                           var year = row["Year"];
                                                            var term = row["Term"];
                                                            
							return "<input type='text' name='amount_edit[]' />"+
                                                                "<input type='hidden' name='term[]' id='ter'value='' />"+
                                                                "<input type='hidden' name='year[]' id='yr'value='' />"+
                                                                "<input type='hidden' name='fee_type' id='fee' value='' />"+
                                                                "<input type='hidden' name='student[]'id='stud' value='' />";
                                							 

                                                        
						}}
					 

                });
            });
        </script>
        <?php $app->exportScript() ?>
    </body>
  
</html>
