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
                      
                    <div class="card">
                        
                        <div class="card-header">
                           <p>
			     School Fees Payments
                            </p>
                           
                        </div>
                        <div align="center" style="width:50%;margin-left: 24%">
                            <form action="">
                                <select id="unit" class="tag-select" required=""  data-placeholder="search student"  name="student" onchange="document.location.href='pay_fee_popup.php?student='+escape(this.value);">
                                                         <option value=''>select student</option>
                                                           
                                                                <?php 
                                                          global $sql;
                                                          
                                                             
                                                                $query2=$sql->Prepare("SELECT * FROM tbl_student ");


                                                                $query=$sql->Execute( $query2);


                                                             while( $row = $query->FetchRow())
                                                               {

                                                               ?>
                                                         <option style="background-image:url('studentPhotos');" value="<?php echo $row['INDEXNO'] ?>" > <?php echo $row['INDEXNO']." - ".$row['OTHERNAMES']; ?></option>

                                                         <?php }?>
                                                          </select>
                            </form>
                        </div>
             
             
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
        <script src="vendors/bootstrap-select/bootstrap-select.min.js"></script>
        <script src="vendors/chosen/chosen.jquery.min.js"></script>

        <?php $app->exportScript() ?>
             
    </body>
  
</html>
