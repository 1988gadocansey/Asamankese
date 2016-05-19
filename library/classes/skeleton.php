<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of skeleton
 * @package classes
 * @access public
 * @author Administrator
 */
 
namespace classes;
class skeleton {
    public function __construct() {
        
    }
    public function getTitle(){
        return "Phylio";
    }
    public function getHeaderTitle(){
        echo " Phylio | High Schools Manager";
    }
    public function footer(){
        $right= "&copy Copyright ".date('Y')." Phylio";
        return $right;
    }
}
