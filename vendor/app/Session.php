<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app;

/**
 * Description of Session
 *
 * @author lukasz
 */
class Session {
    public function init(){
        session_start();
    }
    
    public function set($name, $value){
        $_SESSION[$name] = $value;
    }
    
    public function get($name){
        if (isset($_SESSION[$name])){
            return $_SESSION[$name];
        }
        return NULL;
    }
    
    public function unSetVar($name){
        if (isset($_SESSION[$name])){
            unset($_SESSION[$name]);
        }
    }

    public function destroy(){
        session_destroy();
    }
    
    public function isSetVar($name) {
        return isset($_SESSION[$name]);
    }
}
