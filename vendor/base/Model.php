<?php

namespace vendor\base;

use vendor\db\Database;


abstract class Model{
    
    protected $_db;
    
    
    public function db() {
        if(!$this->_db instanceof Database){
            $this->_db = new Database();
        }      
        return $this->_db;
    }
    
    public function post($name) {
        $return= filter_input_array(INPUT_POST);
        return $return[$name];
    }
    
    public function is_post($name) {
        return filter_input(INPUT_POST, $name)?1:0;
    }

}