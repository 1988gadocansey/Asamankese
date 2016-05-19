<?php

namespace classes;
class smsgetway{
	private $config;
         private $connect;
	private $url;
	function __construct(){
		 
              global $sql,$season;
              $this->connect=$sql;
        }
	
	/**
	 * 
	 * @param string $phone
	 * @param string $msg
	 */
	public function sendSms($phone,$msg){
		$url = $this->url."&msg=". urlencode($msg)."&to=". $phone ;
		
		// create curl resource
		$ch = curl_init();
		// set url
		curl_setopt($ch, CURLOPT_URL, $url);
		//return the transfer as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// $output contains the output string
		$output = curl_exec($ch);
		// close curl resource to free up system resources
		curl_close($ch);
		$output = substr($output, 3);
		return $output;
	}
	
	/**
	 * sends same message in bulk
	 * @param array $arrayphone
	 * @param string $msg
	 */
	public function sendBulkSms($message,$phone,$receipient){
		 // echo $phone;
        
        //print_r($contacts);
        if (!empty($message)&& !empty($receipient)) {
    
                 //$key = "83f76e13c92d33e27895";
                $message = urlencode($message);
               $phone = str_replace(' ', '', $phone);
                 $phone = str_replace('-', '', $phone);
                 $phone="+233".\substr($phone,1,9);
            $url = 'http://txtconnect.co/api/send/'; 
            $fields = array( 
            'token' => \urlencode('a166902c2f552bfd59de3914bd9864088cd7ac77'), 
            'msg' => \urlencode($message), 
            'from' => \urlencode("TPOLY"), 
            'to' => \urlencode($phone), 
            );
            $fields_string = ""; 
                    foreach ($fields as $key => $value) { 
                    $fields_string .= $key . '=' . $value . '&'; 
                    } 
                    \rtrim($fields_string, '&'); 
                    $ch = \curl_init(); 
                    \curl_setopt($ch, \CURLOPT_URL, $url); 
                    \curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true); 
                    \curl_setopt($ch, \CURLOPT_FOLLOWLOCATION, true); 
                    \curl_setopt($ch, \CURLOPT_POST, count($fields)); 
                    \curl_setopt($ch, \CURLOPT_POSTFIELDS, $fields_string); 
                    \curl_setopt($ch, \CURLOPT_SSL_VERIFYPEER, 0); 
                    $result2 = \curl_exec($ch); 
                    \curl_close($ch); 
                    $data = \json_decode($result2); 
                    if ($data->error == "0") {
                   $result="Message was successfully sent"; 
                   
                    }else{ 
                    $result="Message failed to send. Error: " .  $data->error; 
                     
                    } 
                     
    
                $date=time();
                $user=  $_SESSION['ID'];
                $term=$_SESSION[term];
                $year=$_SESSION[year];
                $query=$this->connect->Prepare("INSERT INTO `tbl_sms` ( `number`, `message`, `status`, `dates`, `type`, `name`, `term`, `year`, `sent_by`) VALUES ('$phone', '$message', '$result', '$date', 'results sms', '$receipient', '$term', '$year', '$user')");
              //  print_r($query);
                 return $this->connect->Execute($query);
            }
        
		
	}//end
        
            
                 // bulk sms form tpoly
                 public function sendBulkSMS1($arrayphone,$msg){
		$returns =array();
		if(is_array($arrayphone)){
			foreach ($arrayphone as $phone){
				$returns[] =$this->sendSMS1($phone, $msg);
			}
		}else{
			$returns[] =$this->sendSMS1($phone, $msg);	
		}
		
		return $returns;
		
	}
}
?>