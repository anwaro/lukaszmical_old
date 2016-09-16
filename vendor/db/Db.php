<?php

namespace db;

use db\Database;

/**
 * Description of Db
 *
 * @author lukasz
 */
class Db/* extends Database*/{
    private $_table;
    private $_columns = [];
    private $_conditions = [];
    private $_limit = [];
    private $_orderBy = [];
    private $_offSet;
    
    private $_conditionVal =[];
    private $_updateVal = [];
    private $_insertVal = [];


    private $_action = '';
    private $_db = '';
    private $_sql = '';
    private $_lastSql = '';

    private function db(){
        if(!$this->_db instanceof Database){
            $this->_db = new Database();
        }
        return $this->_db;
    }

    private function _prepareSelect(){
        $sql = 'SELECT';
        $sql .= $this->_prepareColumn();
        $sql .= ' FROM ' . $this->_table;
        $sql .= $this->_prepareConditions();
        $sql .= $this->_prepareOrderBy();
        $sql .= $this->_prepareLimit();
        $this->_sql = $sql;
    }
    
    private function _prepareLimit(){
        $limit = '';
        if(count($this->_limit)){
            $limit .= ' LIMIT ' . $this->_limit[0];
            $limit .= ', ' . $this->_limit[1];
        }
        return $limit;
    }

    public function reset(){
        $this->_table = '';
        $this->_columns = [];
        $this->_conditions = [];
        $this->_limit = [];
        $this->_orderBy = [];
        $this->_offSet = '';
        $this->_action = '';
    }
    
    private function _prepareOrderBy(){
        $order = '';
        if(count($this->_orderBy)){
            $order .= ' ORDER BY ' . $this->_orderBy[0];
            $order .= ' ' . $this->_orderBy[1];
        }
        return $order;
    }


    private function _prepareConditions(){
        $formatCon = '';
        foreach ($this->_conditions as $condition){
            $this->_conditionVal[$condition[0]] = $condition[2];
            $formatCon .= 
                      ' ' . $condition[0] 
                    . ' ' . $condition[1] 
                    . ' ' . ":{$condition[0]}"; 
            $formatCon .= ' AND';
        }
        if(strlen($formatCon) > 1){
            $formatCon = substr($formatCon, 0, -3);
        }
        return $formatCon;
    }

    private function _prepareColumn(){
        $colsFormat = '';
        foreach ($this->_columns as $column) {
            if($column == "*"){
                $colsFormat .= ' *,'; 
            }else{
                $col = array_map(
                        function($val){return"`$val`";}, 
                        explode('.', $column)
                    );              
                $colsFormat .= ' ' . implode('.', $col) . ','; 
                
            }               
        }
        
        return rtrim($colsFormat, ',');
    }

    public function exec() {
        $db = $this->db();
        switch ($this->_action) {
            case 'SELECT':
                $result = $db->select($this->_sql, $this->_conditionVal);
                break;
            case 'UPDATE':
                $result = $db->select($this->_sql, $this->_updateVal);
                break;
            case 'INSERT':
                $result = $db->select($this->_sql, $this->_insertVal);
                break;
            case 'DELETE':
                $result = $db->select($this->_sql);
                break;

            default:
                break;
        }
        
        $this->_lastSql = $db->getSql();
        return $result;
    }

    /**
     * 
     * @param mixed $col 
     * @return \db\Db
     */
    public function select($col) {
        $this->_action = 'SELECT';
        if(is_array($col)){
            $this->_columns = $col;
        }
        else{
            $this->_columns = [$col];
        }
        return $this;
    }
    
    public function update($name){
        $this->_action = 'UPDATE';
        $this->_table = $name;
        return $this;        
    }
    
    
    public function insert($params) {
        $this->_action = 'INSERT';

    }
    
    public function set($params) {
        
    }


    public function from($name) {
        $this->_table = $name;
        return $this;
    }
    
    public function where($col, $sign, $val) {
        $this->_conditions = [[$col, $sign, $val]];
        return $this;
    }
    
    public function whereAnd($col, $sign, $val) {
        array_push($this->_conditions, [$col, $sign, $val]);
        return $this;
    }
    
    public function limit($limit1, $limit2 = NULL) {
        if($limit2 ==NULL){
            $this->_limit = [0, $limit1];
        }  else {
            $this->_limit = [$limit1, $limit2];
        }
        return $this;
    }
    
    public function orderBy($col, $sort = 'ASC') {
        $this->_orderBy = [$col, $sort];
        return $this;
    }
    
    public function offSet($val) {
        $this->_offSet = $val;
    }
    
    public function all() {
        return $this->_prepareSelect();
        
    }
    
    public function one() {
        $this->_limit = [0, 1];
        return $this->_prepareSelect();
    }
    
    public function lastSql() {
        return $this->_lastSql;
    }
    
}
