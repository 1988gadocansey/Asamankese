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
              $teacher=new classes\Teacher();  $teacher2=$teacher->getTeacher_ID($_SESSION[ID]);
            
             if(isset($_GET[sub])){
                 $_SESSION[amount]=$_POST[amount];
                 $_SESSION[receipt]=$_POST[receipt];
                         $pupil=$student->getStudent($_POST[student]);
                              
                 $amount=$_POST[amount];
                  if($type=='PTA'){
              $amount_pta=$amount;
                }
                elseif($type=='Academic'){
                    $amount_acadmic=$amount;
                }
                else{
                    $others=$amount;
                }
                  
                  $query=$sql->Prepare("INSERT INTO tbl_fee_ledger (RECEIPT,CLASS,`STUDENT`, `FEE_TYPE`,  `AMOUNT`, `DESCRIPTION`, `CHEQUE_NO`, `TERM`, `YEAR`,RECEIVED_BY)VALUES('".$help->getReceipt()."','$_POST[form]','$ward','$_POST[type]','$_POST[amount]','Fees Payment','$_POST[draft]','".$school->TERM."','".$school->YEAR."','".$teacher2->ID."')");
                  $trans1=$query=$sql->Execute($query);
                  $stmt=$sql->Prepare("UPDATE tbl_student SET BILLS_PAID=BILLS_PAID +'$_POST[amount]' , PTA_OWING=PTA_OWING-'$amount_pta',ACADEMIC_OWING=ACADEMIC_OWING-'$amount_acadmic',OTHER_BILLS=OTHER_BILLS-'$others',BILLS_OWING=BILLS-BILLS_PAID  WHERE INDEXNO='$_POST[student]'");
                 $trans2= $sql->Execute($stmt);
                 if($trans2 && $trans1){
                     // send sms to parents
                    $stmt= $sql->Prepare("select * from tbl_student where INDEXNO='$_POST[student]'") ;
                    $stmt2=$sql->Execute($stmt);
                     
                    while ($res=$stmt2->FetchRow())
                        {

                            $outstanding=$res[BILLS_OWING];
                            $type=$_POST[type];
                            $paid=$_POST['amount'];
                            $parentphone=$res['GUARDIAN_PHONE'];
                            $hassub=$res['sms'];
                            $student=$res[INDEXNO];
                            $sname=$res['SURNAME'].", ".$res['OTHERNAMES'];
                        }

                            if($parentphone){
                                $sms="Hi $sname ,you have just paid GHc $paid   as $type fees leaving a  Bal of GHc $outstanding  Thank You.";
                                         $_SESSION['connected']=$help->ping("www.google.com",80,20); 

                                //$help->sendtxt($sms,$parentphone,'feeAlert',$indexno);
                                                                 $_SESSION['connected']='';
                                                                  $_SESSION['student']='';
                                               //update receipt table after transaction
                                $help->UpdateReceipt();
                                header("location:printreceipt.php?student=$student&type=$type&paid=$paid&receipt=$_SESSION[receipt]&left=$outstanding");

                            }


                 }
                     
                 
                }
                
			   $STM = $sql->Prepare("SELECT * FROM tbl_student WHERE INDEXNO='$_GET[student]'");
			 
                                                    $STM=$sql->Execute($STM);
                                                    
                                                     $num=0;
                                                     while($r = $STM->FetchRow())
                                                     {
                                                     
			 
                                                          $_SESSION[student]=$r[indexno];

     ?>
<style>
    .btn:not(.btn-link):not(.btn-float):not(.command-edit):not(.command-delete):not(.selectpicker) {
    box-shadow: 0px 2px 5px 0px rgba(0, 0, 0, 0.16), 0px 2px 10px 0px rgba(0, 0, 0, 0.12);
}
button, html input[type="button"], input[type="reset"], input[type="submit"] {
    cursor: pointer;
}
.btn {
    transition: all 300ms ease 0s;
    border: 0px none;
    text-transform: uppercase;
}
.btn-primary {
    color: #FFF;
    background-color: #2196F3;
    border-color: #0D8AEE;
}
.btn {
    display: inline-block;
    margin-bottom: 0px;
    font-weight: 400;
    text-align: center;
    vertical-align: middle;
    cursor: pointer;
    background-image: none;
    border: 1px solid transparent;
    white-space: nowrap;
    padding: 6px 12px;
    font-size: 13px;
    line-height: 1.42857;
    border-radius: 2px;
    -moz-user-select: none;
}
</style>
<div class="block-header">
                       <?php $notify->displayMessage();  ?>
         (NB:Use -(minus) to add an undercharge amount when student is pay his or her bill)           
                         
                    </div>
<form action="pay_fee_popup.php?sub=1" method="POST">
            <table width="91%" border="0">
              <tr>
                <th width="69%" height="105" align="center" valign="top" scope="row"><fieldset>
                  <div align="center">
                    <legend align="center" class="style1">Personal Records</legend>
                  </div>
                  <table width="741" border="0">
                    <tr>
                      <td width="495"><div class="divcurve" style="background-color:#D1E8D7">
                              
                       
 <script>
         function recalculateSum()
            {
                var num1 = parseFloat(document.getElementById("pay").value);
                var num2 = parseFloat(document.getElementById("bill").value);
                 
                  
                     
                        document.getElementById("amount_left").value =( num2-  num1)    ;
                     
                    
            }         
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}      
						
function printpage()
{
   type=document.getElementById("type").value;
      draft=document.getElementById("draft").value;

  if(draft==''){ alert('PLEASE TYPE DRAFT NO');
  return false;
  }
  
  if(type==''){ alert('PLEASE SELECT PAYMENT TYPE');
  return false;
  }
  
   pay=document.getElementById("pay").value;
   stuid=document.getElementById("indexno").value;
   receipt=document.getElementById("receiptno").value;
   draft=document.getElementById("draft").value;
  
   //old=out=document.getElementById("outstanding").value;
  // type=document.getElementById("type").value;
	if(type=='Academic'){old=document.getElementById("outstanding").value; }else if(type=='other'){old=document.getElementById("otheroutstanding").value; }
	
//	else if(type=='Academic Fee'){ old=document.getElementById("outstanding").value; }	 

url="printreceipt.php?paid="+pay+"&stuid="+stuid+"&receipt="+receipt+"&old="+old+"&draft="+draft+"&type="+type;
//alert(url);
MM_openBrWindow(url,'','menubar=yes,width=500,height=400');
 
            return true;

}
                        </script>
                        <table width="98%" border="0" cellpadding="5">
                            
                          <tr>
                            <th scope="row" align="right"> <div class="style6" align="right" >Receipt No</div></th>
                            <td><div class="style6"><?php echo $help->getReceipt(); ?>
                                    <input type="hidden"  name="receipt" value="<?php echo $help->getReceipt(); ?>"/>
                            </div></td>
                          </tr>
                          <tr>
                            <th width="36%" scope="row"><div align="right" class="style6">Name</div></th>
                            <td width="64%"><div align="left" class="style6"><?php echo "$r[SURNAME], $r[OTHERNAMES]";  ?>
                                    <input type="hidden" value="<?php echo $r[INDEXNO] ?>" name="student"/>
                            </div></td>
                            </tr>
                          <tr>
                            <th scope="row"><div align="right" class="style6">Index Number</div></th>
                            <td><div align="left" class="style6"><?php echo $r[INDEXNO]; ?>
                              
                              </div></td>
                            </tr>
                          <tr>
                            <th scope="row"><div align="right" class="style6">Class</div></th>
                        <td><div align="left" class="style6"><?php echo $r["CLASS"]; ?>
                              <input type="hidden" name="form" id="program" value="<?php echo $r["CLASS"]; ?>" />
                            </div></td>
                            </tr>
                            <?php if( $school->TERM==3){ ?>
                          <tr>
                            <th scope="row" align="right"><div class="style6" align="right" >Next Class</div></th>
                            <td><span class="style6">
                              <select name="promotion" id="level"  class="form-control"  >
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
                            </span></td>
                          </tr>
                            <?php } ?>
                          <tr>
                              <th scope="row"><div align="right" class="style6">Bills B/F GH&cent;</div></th>
                        <td><div align="left" class="style6"><?php echo $r["BILLS"]; ?>
                              
                            </div></td>
                            </tr>
                          <tr>
                            <th class="style6" scope="row" align="right"><div class="style6" align="right" >Bill Outstanding GH&cent</div></th>
                            <td class="style6"><?php  
                           echo    $r[BILLS]-$r[BILLS_PAID];
                                        
                            ?>
                              <input type="hidden" name="bill" id="bill" onkeyup="recalculateSum();" value="<?php echo $r[BILLS] - $r[BILLS_PAID]; ?>" /></td>
                          </td>
                          </tr>
                          <tr>
                            <th scope="row"><div align="right" class="style6">Bills Paid GH&cent</div></th>
                        <td><div align="left" class="style6"><?php echo $r["BILLS_PAID"]; ?>
                                <input  type="hidden" name="paid" value="<?php echo $r["BILLS_PAID"]; ?>"/>
                            </div></td>
                            </tr>
                          <tr>
                            <th scope="row"><div align="right" class="style6">PTA GH&cent</div></th>
                        <td><div align="left" class="style6"><?php echo $r["PTA_OWING"]; ?>
                              
                            </div></td>
                            </tr>
                          <tr>
                            <th scope="row"><div align="right" class="style6">Academic GH&cent</div></th>
                        <td><div align="left" class="style6"><?php echo $r["ACADEMIC_OWING"]; ?>
                              
                            </div></td>
                            </tr>
                           <tr>
                            <th scope="row"><div align="right" class="style6">Other Fees GH&cent</div></th>
                        <td><div align="left" class="style6"><?php echo $r["OTHER_BILLS"]; ?>
                              
                            </div></td>
                            </tr>
                            
                          <tr>
                            <th class="style6" scope="row" align="right"><div class="style6" align="right" >Fee type</div></th>
                        <td class="style6"><select   required=""  name="type" id="type"  class="form-control"   >
                              <option value="" >Select Type</option>
                              <option value="PTA" >PTA</option>
                              <option value="Academic" >Academic Fees</option>
                              <option value="other" >Others Fees</option>
                            </select></td>
                          </tr>
                          
                         
                          <tr>
                            <th class="style6" scope="row"><div align="right"><div class="style6" align="right" >Amount Paying</div></div></th>
                            <td class="style6"><label>
                                    <input type="text"  class="form-control"  required="" name="amount" id="pay"  onkeyup="recalculateSum();" />
                              </label></td>
                          </tr>
                          
                          <tr>
                            <th class="style6" scope="row"><div align="right"><div class="style6" align="right" >Total Amount Left</div></div></th>
                            <td class="style6"><label>
                                    <input type="text"  class="form-control"   name="outstanding" id="amount_left" onkeyup="recalculateSum();" readonly="readonly" />
                              </label></td>
                            </tr>
                            <tr>
                            <th class="style6" scope="row"><div align="right">Cheque No</div></th>
                            <td class="style6"><label>
                              <input type="text" class="form-control" name="draft" id="draft" ondblclick="return printpage()" />
                              </label></td>
                            </tr>
                             
                          
                        </table>
                      </div></td>
                      <td width="236" valign="top"><div class="divcurve" style="background-color:#D1E8D7">
                        <table width="237" border="0" bordercolor="">
                          <tr>
                              <td width="202"> <div align="center"><img <?php $person=$r[INDEXNO]; echo $help->picture("studentPics/$person.jpg",200)?>  src="<?php echo file_exists("studentPics/$person.jpg") ? "studentPics/$person.jpg":"img/user.jpg";?>" alt=" Picture of Student Here"   /></div>
                              <p align="center">&nbsp;</p></td>
                            </tr>
                        </table>
                      </div>
                      
                    

                    </tr>
                  </table>
                  </fieldset>
                        <hr/>                </th>
                </tr>
            
                <tr><td>
           <div class="panel-footer">
            <div class="row" align='center'>
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="btn-toolbar">
                 
                <input type="submit" name="Update" id="Update" value="Update Records" class="btn btn-primary"  onclick="return confirm('ARE YOU SURE EVERY DATA IS ACCURATE?')"/>
               
                  </form>
                <input type="submit" name="button" id="button" value="Print" onclick="return printpage()"  class="btn btn-success"/>
               
               <?php }?> 
                 
                 
         
            </div>
                </div>
            </div>
           </div></td></tr>
                </table>
          </div>
        <p align="center">&nbsp;</p></th>
      </tr>
    </table></th>
  </tr>
  <tr></tr>
</table>
         