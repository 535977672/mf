<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class1
 *
 * @author Administrator
 */
class class1 {
    private $r;
    
    function __construct($r = '') {
        $this->r = $r;
    }
    
    public function e($msg = ''){
        if($msg) echo "测试1 ： $msg<br />";
        else echo "测试1 ： $this->r<br />";
    }
}