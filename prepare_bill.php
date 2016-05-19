<?php
        ini_set('display_errors', 0);
        require 'vendor/autoload.php';
        include "library/includes/config.php";
        include "library/includes/initialize.php";
         
        $school=new classes\School();
        $school=$school->getAcademicYearTerm();
        $student=new classes\Student();		   
        $app=new classes\structure();
        $help=new classes\helpers();
        $notify=new classes\Notifications();
        $app->gethead();
        $teacher=new classes\Teacher();  $teacher=$teacher->getTeacher_ID($_SESSION[ID]);
        if($_GET[classes]){
        $_SESSION[classes]=$_GET[classes];
        }

        if($_GET[student_type]){
        $_SESSION[student_type]=$_GET[student_type];
        }
        if($_GET[bill_type]){
        $_SESSION[bill_type]=$_GET[bill_type];
        }

        if($_GET[year]){
        $_SESSION[year]=$_GET[year];
        }

        if($_GET[term]){
        $_SESSION[term]=$_GET[term];
        }
        if($_GET[bill_status]){
        $_SESSION[bill_status]=$_GET[bill_status];
        }
        
        // creating bills
  if(isset($_GET['sub'])){
   $type=$_POST['type']; 
   $descr=$_POST['description'];
    $bill_type=$_POST['bill_type'];
    $class=$_POST['class'];
    $gender=$_POST['gender'];
    $stud_type=$_POST['stud_type'];
    $boarding=$_POST['boarding'];
    $amount=$_POST['amount'];

    $query="insert into tbl_bill values('','$type','$descr','','$class','','$amount','','$stud_type','$gender','$bill_type','$school->TERM','$school->YEAR','',NOW())";

    $stmt=$sql->Prepare($query);  
    if($sql->Execute($stmt)){
        header("location:prepare_bill.php?success=1");
    }

  }
  /*
   * Deleting bills , if bills is pending its only deleted from the bills table
   * else it is update to 0 as pending again and the amount of the bill is 
   * subtracted from the respective students
   */
  if(isset($_GET[bill])){
      //$amount=$_GET[amount];
      
     
      if($_GET['stat']=="Pending"){
             
            print_r($query=$sql->Prepare("DELETE FROM tbl_bill WHERE id='$_GET[bill]'"));

            if($sql->Execute($query)){
                header("location:prepare_bill.php?success=1");
            }
           
      }
      elseif($_GET['stat']=="Applied "){
          // do bulk reverse /update on student table with the weight of the bills
           
              $query2=$sql->Prepare("SELECT id,sex,amount,type,form,stuType,term,year FROM tbl_bill WHERE Applied='1' AND id='$_GET[bill]'");
      $query1=$sql->Execute($query2);
      while($row=$query1->FetchRow()){
         echo $amount=$row[amount];
          $type=$row[type];
        echo  $class=$student->getClass($row[form]);
          $stutype=$row[stuType];
          $year=$row[year];
          $term=$row[term];
          $gender=$row[sex];
          if($type=='PTA'){
              $amount_pta=$amount;
          }
          elseif($type=='Academic'){
              $amount_acadmic=$amount;
          }
          else{
              $others=$amount;
          }
          $total_bill=$amount_pta+$amount_acadmic+$others;
          if($row[form]!="all"){
          
         print_r( $query=$sql->Prepare("UPDATE tbl_student SET BILLS=BILLS-'$total_bill',PTA_OWING=PTA_OWING-'$amount_pta',ACADEMIC_OWING=ACADEMIC_OWING-'$amount_acadmic',OTHER_BILLS=OTHER_BILLS-'$others' WHERE CLASS='$class' $sex $student_type"));
          
         print_r( $stmt=$sql->Prepare("UPDATE tbl_bill SET Applied='0' WHERE id='$row[id]' "));
           $a= $sql->Execute($query);
           $b=$sql->Execute($stmt);
            if($a && $b ){
                header("location:prepare_bill.php?success=1");
               }
          }
          else{
              $classes= $student->getClass();
              for($i=0;$i<count($classes);$i++){
              //$total_bill=$amount_pta+$amount_acadmic+$others;
              $sentinel=$student->getClass($classes[$i]);
                print_r( $query=$sql->Prepare("UPDATE tbl_student SET BILLS=BILLS-'$total_bill',PTA_OWING=PTA_OWING-'$amount_pta',ACADEMIC_OWING=ACADEMIC_OWING-'$amount_acadmic',OTHER_BILLS=OTHER_BILLS-'$others' WHERE CLASS='$sentinel'"));
                $a= $sql->Execute($query);
                
              }
                print_r( $stmt=$sql->Prepare("UPDATE tbl_bill SET Applied='0' WHERE id='$row[id]' "));
              
               $b=$sql->Execute($stmt);
               if($a && $b ){
                header("location:prepare_bill.php?success=1");
               }
          }
        }
      }
  }
  /*
   * Affecting the created bills to respective students
   */
   if(isset($_GET[applied])){
       
   print_r(   $query2=$sql->Prepare("SELECT id,sex,amount,type,form,stuType,term,year FROM tbl_bill WHERE Applied='0' AND id='$_GET[applied]'"));
      $query2_=$sql->Execute($query2);
      while($row=$query2_->FetchRow()){
         echo $amount=$row[amount];
          $type=$row[type];
        echo  $class=$student->getClass($row[form]);
          $stutype=$row[stuType];
          $year=$row[year];
          $term=$row[term];
          $gender=$row[sex];
          if(!empty($gender)){
              $sex="AND GENDER='$gender'";
          }
          else{
              $sex="";
          }
          if(!empty($stud_type)){
              $student_type="AND STUDENT_TYPE='$stud_type'";
          }
          else{
              $student_type="";
          }
          if($type=='PTA'){
              $amount_pta=$amount;
          }
          elseif($type=='Academic'){
              $amount_acadmic=$amount;
          }
          else{
              $others=$amount;
          }
          
          if($row[form]!="all"){
          $total_bill=$amount_pta+$amount_acadmic+$others;
         print_r( $query=$sql->Prepare("UPDATE tbl_student SET BILLS=BILLS+'$total_bill',PTA_OWING=PTA_OWING+'$amount_pta',ACADEMIC_OWING=ACADEMIC_OWING+'$amount_acadmic',OTHER_BILLS=OTHER_BILLS+'$others' WHERE CLASS='$class' $sex $student_type"));
        // print_r( $query_=$sql->Prepare("UPDATE tbl_classes SET academic_fee=academic_fee+'$amount_acadmic',pta_fees=pta_fees+'$amount_pta',others=others+'$others' WHERE name='$class' AND term='$term' AND year='$year'"));
         print_r( $stmt=$sql->Prepare("UPDATE tbl_bill SET Applied='1' WHERE id='$row[id]' "));
           $a= $sql->Execute($query);
           $b=$sql->Execute($stmt);
            if($a && $b ){
                header("location:prepare_bill.php?success=1");
               }
          }
          else{
              $classes= $student->getClass();
              for($i=0;$i<count($classes);$i++){
              $total_bill=$amount_pta+$amount_acadmic+$others;
              $sentinel=$student->getClass($classes[$i]);
                print_r( $query=$sql->Prepare("UPDATE tbl_student SET BILLS=BILLS+'$total_bill',PTA_OWING=PTA_OWING+'$amount_pta',ACADEMIC_OWING=ACADEMIC_OWING+'$amount_acadmic',OTHER_BILLS=OTHER_BILLS+'$others' WHERE CLASS='$sentinel'"));
                $a= $sql->Execute($query);
                
              }
                print_r( $stmt=$sql->Prepare("UPDATE tbl_bill SET Applied='1' WHERE id='$row[id]' "));
              
               $b=$sql->Execute($stmt);
               if($a && $b ){
                header("location:prepare_bill.php?success=1");
               }
          }
          
      }  
       
      
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
                      <div class="modal fade" id="modalWider" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Create Bill</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action="prepare_bill.php?sub=1" method="POST" class="form-horizontal" role="form">
                                                 <div class="card-body card-padding">
                                                      <div class="form-group">
                                                         <label for="inputPassword3" class="col-sm-2 control-label">Bill type</label>
                                                         <div class="col-sm-10">

                                                             <div class="fg-line">
                                                                 <select required=""class='form-control'  onClick="beginEditing(this);" onBlur="finishEditing();"    name="type"  >
                                                                     <option>-select-</option>
                                                                     <option value='Academic'>Academic</option>
                                                                     <option value="PTA">PTA</option>
                                                                     <option value="Others">Others</option> 
                                                                      </select>
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="form-group">
                                                         <label for="inputPassword3" class="col-sm-2 control-label">Student categories</label>
                                                         <div class="col-sm-10">

                                                             <div class="fg-line">
                                                                 <select required=""class='form-control'       name="bill_type"  >
                                                                     <option>-select-</option>
                                                                     <option value='Fresh Students'>Fresh Students</option>
                                                                     <option value="Continuing Students">Continuing Students</option>
                                                                      
                                                                      </select>
                                                             </div>
                                                         </div>
                                                     </div>
                               
                                                     <div class="form-group">
                                                         <label for="inputPassword3" class="col-sm-2 control-label">Description</label>
                                                         <div class="col-sm-10">

                                                             <div class="fg-line">
                                                                 <input class="form-control" name="description" required=""/>
                                                             </div>
                                                         </div>
                                                     </div>
                                                      
                                                     <div class="form-group">
                                                         <label for="inputPassword3" class="col-sm-2 control-label">Amount</label>
                                                         <div class="col-sm-10">

                                                             <div class="fg-line">
                                                                 <input class="form-control" name="amount" required=""/>
                                                             </div>
                                                         </div>
                                                     </div>
                          
                                                     <div class="form-group">
                                                         <label for="inputEmail3"    class="col-sm-2 control-label">Class</label>
                                                         <div class="col-sm-10">
                                                             <div class="fg-line">
                                                                   <select class='form-control'    required="" name="class" onChange="getSubject(this.value)">
                                                                     <option>--select class--</option>
                                                                     <option value="all">All classes</option>
                                                                     
                                                                           
                                                                          <?php 
                                                                    global $sql;
                                                     
                                                                          $query2=$sql->Prepare("SELECT * FROM tbl_classes");
                                                    
                                                    
                                                                          $query=$sql->Execute( $query2);
                                                                         
                                                                       
                                                                       while( $row = $query->FetchRow())
                                                                         {
                                                                           
                                                                         ?>
                                                                         <option value="<?php echo $row['id']; ?>"        ><?php echo $row['name']; ?></option>
                                                    
                                                                   <?php }?>
                                                                            </select>
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="form-group">
                                                         <label for="inputPassword3" class="col-sm-2 control-label">Gender</label>
                                                         <div class="col-sm-10">

                                                             <div class="fg-line">
                                                                 <select class='form-control'       name="gender"  >
                                                                     <option value=''>select gender</option>
                                                                     <option value="Males">Males</option>
                                                                     <option value="Females">Females</option>
                                                                         <!-- comes through ajax -->
                                                                      </select>
                                                             </div>
                                                         </div>
                                                     </div>
                                                      <div class="form-group">
                                                         <label for="inputPassword3" class="col-sm-2 control-label">Student Types</label>
                                                         <div class="col-sm-10">

                                                             <div class="fg-line">
                                                                 <select class='form-control'       name="studtype"  >
                                                                     <option value=''>select student types</option>
                                                                     <option value="All">All students</option>
                                                                     <option value="Boarding">Boarding</option>
                                                                     <option value="Day">Day</option>
                                                                         <!-- comes through ajax -->
                                                                      </select>
                                                             </div>
                                                         </div>
                                                     </div>
                          
                                                      
                                                 </div>
                                             
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-warning">Save changes</button>
                                            <button type="reset" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        </div>
                                   </form>
                                    </div>
                                </div>
                            </div>
               <div class="section-body">
                      
                    <div class="card">
                        
                        <div class="card-header">
                           <p>
				Students Bills Section
                            </p>
                          <div style="margin-top:-3%;float:right">
                                <?php if($teacher->USER_TYPE=='Administrator'){ ?> <button data-toggle="modal" href="#modalWider" class="btn bgm-pink waves-effect">Create new Bill</button><?php }?>
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
                    
                     
                	    <td>&nbsp;</td>
                             <td>&nbsp;</td>
                             
                                <td width="25%">
                                    <select class='form-control'   id='status' name="class"   style="margin-left:4%;Width:40%" onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?classes='+escape(this.value);">
                                  
                                          <option value='All Classes'>All Classes</option>
                                      <?php 
                                global $sql;

                                      $query2=$sql->Prepare("SELECT * FROM tbl_classes");


                                      $query=$sql->Execute( $query2);


                                   while( $row = $query->FetchRow())
                                     {

                                     ?>
                                     <option value="<?php echo $row['id']; ?>"  <?php if($_SESSION[classes]==$row['id']){echo 'selected="selected"'; }?>      ><?php echo $row['name']; ?></option>

                               <?php }?>
                                        </select>

                            </td>
                             
		<td width="25%">
                    <select class='form-control'  name='student_type'  style="margin-left:-27%; width:40% " onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?student_type='+escape(this.value);" >
                      
                                        <option value='All Students'>All Students Types</option>
                                            <option value='Boarding'<?php if($_SESSION[student_type]=='Boarding'){echo 'selected="selected"'; }?>>Boarding</option>
                                            <option value='Day'<?php if($_SESSION[student_type]=='Day'){echo 'selected="selected"'; }?>>Day</option>
                                         
                            </select>
      
                 </td>
                 <td width="25%">
                    <select class='form-control'  name='student_type'  style="margin-left:-52%; width:40% " onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?bill_status='+escape(this.value);" >
                      
                                         <option value='All Bill Status'>Bill status</option>
                                            <option value='1'<?php if($_SESSION[bill_status]=='1'){echo 'selected="selected"'; }?>>Applied Bill</option>
                                            <option value='0'<?php if($_SESSION[bill_status]=='0'){echo 'selected="selected"'; }?>>Pending Bill</option>
                                         
                     </select>
      
                 </td>
                      
                    <td>&nbsp;</td>
                    <td width="25%">
                                 <select class='form-control'   id='stssatus' name="clssass"   style="margin-left:-76%;Width:40%" onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?bill_type='+escape(this.value);">
                                  
                                          <option value='All bill types'>All bill types</option>
                                      <?php 
                                global $sql;

                                      $query2=$sql->Prepare("SELECT DISTINCT type FROM tbl_bill");


                                      $query=$sql->Execute( $query2);


                                   while( $row = $query->FetchRow())
                                     {

                                     ?>
                                     <option value="<?php echo $row['type']; ?>"  <?php if($_SESSION[bill_type]==$row['type']){echo 'selected="selected"'; }?>      ><?php echo $row['type']; ?></option>

                               <?php }?>
                                        </select>
      
                     </td>
                      <td>&nbsp;&nbsp;&nbsp</td>
                      <td width="20%">

                          <select    id='statuss'style="margin-left:-35%;" onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?term='+escape(this.value);">
                              <option value="All Terms">-select term--</option>
                              <option value="1" <?php if($_SESSION[term]=='1'){echo 'selected="selected"'; }?>>1st term</option>
                              <option value="2" <?php if($_SESSION[term]=='2'){echo 'selected="selected"'; }?>>2nd term</option>
                              <option value="3" <?php if($_SESSION[term]=='3'){echo 'selected="selected"'; }?>>3rd term</option>
                          </select>

                      </td>
                      <td>&nbsp;&nbsp;&nbsp;&nbsp</td>
                    <td width="20%" >

                           <select    name='year'  style="margin-left:-14%;  " onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?year='+escape(this.value);" >
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
        
                    </tr>  
                  
                </table>
 
 
                
                            </div><!--end .row -->

             <?php 
              
                $class=$_SESSION[classes];
                $term=$_SESSION[term];
                $bill_type=$_SESSION[bill_type];
                $bill_status=$_SESSION[bill_status];
                $student_type=$_SESSION[student_type];
                $year=$_SESSION[year];
                if($term=="All Terms" or $term==""){ $term=""; }else {$term=" and  term = '$term' "  ;}
                if($student_type=="All Students" or $student_type==""){ $inse=""; }else {$inse=" and stuType = '$student_type' "  ;}
                if($year=="All Years" or $year==""){ $yr=""; }else {$yr=" and year = '$year' "  ;}
                if($bill_type=="All bill types" or $bill_type==""){ $bill=""; }else {$bill=" and type = '$bill_type' "  ;}
                if($bill_status=="All Bill Status" or $bill_status==""){ $ins=""; }else {$ins=" and Applied = '$bill_status' "  ;}
                if($class=="All Classes" or $class=="" ){ $in=""; }else {$in=" and form = '$class' "  ;}
                $query="SELECT * FROM tbl_bill where 1 $term $inse $ins $in $bill $yr";
                   $page=new classes\OS_Pagination($query, $query) ;
                    $a= $page->paginate() ;
             // print_r(  $stmt= $sql->Prepare( "SELECT * FROM tbl_bill $term $inse $ins $in "));
                                                
                 
              //  $out=$sql->Execute($stmt);
               echo "<br/><p align='center' style='color:red;font-weight:bold'>Total Record(s) - " .$total=$a->RecordCount()."
                  <hr></hr><p>";
             ?>
              
                    <div class="table-responsive">
                        <table id="data-table-command" class="table table-bordered table-vmiddle table-hover"  >
                            <thead>
                                <tr>
                                    
                                     <th>No</th>
                                     <th data-column-id="ID" visible='false'  style='display:none' data-toggle="tooltip">ID</th>
                                     <th data-column-id="Type"   data-toggle="tooltip">Bill Type</th>
                                     <th data-column-id="Subject" data-type=" " data-toggle="tooltip">Bill Description</th>
                                    <th style="text-align:center" data-type="string" data-column-id="Class" style="text-align:center">Class</th>
                                   
                                    <th data-column-id="Gender" data-order="asc" style="text-align:center">Gender</th>
                                    <th data-column-id="Amount" data-order="asc" >Amount</th>
                                     
                                     <th data-column-id="Students" data-order="asc" style="text-align:center">Students (Exclude or only these)</th>
                                      <th data-column-id="Total Students" data-order="asc" style="text-align:center">Total Students</th>
                                      <th data-column-id="Total amount" data-order="asc" style="text-align:center">Total Accrued Amount</th>
                                     <th data-column-id="Status" data-order="asc" >Status</th>
                                      <th data-column-id="term" data-order="asc" style="text-align:center">Term</th>
                                        <th data-column-id="year" data-order="asc" style="text-align:center">Year</th>
                                        <th  data-column-id="link" data-formatter="link" colspan="2">Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                   $count=0;
                                   $pupil=0;
                                     while($rtmt=$a->FetchRow()){
                                                            $count++;
								$total+=$rtmt[amount];	
                                                                if($rtmt[Applied]==1){
                                                                    $status="<span class='color-block bgm-green'>Applied</span>";
                                                                }
                                                                else{
                                                                    $status="<span class='fc-title'>Pending</span>";
                                                                }
                                       ?>
                                    <tr>
                                    
                                     <td><?php echo $count ?></td>
                                     <td style="display:none"><?php echo $rtmt[id] ?></td>
                                    <td style="text-align:left"><?php  echo $rtmt[type]; ?></td>
                                    <td><?php echo $rtmt[descr] ?></td>
                                    <td><?php  echo $student->getClass( $rtmt[form])  ?></td>
                                    <td><?php echo $rtmt[sex] ?></td>
                                    <td><?php $amt+=$rtmt[amount];echo $rtmt[amount] ?></td>
                                    <td><?php  $stud=$student->getStudent($rtmt[stu]);echo $stud->SURNAMEs." ".$stud->OTHERNAMES; ?></td>
                                    <td><?php  if($rtmt[form]!="all"){ $class=$student->getTotalStudent_by_Class($student->getClass( $rtmt[form]), $school->YEAR,$school->TERM);echo $class;}else{$class=$student->getTotalStudent($school->YEAR, $school->TERM);echo $class;}$pupil+=$class; ?></td>
                                    
                                    
                                         <td ><?php echo $class*$rtmt[amount];$truetotal+=($class*$rtmt[amount]); ?></td>
                                          <td><?php echo $status; ?> </td>
                                     <td> <?php echo ($rtmt[term]); ?> </td>
                                     <td> <?php echo ($rtmt[year]); ?> </td>
                                      
                                    </tr> 
                           
              <?php 
				  
                  } ?>
              <tr bgcolor="#FF9800" bordercolor="#AED7FF" >
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                 <td >&nbsp;</td>
                 
                 
                <td width="130"  ><div align="center" class="style9">Total </div></td>
                <td><?php echo number_format($amt, 2, '.', ',') ?></td>
                <td>&nbsp;</td>
                 <td  ><div align="centerh"><strong><?php echo $pupil ?>&nbsp;</strong></div></td>

                
                  
                <td  ><strong><?php echo  number_format($truetotal, 2, '.', ',') ?></strong></td>
                 
              </tr>    
                                     
                                    
                            </tbody>
                          </table>
                        <br/>
                        <center><div class="pagination"> <?php echo $page->renderFullNav() ?> </div></center> 
                    </div>
                                     
                    </div>
                </div>
                </div>
                     
                    
                    
                </div>
            </section>
        </section>
        
         
        <?php  $app->getDashboardScript(); $app->getuploadScript(); ?>
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
						"link": function(column, row)
						{
							 var cellValue = row["ID"];
                                                         var id=row["ID"]+"&stat="+row["Status"]+"&type="+row["Type"]+"&amount"+row["Amount"]+"&form="+row["Class"];
							return "<a title='delete this bill'     href=\"prepare_bill.php?bill="+id+"  \"> <span class=\"md md-delete\"></span>   </a>"+
                                							  "<a title='apply this bill to students'    href=\"prepare_bill.php?applied="+cellValue+"  \"> <span class=\"md md-thumb-up\"></span>   </a>";

                                                        
						}
		}
					 

                });
            });
        </script>
        
        <?php $app->exportScript() ?>
    </body>
  
</html>
