<?php

//use Config;

abstract class Model extends Config{
    
    protected $_db;
    
    public function getTableName(){
        return '';
    }

    
    public function db() {
        if(!$this->_db instanceof Database){
            $this->connect();
        }      
        return $this->_db;
    }
    
    public function connect() {
        $type = $this->getParam("db/type");
        $host = $this->getParam("db/host");
        $name = $this->getParam("db/name");
        $user = $this->getParam("db/user");
        $pass = $this->getParam("db/pass");
        $this->_db = new Database($type, $host, $name, $user, $pass);
        $this->_db->exec("set names utf8");
        
    }
    
    public function post($name) {
        $return= filter_input_array(INPUT_POST);
        return $return[$name];
    }
    
    public function is_post($name) {
        return filter_input(INPUT_POST, $name)?1:0;
    }

}