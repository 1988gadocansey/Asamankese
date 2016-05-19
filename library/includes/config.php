<?php
namespace classes;
global $sql,$session,$config;
 
define( '_PHYLIO','INDEX');
define("JPATH_ROOT",dirname(__FILE__));
define("DS",DIRECTORY_SEPARATOR);
define( 'JPATH_CONFIGURATION', 	JPATH_ROOT );
define( 'JPATH_LIBRARIES',	 	JPATH_ROOT.DS.'library/includes/' );
 
//ON THE REAL SERVER THE pvproject part must be removed.
define('START_YEAR','2015');

class JConfig {
	public $dbtype = 'mysqli';
	public $server = 'localhost';
	public $user = 'root';
	public $database = 'angel_academy';
	public $password = "";
	public $secret='gadocansey';
	public $debug = false;
	public $autoRollback= true;
	public $ADODB_COUNTRECS = false;
	private static $_instance;
	 
	public function __construct(){
            session_start();
	}
	
	private function __clone(){}
	
	public static function getInstance(){
	if(!self::$_instance instanceof self){
	     self::$_instance = new self();
	 }
	    return self::$_instance;
	}

}


$config = JConfig::getInstance();

//included classes
 
include "Adodb/adodb.inc.php";
include "sql.php";
  
include_once('Adodb/adodb-pager.inc.php');
?>