<?php
namespace classes;
class JConfig {
	public $dbtype = 'mysql';
	public $server = 'localhost';
	public $user = 'root';
	public $database = 'wwwuhaso_database';
	public $password = '';
	public $secret='forcountryandservice1957';
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