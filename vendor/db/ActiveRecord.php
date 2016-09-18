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
        $this->_db
                ->to($this->getTableName())
                ->insert($this->_columns);
        $id = $this->_db->lastId();
        $this->load($this->one($id));
        return $this;
    }
    
    private function _update(){
        $this->_db
                ->update($this->getTableName())
                ->set($this->_columns)
                ->exec();
        return $this;
        
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
        $this->_action = 'UPDATE';
        return $this;
    }
    
    public function load($vals){
        $colsName = $this->getTableColumns();
        foreach ($vals as $key => $val){
            if(in_array($key, $colsName)){
                $this->_columns[$key] = $val;
            }
        }
        return $this;
    }


    public function save(){
        switch ($this->_action){
            case 'INSERT':
                return $this->_insert();
            case 'UPDATE':
                return $this->_update();          
        }
    }
    
    public function db() {
        return $this->_db;
    }
    
    public function getRow() {
        return $this->_columns;
    }
}
