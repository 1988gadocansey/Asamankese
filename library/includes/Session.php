<?php

 if (!isset($_SESSION)) {

      session_start();
	
    }
	if(!isset($_SESSION['USERNAME']))
	{

		header("location:index.php");
		exit();

	}

 
# Check if a user is logged in 
function isLogged(){ 
    if($_SESSION['USERNAME']){ # When logged in this variable is set to TRUE 
        return TRUE; 
    }else{ 
        return FALSE; 
    } 
} 
 
# Log a user Out 
function logOut(){ 
     $_SESSION = array(); 
    if (isset($_COOKIE[session_name()])) { 
        setcookie(session_name(), '', time()-42000, '/'); 
    } 
    session_destroy();  
    header("location:index.php?logout=1");
} 

# Session Logout after in activity 
  function sessionX(){ 
   
	 
 
    $session_name = 'funny'; // Set a custom session name
        $secure = false; // Set to true if using https.
        $httponly = true; // This stops javascript being able to access the session id. 
 
        ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies. 
        $cookieParams = session_get_cookie_params(); // Gets current cookies params.
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
        session_name($session_name); // Sets the session name to the one set above.
         
    $logLength = 1800; # time in seconds :: 1800 = 30 minutes 
    $ctime = strtotime("now"); # Create a time from a string 
    # If no session time is created, create one 
    if(!isset($_SESSION['sessionX'])){  
        # create session time 
        $_SESSION['sessionX'] = $ctime;  
    }else{ 
        # Check if they have exceded the time limit of inactivity 
        if(((strtotime("now") - $_SESSION['sessionX']) > $logLength) && isLogged() ){ 
            # If exceded the time, log the user out 
            session_unset();
            logOut();
            # Redirect to login page to log back in 
            header("Location:index.php"); 
            exit; 
        }else{ 
            # If they have not exceded the time limit of inactivity, keep them logged in 
            $_SESSION['sessionX'] = $ctime; 
        } 
    }  
} 
// Run Session logout check 
 sessionX(); 
 
 
 
