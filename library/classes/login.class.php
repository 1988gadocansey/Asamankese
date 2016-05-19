<?php
    /**
     *@desc this class handles all the client end log in details and methods
     *@desc this depands on the connect.php and Session.class.php
     */
	//@define('$USER_LOGIN_VAR',$staffid);
	//@define('$USER_PASSW_VAR',$staffpassword);
	 
namespace classes;
 
	class Login{
		private $session;
		private $redirect;
		private $hashkey;
		private $md5;
		private $remoteip;
		private $useragent;
		private $sessionid;
		private $result;
		private $connect;
		private $crypt;
                private $jconfig;
	        private $mac_addr;
                private $homepage;
                private $algorithm;
                private $key;
                private $config;
                private $mode;
                private $stream;
		public $sql;
                 

                public function __construct( ){
			global $sql ;
                         $a=new \Session() ;
			$this->redirect ="index.php?login=error";
                        $this->homepage ="dashboard.php?welcome=1";
			$this->hashkey	=$_SERVER['HTTP_HOST'];
			$this->md5=true;
			$this->remoteip = $_SERVER['REMOTE_ADDR'];
			$this->useragent = $_SERVER['HTTP_USER_AGENT'];
			$this->session	=$session;
			$this->connect = $sql;
			$this->mac_addr =  $this->getMac();
			 $this->sql = $sql;
                        $this->sessionid = $a->getSessionID();
			 $this->session	=$a;
                        $this->algorithm = MCRYPT_RIJNDAEL_256;	
                        $this->mode = MCRYPT_MODE_ECB;
                        $this->Mhash();
                        $this->stream = mcrypt_create_iv(mcrypt_get_iv_size($this->algorithm, $this->mode), MCRYPT_RAND);
                        
		}
                public function encodeString($url){
                        return(mcrypt_encrypt($this->algorithm, $this->key, $url, $this->mode, $this->stream));	
                }//End Function

                public function decodeString($url){
                        return (rtrim(mcrypt_decrypt($this->algorithm, $this->key, $url, $this->mode, $this->stream),"\0"));
                }//End Function

                public function Mhash(){
                        $this->key = sha1("RAC-1".$this->config->secret,TRUE);
                }//End Function

		 
		public function signin($USER_LOGIN_VAR,$USER_PASSW_VAR){
			
			  
			 $data->PIN;
			
			if($USER_LOGIN_VAR=="" || $USER_PASSW_VAR == ""){
				
				$this->logout("empty");			
			}
                        $_SESSION["name"]=$USER_LOGIN_VAR;
			$this->user=$_SESSION["name"];
			if($this->md5){
				$passwrd = md5($USER_PASSW_VAR);
				}else{
				$passwrd = $USER_PASSW_VAR;
			}
						
			$query = "SELECT * FROM tbl_auth  WHERE USERNAME =".$this->sql->Param('a')." AND PASSWORD=".$this->sql->Param('b')." AND ACTIVE='1'";
			$stmt = $this->connect->Prepare($query);
			 $stmt = $this->connect->Execute($stmt,array($USER_LOGIN_VAR,$passwrd));
			  $this->connect->ErrorMsg();
			
			if($stmt){		

				if($stmt->RecordCount() > 0){
					
				 
				$userid=$stmt->FetchNextObject();
				$this->storeAuth($userid->ID, $userid->USERNAME);
                                $_SESSION['USERNAME']=$userid->USERNAME;
                                $_SESSION['level']=$userid->USER_TYPE;
                                 $_SESSION['ID']=$userid->ID;
				$this->setLog("Login","$_SESSION[name] has Login into the system");
                                $this->session->set("USERNAME", $userid->USERNAME);
                                $date=  strtotime(NOW);
                                $stmt=$this->connect->Prepare("UPDATE tbl_auth SET LAST_LOGIN='$date' WHERE ID='$_SESSION[ID]'");
                                $this->connect->Execute($stmt);
                                if($_SESSION['level']=="administrator"){
				header('Location: ' . $this->homepage);	
				
                                }
                                else{
                                    header("Location:students.php");
                                }
					
				}else{
                                    	$this->logout("wrong");
					
				}
				
				
			}else{ 
			//error msg
			}
			
		}//end
		
		 
		
	public function storeAuth($userid,$login)
	  {
		$this->session->set('pyuserid',$userid);
		$this->session->set('h20',$login);
		
		$this->session->set('random_seed_pay',md5(uniqid(microtime())));

		$hashkey = md5($this->hashkey . $login .$this->remoteip.$this->sessionid.$this->useragent);
		$this->session->set('login_hash_pay',$hashkey);
		$this->session->set("LAST_REQUEST_TIME",time());
	  }//end
	
		public function logout($msg="out")
                {
                    $this->setLog("Logout", $this->session->get("USERNAME") ." has logout   from the system  " );
				
                         
                        $this->session->del('ID');
                        $this->session->del('USERNAME');
                         
                        $_SESSION = array();
                        session_destroy();
                        $this->direct($msg);
                }//end
	
	 public function direct($direction=''){
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
			header('Cache-Control: no-store, no-cache, must-validate');
			header('Cache-Control: post-check=0, pre-check=0',FALSE);
			header('Pragma: no-cache');
			
			if($direction == 'empty'){
			header('Location: ' . $this->redirect.'&attempt_in=0');	
			}else if($direction == 'wrong'){
                            
			header('Location: ' .$this->redirect.'&attempt_in=1');	
			}else if($direction=="out"){
			header("Location:index.php?logout=1");	
			}else if ( $direction =='captchax'){
					header('Location: ' .$this->redirect.'&attempt_in=11');
					}else{
						header('Location: ' .$this->redirect);
						}
			exit;
			
		}
                public function confirmAuth(){
		
		  $login = $this->session->get("h20");
		  $hashkey = $this->session->get('login_hash_pay');
	
		if(md5($this->hashkey . $login .$this->remoteip.$this->sessionid.$this->useragent) != $hashkey)
		{
			$this->logout();
		}
		
	}//end
	public function getMac(){
		  $mac          = "";
		  $cmd_info     = "";
		  $mac_address  = "";

		  
		  ob_start();
		  system("ipconfig /all");
		  $cmd_info=ob_get_contents();
		  ob_clean();
		  $mac          = strpos($cmd_info, 'Physical');
		  $mac_address  = substr($cmd_info,($mac+36),17);//MAC Address
		  return $mac_address;

      }

	
      public function setLog($event,$activity){
                $userid=$this->session->get("pyuserid");
                $stmt = $this->connect->Prepare("INSERT INTO `tbl_system_log` ( `USERNAME`, `EVENT_TYPE`, `ACTIVITIES`, `HOSTNAME`, `IP`, `BROWSER_VERSION`,MAC_ADDRESS,SESSION_ID) VALUES ('".$userid."', '$event','$activity', '".$this->hashkey."','".$this->remoteip."','".$this->useragent."','".$this->mac_addr."','".$this->session->getSessionID()."')");
                $this->connect->Execute($stmt);

       }
		

       
      }
?>
