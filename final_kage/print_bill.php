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
		 
	 	 $class= $_POST["class"];
                 $term=$_POST[term];
                 $year=$_POST[year];
                 $url="bulk_bill.php?form=$class&term=$term&year=$year";
                 echo "<script> 
                     window.open('$url','','menubar=yes,width=800,height=600');
                    </script>";
               
           
     
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
                               Bill Card Printing
                            </p>
                          
                        </div>
                        <div>
                            <div class="row">
                                <form action="print_bill.php?sub=1" method="post" id="" class=" ">

            <table  width="%" border="0">
                <tr>
                     
        <td width="10%">
             
             
            <select class='form-control'  name='class' required="" style="margin-left:22%" >
                            <option value=''>Filter by classes</option>
                  	  <option value='all'>All</option>
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

             
         </td>
        <td>&nbsp;</td>
        <td width="20%">

            <select class='form-control'  name='term'  style="margin-left:10%;  width:58% " required="">
                                         <option value=''>Filter by term</option>
                                       
                                            <option value='1'<?php if($_SESSION[term]=='1'){echo 'selected="selected"'; }?>>1</option>
                                            <option value='2'<?php if($_SESSION[term]=='2'){echo 'selected="selected"'; }?>>2</option>
                                        <option value='3'<?php if($_SESSION[term]=='3'){echo 'selected="selected"'; }?>>3</option>

                                    </select>

                     </td>
                    <td>&nbsp;</td>
                    <td width="30%">

                        <select class='form-control'  name='year'  style="margin-left:-14%; width:68% "  required="">
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
             
            <div class="form-action ">
                    <button type="submit" class="btn ink-reaction btn-raised btn-primary">Go</button>

            </div>
        </td>
    </form>
                   
        </td>
         
         
    </tr>  
</table>
 
 
<p>&nbsp;</p>
            </div><!--end .row -->
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
