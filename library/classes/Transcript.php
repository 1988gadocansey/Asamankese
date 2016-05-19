<?php
namespace classes;
use classes\Core;
use classes\Student;
use classes\helpers;

/**
 * @access public
 * @author Gad Ocansey <gadocansey@gmail.com>
 * @copyright (c) 2014, Gad Ocansey
 */

class Transcript  {
  public function __construct() {
       session_start();
  }
  /**
   *  This function generate the student
   *  biodata of the transcript
   */
  public function getBiodata(){
       $help=new helpers();
       $student=new Student();
        $person=$student->getStudent( $_SESSION[USERNAME]);
       
      ?>
    <table class='' id="">
       <tr>
        <th height="47" align="center" valign="top" scope="row"><div align="center">
          <div>
              <table style="margin-left:-20%"width="70%"  height="90px" border="0" cellspacing="1">
              <tr>
                <th align="left" valign="middle" scope="row">NAME: </th>
                <th width="88%" align="center" valign="middle" scope="row"><div align="left"> <strong>
                          <?php 

                              echo "$person[surname], $person[othernames]";
                            ?>
                 </strong></div></th>
                <th width="1%" rowspan="6" align="center" valign="middle" scope="row">&nbsp;</th>
              </tr>
              <tr>
                <th height="21" align="left" valign="middle" scope="row">INDEX NO:</th>
                <th height="21" align="left" valign="middle" scope="row"><strong><?php echo $person[indexno]; ?>&nbsp;</strong></th>
              </tr>
              <tr>
                <th width="11%" height="18" align="left" scope="row">PROGRAMME: </th>
                <th scope="row"><div align="left"><strong>
                 <?php echo $help->getProgram($person[programme]); ?>
                </strong></div></th>
              </tr>
              <tr>
                <th align="left" scope="row"> </th>
                <th scope="row"><div align="left"><strong>

                </strong></div></th>
              </tr>
              <tr>
                <th align="left" scope="row"> </th>
                <th align="left" scope="row"><?php echo $person[cgpas]; ?></th>
              </tr>
              <tr>
                <th height="20" align="left" scope="row">&nbsp;</th>
                <th scope="row">&nbsp;</th>
              </tr>
            </table><?php
  }
  /**
   * generate the body of the transcript
   */
    public function generateTranscript(){
         
        $con=  Core::getInstance();
        $help=new helpers();
       $student=new Student();
        $person=$student->getStudent( $_SESSION[USERNAME]);
        
         $STM2 = $con->dbh->query("SELECT   distinct year,level from grades where stuId='$person[indexno]' order by level asc ");
         $result = $STM2->fetchAll();
                
	  ?>
      
        <table width="869" style="text-align:left;margin-left: 5%;font-size: 16px" height="90" class=""  border="0" cellspacing="0">
        <tr>
        
          <td  style=" " align="left"><span style="text-align:  center">
            <?php  
            foreach ($result as $row){
            for($i=1;$i<3;$i++){
              $stmt=$con->dbh->query("select coursecode,coursename,credits,exam,score,gpoint from grades where stuId='$person[indexno]' and year='$row[year]' and term='$i'");

                if(count($output=$stmt->fetchAll())>0){

                echo "YEAR : ".$row[year]."    ";
                echo ", SEMESTER : ".$i;
                 echo ", LEVEL :  " .$row[level];
                

                 foreach ($result  as $output2){
                  
                 }
                $ttotal=0;
                $totcredit=0;
                $totgpoint=0; 
                $cgpa=0.0;
         ?>
          </span>
            <hr/>
            <table style=" " width="854" border="0" cellspacing="0">
            
            <tr>
                <td width="813"><table width="103%" height="100%" border="0" style="" class="sortable" cellpadding="1" cellspacing="1" bordercolor="">
                <thead >
                  <tr class="style15">
                    <td  width="86" height="22" class="style15">Code</td>
                    <td  width="558"><div  class="style15">Title</div></td>
                    <td  width="48"><div  class="style15">CR</div></td>
                    <td  width="49"><div class="style15">GR</div></td>
                    <td width="95" ><div class="style16"><strong>GP</strong></div> <div align="center" class="style16"></div></td>
                    </tr>
                </thead>
                <tbody>
                  <?php 
		  
                foreach ($output as $rs){

                 

                ?>
                  <tr>
                    <td  ><div align="left" class="style16"><?php echo $rs[coursecode]; ?></div></td>
                    <td ><div align="center" class="style16"><?php 
				echo $help->getCourseName($rs[coursecode])	
                    ;?></div></td>
                    <td><div align="center" class="style16"><?php  $totcredit+=$rs[credits];  if($rs[credits]){ echo $rs[credits];} else{echo "IC";}$max_credt+=$totcredit;?></div></td>
                    <td><div align="center" class="style16"><?php  if($rs[score]){ echo $rs[score];} else{echo "IC";}?></div></td>
                    <td><div align="center" class="style16">
                      <?php  $tota=$totgpoint+=$rs[gpoint]; $total_gp+=$tota;if($rs[gpoint]){ echo $rs[gpoint];} else{echo "0";} ;$cgpa=$total_gp/$max_credt ?>
                            
                    </div>     
                        <div align="left" class="style16"></div></td>
                     
                    <?php 
                     } ?>
                  </tr>
                  <tr>
                    <td  >&nbsp;</td>
                    
                    <td >GPA <?php echo  number_format(@($totgpoint/$totcredit), 2, '.', ',');?></br> CGPA <?php echo  number_format(($cgpa), 2, '.', ',');?></td>
                    
                    <td ><?php echo $totcredit; ?>&nbsp;<span style="text-align: center"></span></td>
                    <td >&nbsp;</td>
                    <td ><?php echo $totgpoint; ?>&nbsp;</td>
                  </tr>
                  <tr>
                    <td  >&nbsp;</td>
                    <td >&nbsp;</td>
                    <td >&nbsp;</td>
                    <td >&nbsp;</td>
                    <td >&nbsp;</td>
                  </tr>
                    
                        
                </tbody>
                <tfoot>
                </tfoot>
                <tfoot>
                </tfoot>
              </table></td>
        <?php }
?>
            </tr>
    </table><?php }?><?php }}
    
    }?></td>
        
        </tr>
  
      </table>
    
   