<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of boot
 *
 * @author Software Engineer
 */
namespace classes;
use classes\Login;
use classes\skeleton;
class Boot {
   private $mac="";
   private $connect;
    public function __construct() {
        global $sql;
        $this->mac=new  Login();
        $this->connect=$sql;
    }
    public function __clone() {
        
    }
    public function __destruct() {
        
    }
     

    public function bootApp(){
         
            
               ?>
<!DOCTYPE html>
    <!--[if IE 9 ]><html class="ie9"><![endif]-->
 <head>   
    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Asamamkese | School Management software</title>
        
        <!-- Vendor CSS -->
        <link href="vendors/animate-css/animate.min.css" rel="stylesheet">
            
        <!-- CSS -->
        <link href="css/app.min.css" rel="stylesheet">
    </head>
      
    <body class="login-content">
        <div style="margin-top: 80px"></div>
        <!-- Login -->
        <table align="center" border="0">
            
            <tr>
                <td>
        <img src="images/logo1.png" style=" width:189px;height: 180px;margin-bottom: -157px"  > 
        </td>
        </tr>
        <tr>
            <td >
        <div class="lc-block toggled" id="l-login" style="margin-top: 165px">
            
            <?php $this->displayMessage(); ?>
            <form  method="post" action="index.php?action=login">
            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="md md-person"></i></span>
                <div class="fg-line">
                    <input type="text" class="form-control" placeholder="Username" name="username" required>
                </div>
            </div>
            
            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="md md-accessibility"></i></span>
                <div class="fg-line">
                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                </div>
            </div>
            
            <div class="clearfix"></div>
            
            <!--<div class="checkbox">
                <label>
                    <a data-toggle="modal" href="#modalWider">Create Account</a>
                </label>
            </div>-->
            
            <button type='submit' class="btn btn-login btn-danger btn-float"  ><i class="md md-arrow-forward"></i> 
                
            </form>     
           
            
        </div>
        </td>
        </tr>
         
        <Tr>
           
            <Td><small>&copy <?php echo date("Y"); ?> | Gad Ocansey</small></Td>
        </Tr>
    </table>
        <!-- Register -->
        <div class="lc-block" id="l-register">
             
            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="md md-person"></i></span>
                <div class="fg-line">
                    <input type="text" class="form-control" placeholder="Username">
                </div>
            </div>
            
            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="md md-mail"></i></span>
                <div class="fg-line">
                    <input type="text" class="form-control" placeholder="Email Address">
                </div>
            </div>
            
            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="md md-accessibility"></i></span>
                <div class="fg-line">
                    <input type="password" class="form-control" placeholder="Password">
                </div>
            </div>
            
            <div class="clearfix"></div>
            
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="">
                    <i class="input-helper"></i>
                    Accept the license agreement
                </label>
            </div>
            
            <a href="#" class="btn btn-login btn-danger btn-float"><i class="md md-arrow-forward"></i></a>
            
            <ul class="login-navigation">
                <li data-block="#l-login" class="bgm-green">Login</li>
                <li data-block="#l-forget-password" class="bgm-orange">Forgot Password?</li>
            </ul>
        </div>
        
        <!-- Forgot Password -->
        <div class="lc-block" id="l-forget-password">
            <p class="text-left">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eu risus. Curabitur commodo lorem fringilla enim feugiat commodo sed ac lacus.</p>
            
            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="md md-email"></i></span>
                <div class="fg-line">
                    <input type="text" class="form-control" placeholder="Email Address">
                </div>
            </div>
            
            <a href="#" class="btn btn-login btn-danger btn-float"><i class="md md-arrow-forward"></i></a>
            
            <ul class="login-navigation">
                <li data-block="#l-login" class="bgm-green">Login</li>
                <li data-block="#l-register" class="bgm-red">Register</li>
            </ul>
        </div>
        
        <!-- Javascript Libraries -->
        <script src="js/jquery-2.1.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        
        <script src="vendors/waves/waves.min.js"></script>
        
        <script src="js/functions.js"></script>

       
    </body>

</html>
               <?php
          
          
    }
    
    public function displayMessage(){
         if(isset($_GET['login'])=='error'){
             echo "<div class='alert alert-danger' style='margin-top:%; '>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <strong>Warning!</strong> Authentication failed!  Invalid username and password.
         </div>";}
          elseif(isset($_GET['success'])){
             echo ("<div class='alert alert-success alert-dismissible' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                               Account created successfully . You can now login from here
                            </div>");}
         if(isset($_GET['System'])=='Failed'){
             die ("<div class='alert alert-danger' style='margin-top:%'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <strong>Warning!</strong> Please contact 0505284060 or gadocansey@gmail.com
         </div>");}
     
    }
}
