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
	 if(isset($_GET[sub])){
		 
	 	echo $_POST[id];
               
           
     
	 }
 ?>
 <link href="vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
 </script>
  <style>
      #data-table-command  tr:hover{
        
        background-color: #FFFCBE;
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
							Report Card printing
                            </p>
                          
                        </div>
                        <div align="center">
                            <h4>Print single student here</h4>
                            <hr>
                            <form action="report_card.php" method="POST">
                            <table align="center">
                                <tr>
                                    
                                    <td style=" ">
                                        <select style="margin-left: 34px"   required=""  data-placeholder="search student by typing his indexno"  name="student" >
                                                         <option value=''>search student by typing his indexno</option>
                                                           
                                                                <?php 
                                                          global $sql;
                                                            
                                                                $query2=$sql->Prepare("SELECT * FROM tbl_student ");


                                                                $query=$sql->Execute( $query2);


                                                             while( $row = $query->FetchRow())
                                                               {

                                                               ?>
                                                               <option value="<?php echo $row['ID']; ?>"     >     <?php echo $row['INDEXNO']." - ".$row['OTHERNAMES']; ?></option>

                             <?php }?>
                              </select>
                                    </td>
                                 
                                      <td>&nbsp;</td>
                 <td width="20%">

                     <select class='' required="" name='term'  style="margin-left:-25%;  " >
                             <option value=''>Filter by term</option>
                            <option value='all'>All</option>
                  	        <option value='1'>1</option>
                      		<option value='2'>2</option>
                            <option value='3'>3</option>
                
                        </select>

         </td>
         <td>&nbsp;</td>
          <td width="30%">

              <select class='' required="" name='year'    >
                             <option value=''>Filter by academic year</option>
                            <option value='all'>All</option>
                  	         <?php
							 	for($i=1990; $i<=date("Y"); $i++){
									$a=$i - 1 ."/". $i;
										echo "<option value='$a'>$a</option>";
									
									}
							 
							 
							 ?>
                
                        </select>

         </td>
                                </tr>
                                 
                                
                                    
                                 
                            </table>
                                <center><button type="submit" class="btn btn-primary btn-sm m-t-10">Print Single</button></center>
                         
                        </form>
                                    </div>
                        <p>&nbsp;</p>
                        <div align='center'>
                            <h4>Print whole class here</h4>
                            <hr>
                            <form action="bulk_report_card.php" method="POST">
                            <table align="center">
                                <tr>
                                    
                                    <td style=" ">
                                        <select style="margin-left: 34px"   required=""  name="class" >
                                                         <option value=''>search class by typing class name</option>
                                                           
                                                                <?php 
                                                          global $sql;
                                                            
                                                                $query2=$sql->Prepare("SELECT * FROM tbl_classes ");


                                                                $query=$sql->Execute( $query2);


                                                             while( $row = $query->FetchRow())
                                                               {

                                                               ?>
                                                               <option value="<?php echo $row['name']; ?>"     >     <?php echo $row['name'] ?></option>

                             <?php }?>
                              </select>
                                    </td>
                                                   <td>&nbsp;</td>
                 <td width="20%">

            <select class=''  name='term'  style="margin-left:-25%;  " >
                             <option value=''>Filter by term</option>
                            <option value='all'>All</option>
                  	        <option value='1'>1</option>
                      		<option value='2'>2</option>
                            <option value='3'>3</option>
                
                        </select>

         </td>
         <td>&nbsp;</td>
          <td width="30%">

              <select class='' required="" name='year'    >
                             <option value=''>Filter by academic year</option>
                            <option value='all'>All</option>
                  	         <?php
							 	for($i=1990; $i<=date("Y"); $i++){
									$a=$i - 1 ."/". $i;
										echo "<option value='$a'>$a</option>";
									
									}
							 
							 
							 ?>
                
                        </select>

         </td>
                                </tr>
                            </table>
                                 <center><button type="submit" name="bulk" class="btn btn-primary btn-sm m-t-10">Bulk print</button></center>
                         
                            </form>
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
                    },
                    formatters: {
                        "commands": function(column, row) {
                            return "<form action='users.php?sub' id='ww' method='post'><input type='TEXT' name='id'value='<?php  echo $_SESSION[ID]; ?>'/><select class='form-control' name='status' style='width:210%'  data-row-id=\"" + row.id + "\" onchange=\" form.submit()\">  <option value=''>Filter status</option><option value='all'>All</option><option value='1'>Enabled</option>   <option value='0'>Disabled</option></select></form> ";
                  	      
                      		
                            
                        }
                    }
                });
            });
        </script>
        <?php $app->exportScript() ?>
           <script src="vendors/bootstrap-select/bootstrap-select.min.js"></script>
        <script src="vendors/chosen/chosen.jquery.min.js"></script>

    </body>
  
</html>
