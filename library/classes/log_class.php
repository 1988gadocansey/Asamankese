<?php
namespace classes;
use classes\Core;
 ini_set('display_errors', 0);
class Log{

private $action;
private $activities;

public function __construct(){
     
    return $this->logUser();
}

public function getUser()
{
		return $_SESSION['USERNAME'];
}

public function getBrowser(){
	
	return $_SERVER['HTTP_USER_AGENT'];
	
}

public function getIP(){
if (getenv('HTTP_X_FORWARDED_FOR')) {
                            $pipaddress = getenv('HTTP_X_FORWARDED_FOR');
                            $ipaddress = getenv('REMOTE_ADDR');
                              return $ip=$pipaddress. "(via $ipaddress)" ;
                        } else {
                            $ipaddress = getenv('REMOTE_ADDR');
                           return $ip= $ipaddress;
                        }
}

public function getHostname(){
	$ip=$_SERVER['REMOTE_ADDR'];
	return gethostbyaddr($ip);
}

public function getPages(){
    return $page= basename($_SERVER['REQUEST_URI']);
}
public function logUser(){
 $con=  Core::getInstance();
 $page=  $this->getPages();
 $host=  $this->getHostname();
 $ip=  $this->getIP();
 $browser=  $this->getBrowser();
 $user=  $this->getUser();
 return $con->dbh->query("INSERT INTO tbl_system_log(  `USERNAME`,  `HOSTNAME`, `IP`, `BROWSER_VERSION`,PAGES) VALUES ( '$user' , '$host', '$ip', '$browser','$page') ");
 }
 
}
$log=new Log();
 
 
 
