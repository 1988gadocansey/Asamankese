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
        $teacher_ob=new classes\Teacher();  $teacher=$teacher_ob->getTeacher_ID($_SESSION[ID]);
  //print_r($teacher);
        if($_GET[year]){
        $_SESSION[year]=$_GET[year];
        }
        if($_GET[term]){
        $_SESSION[term]=$_GET[term];
        }
         
        if($_GET['class']){
        $_SESSION["class"]=$_GET["class"];
        }
        
         
                
	  
 ?>
   
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
   <script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
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
                               Order of merits
                           </p>
                          <div style="margin-top:-3%;float:right">
                                  <?php if($_SESSION[level]=='Administrator'){ ?> 
                              
                                 <button title="Print position" onclick="javascript:printDiv('print')" class="btn bgm-orange waves-effect btn-sm"><i class="md md-print"></i>Print</button>
                                  
                              <button   class="btn btn-primary waves-effect waves-button dropdown-toggle btn-sm" data-toggle="dropdown">Export Data<i class="md md-save"></i> </button>
                                        <ul class="dropdown-menu">
                                            
                                            <li><a href="#" onClick ="$('#assesment').tableExport({type:'csv',escape:'false'});"><img src='img/icons/csv.png' width="24"/> CSV</a></li>
                                            <li><a href="#" onClick ="$('#assesment').tableExport({type:'txt',escape:'false'});"><img src='img/icons/txt.png' width="24"/> TXT</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#" onClick ="$('#assesment').tableExport({type:'excel',escape:'false'});"><img src='img/icons/xls.png' width="24"/> XLS</a></li>
                                            <li><a href="#" onClick ="$('#assesment').tableExport({type:'doc',escape:'false'});"><img src='img/icons/word.png' width="24"/> Word</a></li>
                                            <li><a href="#" onClick ="$('#assesment').tableExport({type:'powerpoint',escape:'false'});"><img src='img/icons/ppt.png' width="24"/> PowerPoint</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#" onClick ="$('#assesment').tableExport({type:'png',escape:'false'});"><img src='img/icons/png.png' width="24"/> PNG</a></li>
                                            <li><a href="#" onClick ="$('#assesment').tableExport({type:'pdf',escape:'false'});"><img src='img/icons/pdf.png' width="24"/> PDF</a></li>
                                        </ul>
                                  <?php }?>
                            </div>
                        </div>
                        <div class="row">
                           

                <table  width=" " border="0">
                    <tr>
                    <form action="" method="post">
                     
                	    <td>&nbsp;</td>
                             <td>&nbsp;</td>
                             <td>&nbsp;</td>
                                <td width="25%">
                                    <select class='form-control'     name="class"   style="margin-left:6%;Width:160px" onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?class='+escape(this.value);">
                                 <option value=''>Filter by class</option>
                                          <option value='All class'>All Classes</option>
                                      <?php 
                                global $sql;

                                      $query2=$sql->Prepare("SELECT * FROM tbl_classes");


                                      $query=$sql->Execute( $query2);


                                   while( $rtmtow = $query->FetchRow())
                                     {

                                     ?>
                                     <option value="<?php echo $rtmtow['name']; ?>"  <?php if($_SESSION['class']==$rtmtow['name']){echo 'selected="selected"'; }?>      ><?php echo $rtmtow['name']; ?></option>

                               <?php }?>
                                        </select>

                            </td>
                             
				  
                      
                   <td>&nbsp;</td>
                      <td width="20%">

                        <select class='form-control'  name='term'  style="margin-left:-25%;  width:168px " onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?term='+escape(this.value);" >
                                         <option value=''>Filter by term</option>
                                        <option value='All term'>All Terms</option>
                                            <option value='1'<?php if($_SESSION[term]=='1'){echo 'selected="selected"'; }?>>1</option>
                                            <option value='2'<?php if($_SESSION[term]=='2'){echo 'selected="selected"'; }?>>2</option>
                                        <option value='3'<?php if($_SESSION[term]=='3'){echo 'selected="selected"'; }?>>3</option>

                                    </select>

                     </td>
                    <td>&nbsp;</td>
                    <td width="30%">

                                <select class='form-control'  name='year'  style="margin-left:-14%; width:168px" onchange="document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>?year='+escape(this.value);" >
                                                 <option value=''>Filter by academic year</option>
                                                <option value='All year'>All Years</option>
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

             
              
                    <div class="table-responsive" id="print">
                        <table class="table table-striped" id="assesment" >
                            <center><h4>Order of Merits of <?php echo $_SESSION['class']?></h4></center>
                            <thead>
                                <tr>
                                    
                                     <th  data-type="numeric" data-identifier="true">No</th>
                                     <th data-column-id="Student"   data-toggle="tooltip">Student</th>
                                      
                                    <th style="text-align" data-type="string" data-column-id="Total Score" style="text-align:center">Total Score</th>
                                   
                                     
                                       
                                       <th data-column-id="Position" data-order="asc" style="text-align: ">Position</th>
                                      
                                </tr>
                            </thead>
                            <tbody>
 
                                <?php 
                               $class=$_SESSION['class'];
                                                $year=$_SESSION[year];
                                               $term=$_SESSION[term];
                                                 if($year=="All year" or $year=="" ){ $year=""; }else {$year_=" and tbl_class_members.year = '$year' "  ;}
                                                if($class=="All class" or $class==""){ $class=""; }else {$class_=" and  tbl_class_members.class = '$class' "  ;}
                                              if($term=="All term" or $term==""){ $term=""; }else {$term_=" and  tbl_class_members.term = '$term' "  ;}
                                                     
                 $query=$sql->Prepare("SELECT DISTINCT  total,position,attendance,head_mast_report,surname,othernames,tbl_student.indexno as idd from tbl_class_members,tbl_student  where 1 and  tbl_class_members.student=tbl_student.indexno and tbl_student.status='In school'   $term_ $class_ $year_");		
                $query=$query." ORDER BY total desc,tbl_student.surname asc,tbl_class_members.position asc";
              //print_r($query);
                $rs = $sql->PageExecute($query,30);
                $recordsFound = $rs->_maxRecordCount;    // total record found
                                                      
                                            
                 
                 
                $count;
                       // print_r($stmt->FetchRow());
                while($rtmt = $rs->FetchRow())

                {
                    $count++;
                ?>
              <tr>
                <td ><?php echo $count ?></td>
                <td><?php echo $rtmt[surname].", ".$rtmt[othernames];?>
                     </td>
                 
              
                <td><?php echo ($rtmt[total]); ?></td>
                 <td><?php echo ($rtmt[position]); ?></td>
              
               
                
                   </tr>
              <?php 
				  
								  } ?>
            </table>
                        <center> <p>&nbsp;</p>
           
             
              
                            </tbody>
                          </table>
                         <br/>
                     <center><?php
                     
                         $GenericEasyPagination->setTotalRecords($recordsFound);
	  
                        echo $GenericEasyPagination->getNavigation();
                        echo "<br>";
                        echo $GenericEasyPagination->getCurrentPages();
                      ?></center> 
                    </div>
                               
                    </div>
                </div>
                </div>
                     
                    
                    
                </div>
            </section>
        </section>
        
         
        <?php  $app->getDashboardScript() ; $app->getuploadScript(); ?>
  
        <?php $app->exportScript() ?>
    </body>
  
</html>
