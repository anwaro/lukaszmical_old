<?php

namespace db;

use db\Db;
use db\ActiveRecordAbstract;

/**
 * Description of ActiveRecord
 *
 * @author lukasz
 */
class ActiveRecord extends ActiveRecordAbstract {
    
    private $_columns = [];
    private $_action = 'INSERT';
    private $_db;
    
    public function __construct() {
        $this->_db = new Db();
    }

    public function __get($name) {
        if(in_array($name, $this->getTableColumns())){
            return $this->_columns[$name];            
        }else{
            throw new \Exception("Undefined index: " . $name . " ");
        }
    }
    
    public function __set($name, $value) {
        if(in_array($name, $this->getTableColumns())){
            $this->_columns[$name] = $value;          
        }else{
            throw new \Exception("Undefined index: " . $name . " ");
        }
    }
    
    private function _insert(){
        $this->_db->insert($this->_columns);
        $id = $this->_db->lastId();
        $this->_db->reset();
        $this->load($this->one($id));
        return ;
    }
    
    private function _update(){
        
    }

    public function all() {
        return $this->_db
                ->select('*')
                ->orderBy('id', 'DESC')
                ->from($this->getTableName())
                ->all();
    }
    
    public function one($col, $sign=NULL, $val=NULL){
        if($sign == NULL){
            $val = $col;
            $sign = "=";
            $col = 'id';
        }
        return $this->_db
                ->select('*')
                ->from($this->getTableName())
                ->where($col, $sign, $val)
                ->one();
    }
    
    public function find($col, $sign=NULL, $val=NULL) {
        $this->load($this->one($col, $sign, $val));
        $this->_action = 'UPADATE';
        return $this;
    }
    
    public function load($vals){
        $this->_action = 'INSERT';
        foreach ($vals as $key => $val){
            $this->{$key} = $val;
        }
        return $this;
    }


    public function save(){
        switch ($this->_action){
            case 'INSERT':
                $this->_insert();
                break;
            case 'UPDATE':
                $this->_update();
                break;
            default :
                break;                
        }
    }
    
    public function db() {
        return $this->_db;
    }
}
