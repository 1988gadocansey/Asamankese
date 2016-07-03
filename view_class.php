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
        
          $notify=new classes\Notifications();
           $app->gethead();
           if(isset($_POST[save])){
              $class=$_POST['class'];
              $nextclass=$_POST['next'];
              $query=$sql->Prepare("INSERT INTO tbl_classes (name,nextClass,open)VALUES('$class','$nextclass','1')");
              if($sql->Execute($query)){
                  header("location:view_class.php?success=1");
              }
              
           }
           if(isset($_GET['delete'])){
               $class = $_GET['delete'];
    // first check if there students in the class the user want to delete
                 $querys = $sql->Prepare("SELECT * FROM tbl_student WHERE CLASS='$class' AND STATUS LIKE '%In School%'");

                $rtmt = $sql->Execute($querys);
                $total = $rtmt->RecordCount();

                if ($total == 0) {
                    $queryString = $sql->Prepare("DELETE FROM tbl_classes WHERE name='$class'");
                    if ($sql->Execute($queryString)) {
                        header("location:view_class.php?success=1");
                    }
                } else {
                    header("location:view_class.php?prohibit&item=class");
                }
            }
	   if(isset($_POST[sub])){
		    
               $counter = $_POST["counter"];
                $class = $_POST["class"];
                $nextclass = $_POST["next"];
               
                for ($i = 1; $i <= $counter; $i++) {


                    $classes = $class[$i];
                     //print_r($class[$i]);
                    $nextclasses = $nextclass[$i];
                    if ($nextclass == "" && $classes = "") {

                    } else {
                        $a = $sql->Prepare("update tbl_classes set nextClass='$nextclasses'  where  name='$classes' ");
                        print_r($a);
                        if ($sql->Execute($a)) {
                            header("location:view_class.php?success=1");
                        } else {

                             header("location:view_class.php?success=1");
                        }
                    }
                }
             }
		  
 ?>
 <link href="vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
  
  
 
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
                      <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Create New Class</h4>
                                        </div>
                                        <div class="modal-body">
                                            
                                            <form action="" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
                                                 <div class="card-body card-padding">
                                                     <div class="form-group">
                                                         <label for="inputPassworsd3" class="col-sm-2 control-label">Class Name</label>
                                                         <div class="col-sm-10">

                                                             <div class="fg-line">
                                                                  
                                                                 <input type="text" name="class" class="form-control"  required=""/>                                   
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="form-group">
                                                         <label for="inputEmail3"    class="col-sm-2 control-label">Next Class</label>
                                                         <div class="col-sm-10">
                                                             <div class="fg-line">
                                                                 <select  class="form-control"  style="width:150px"   name="next" >
                                                                     <option value=''>select class</option>
                                                                           
                                                                          <?php 
                                                                    global $sql;
                                                     
                                                                          $query2=$sql->Prepare("SELECT * FROM tbl_classes");
                                                    
                                                    
                                                                          $query=$sql->Execute( $query2);
                                                                         
                                                                       
                                                                       while( $row = $query->FetchRow())
                                                                         {
                                                                           
                                                                         ?>
                                                                         <option value="<?php echo $row['name']; ?>"        ><?php echo $row['name']; ?></option>
                                                    
                                                                   <?php }?>
                                                                            </select>
                                                             </div>
                                                         </div>
                                                     </div>
                                                <div class="modal-footer">
                                                      
                                                    <button type="submit" name="save" class="btn btn-success">Save <i class="fa fa-sm"></i></button>
                                                          <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
                                                </div>
                                                  
                                                 </div>
                                             </div>  
                                            </form>
                                  </div>
                                </div>
                        </div>
                    <div class="card">
                        
                        <div class="card-header">
                           <p>
                            Update classes here
                            </p>
                           <div style="margin-top:-3%;float:right">
                                 
                                
                                 <button      class="btn bgm-lime waves-effect"  data-target="#create"  data-toggle="modal">Add New Class<i class="md md-add"></i></button> 
                                
                            </div>
                        </div>
                        <div class="row">
                        
                        
                        <div class="table-responsive">
                             
                            <form id="form1" name="form1" method="post" action="">
                          	 <table align="center" style="width:60%" class="table table-striped table-vmiddle table-hover">
                                        <tr>
                                            <td>No</td>
                                          <td width=" " style="text-align:"> Class Name</td>
                                          <td width=" "> Next Class/Promotion to</td>
                                          </tr>
												<?php 
                                     
                                                $query=$sql->Prepare("SELECT * FROM tbl_classes  ");		
                                             
                                            
                                         
                                                $b=$sql->Execute($query);
                                                 $counter=0;
                                                while( $r= $b->FetchRow())
                                                
                                                {
                                                   
                                                ?>
									      <tr>
                                           <td><?php   $thecounter=$counter++ ;echo $thecounter?></td>
                                          <td>
										  <?php echo $r[name];?>
                                            <input type="hidden" name="class[]" id="class" value="<?php echo $r[name];?>" />
                                            
                                            </td>
                                             <td> 
                                              <label><strong>
                                                      <select   class="form-control" required="" name="next[]" >
                                                <option value="" >SELECT NEXT CLASS</option>
                                               
                                                <?php 
                                                $query2=$sql->Prepare("SELECT * FROM tbl_classes  ");		
                                             
                                            
                                         
                                                $queryOutput=$sql->Execute($query2);                           

                                               while( $set =  $queryOutput->FetchRow())

                                                            {
                                                            ?>
                                                    <option value="<?php echo $set['name'] ?>" <?php if($set['name']==$r['nextClass']){echo 'selected="selected"';}?>><?php echo $set['name'] ?></option>
                                                      <?php }?>
                                                     <option value="Alumni">Completed</option>
                                                  </select>
                                                </strong></label>
                                            
                                            </td>
                                            <td><a onclick="return confirm('Are you sure you want to delete <?php echo $r['name'] ?>??')" href="view_class.php?delete=<?php echo $r['name'] ?>"><i class="md md-delete"></i></a></td>
                                          </tr>
                                              <?php 
																			  
								            } ?>
										      
                                           
                                             
                                          </table>
                                        
                                          <div class="row"><center>
                                          <input type="hidden" name="counter" value="<?php  echo $counter++;?>" id="upper" />
                                                <input  id="proceed" type="submit" name="sub" id="Edit" value="UPDATE" class="btn btn-primary btn-large">
                                                <input  id="proceed" type="submit"  name="refresh" id="refresh" value="refresh" class="btn btn-success btn-large">
                                                
                                            </center></div>  <p></p>
                                    </form>
                        </div>
                        
                        </div>
             
                    </div>
                </div>
               
               
                </div>
                     
              
                
            </section>
        </section>
        
         
        <?php  $app->getDashboardScript() ; $app->getuploadScript(); ?>
        <script src="vendors/bootstrap-select/bootstrap-select.min.js"></script>
        <script src="vendors/chosen/chosen.jquery.min.js"></script>

        <script src="vendors/bootgrid/jquery.bootgrid.min.js"></script>
       
      
    </body>
  
</html>
