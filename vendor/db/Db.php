<?php

namespace db;

use db\Database;

/**
 * Description of Db
 *
 * @author lukasz
 */
class Db{
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
    private $_lastId;

    public function __construct() {
        $this->_db = new Database();
    }
    
    /**
     * 
     * @return db\Database
     */
    private function db(){
        return $this->_db;
    }
    
    /**
     * Prepare select sql query
     */
    private function _prepareSelect(){
        $sql = 'SELECT';
        $sql .= $this->_prepareColumn();
        $sql .= ' FROM ' . $this->_table;
        $sql .= $this->_prepareConditions();
        $sql .= $this->_prepareOrderBy();
        $sql .= $this->_prepareLimit();
        $this->_sql = $sql;
    }
    
    /**
     * 
     * @return string
     */
    private function _prepareLimit(){
        $limit = '';
        if(count($this->_limit)){
            $limit .= ' LIMIT ' . $this->_limit[0];
            $limit .= ', ' . $this->_limit[1];
        }
        return $limit;
    }
    
    /**
     * Reset all settings
     */
    public function reset(){
        $this->_table = '';
        $this->_columns = [];
        $this->_conditions = [];
        $this->_limit = [];
        $this->_orderBy = [];
        $this->_offSet = '';
        $this->_action = '';
    }
    
    /**
     * 
     * @return string
     */
    private function _prepareOrderBy(){
        $order = '';
        if(count($this->_orderBy)){
            $order .= ' ORDER BY ' . $this->_orderBy[0];
            $order .= ' ' . $this->_orderBy[1];
        }
        return $order;
    }

    /**
     * 
     * @return type
     */
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
            $formatCon = ' WHERE ' . substr($formatCon, 0, -3);
        }
        return $formatCon;
    }
    
    /**
     * 
     * @return type
     */
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

    /**
     * Execute sql query
     * @return type
     */
    public function exec() {
        $db = $this->db();
        switch ($this->_action) {
            case 'SELECT':
                $result = $db->select($this->_sql, $this->_conditionVal);
                $this->_lastId = $db->lastId();
                break;
            case 'UPDATE':
                $result = $db->update($this->_sql, $this->_updateVal);
                $this->_lastId = $db->lastId();
                break;
            case 'INSERT':
                $result = $db->insert($this->_sql, $this->_insertVal);
                $this->_lastId = $db->lastId();
                break;
            case 'DELETE':
                $result = $db->select($this->_sql);
                $this->_lastId = $db->lastId();
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
    
    /**
     * 
     * @param type $name
     * @return \db\Db
     */
    public function update($name){
        $this->_action = 'UPDATE';
        $this->_table = $name;
        return $this;        
    }
    
    /**
     * 
     * @param type $params
     */
    public function insert($params) {
        $this->_action = 'INSERT';
        $this->_insertVal = $params;
        $this->exec();

    }
    
    /**
     * 
     * @param type $params
     * @return \db\Db
     */
    public function set($params) {
        $this->_updateVal = $params;
        return $this;
    }

    /**
     * 
     * @param type $name
     * @return \db\Db
     */
    public function from($name) {
        $this->_table = $name;
        return $this;
    }
   
    /**
     * 
     * @param type $col
     * @param type $sign
     * @param type $val
     * @return \db\Db
     */
    public function where($col, $sign, $val) {
        $this->_conditions = [[$col, $sign, $val]];
        return $this;
    }
    
    /**
     * 
     * @param type $col
     * @param type $sign
     * @param type $val
     * @return \db\Db
     */
    public function whereAnd($col, $sign, $val) {
        array_push($this->_conditions, [$col, $sign, $val]);
        return $this;
    }
    
    /**
     * 
     * @param type $limit1
     * @param type $limit2
     * @return \db\Db
     */
    public function limit($limit1, $limit2 = NULL) {
        if($limit2 ==NULL){
            $this->_limit = [0, $limit1];
        }  else {
            $this->_limit = [$limit1, $limit2];
        }
        return $this;
    }
    
    /**
     * 
     * @param type $col
     * @param type $sort
     * @return \db\Db
     */
    public function orderBy($col, $sort = 'ASC') {
        $this->_orderBy = [$col, $sort];
        return $this;
    }
    
    /**
     * 
     * @param type $val
     * @return \db\Db
     */
    public function offSet($val) {
        $this->_offSet = $val;
        return $this;
    }
    
    /**
     * 
     * @return type
     */
    public function all() {
        $this->_prepareSelect();
        return $this->exec();
        
    }
    
    /**
     * 
     * @return type
     */
    public function one() {
        $this->_limit = [0, 1];
        $this->_prepareSelect();
        $result = $this->exec();
        return $result[0];
    }
    
    /**
     * Return last sql query
     * @return type
     */
    public function lastSql() {
        return $this->_lastSql;
    }
    
    
    /**
     * 
     * @return type
     */
    public function lastId(){
        return $this->_lastId;
    }
    
}
