<?php

namespace base;

use db\Database;
use Lii;

abstract class Model{
    
    protected $_db;
    
    
    public function db() {
        if(!$this->_db instanceof Database){
            $this->connect();
        }      
        return $this->_db;
    }
    
    public function connect() {
        $type = Lii::$app->parm("db/type");
        $host = Lii::$app->parm("db/host");
        $name = Lii::$app->parm("db/name");
        $user = Lii::$app->parm("db/user");
        $pass = Lii::$app->parm("db/pass");
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