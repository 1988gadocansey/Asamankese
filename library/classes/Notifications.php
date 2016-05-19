<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace classes;

/**
 * Description of Notifications
 * Handles all routes notifications eg success,warning ,failure
 * @author Administrator
 */
 
class Notifications {
    public function __construct() {
        
    }
     public function displayMessage(){
         if(isset($_GET['error'])){
             echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                Oh snap! Something went wrong. Correct some few stuff and repeat the action again
                            </div>";}
         elseif(isset($_GET['exist'])){
                         echo "<div class='alert alert-warning alert-dismissible' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                               Item exists already add a different one
                            </div>";}
         elseif(isset($_GET['success'])){
             echo ("<div class='alert alert-success alert-dismissible' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                               Action successfully completed
                            </div>");}
     
       }
    
}
