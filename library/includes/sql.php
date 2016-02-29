<?php
	//$config = new JConfig();
    $sql = ADONewConnection($config->dbtype); 
    $sql->debug = $config->debug;
	$sql->autoRollback = $config->autoRollback;
       // $ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
    $sql->Connect($config->server, $config->user, $config->password, $config->database); 

	$session=new Session();
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
			header('Cache-Control: no-store, no-cache, must-validate');
			header('Cache-Control: post-check=0, pre-check=0',FALSE);
			header('Pragma: no-cache');
			
  
?>