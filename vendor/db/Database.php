<?php

namespace db;

use Lii;

class Database extends \PDO
{
    private $_lastSql = '';


    public function __construct()
    {
        $db = Lii::params("db");
        try{
            parent::__construct(
                    $db["type"].':host='.$db["host"].';dbname='.$db["name"], 
                    $db["user"], 
                    $db["pass"],
                    array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            
        }  catch (\PDOException $e){
            echo "Page can't connect with database <br>"
            . "Please reload page " . $e->getMessage();
            exit();
        }
    }
    
    public function getSql() {
        return $this->_lastSql;
    }
    
    private function _bind($sth, $data, $prfix=''){        
        foreach ($data as $key => $value) {
            $sth->bindValue(":$prfix"."$key", "$value");
        }
        return $sth;
    }
    
    private function _bindSql($sql, $data, $prfix=''){        
        foreach ($data as $key => $value) {
            $sql = str_replace(":$prfix"."$key", $value, $sql);
        }
        return $sql;
    }

    /**
     * select
     * @param string $sql An SQL string
     * @param array $array Paramters to bind
     * @param constant $fetchMode A \PDO Fetch mode
     * @return mixed
     */
    public function select($sql, $array = [], $fetchMode = \PDO::FETCH_ASSOC)
    {
        $sth = $this->prepare($sql);
        foreach ($array as $key => $value) {
            $sth->bindValue("$key", $value);
            $sql =  str_replace(":$key", $value, $sql);
        }
        
        $sth->execute(); 
        
        $this->_lastSql = $sql;                
        return $sth->fetchAll($fetchMode);
    } 
    
    /**
     * update
     * @param string $sql A name of table to insert into
     * @param string $data An associative array
     * @param string $where the WHERE query part
     */
    public function updateNew($sql, $data, $where)
    {              
        $sth = $this->prepare($sql);
        
        $sthData = $this->_bind($sth, $data);
        $sqlData = $this->_bindSql($sql, $data);
        
        $sthDataWhere = $this->_bind($sthData, $where, 'conditions_');
        $sqlDataWhere = $this->_bindSql($sqlData, $where, 'conditions_');  
        
        $this->_lastSql = $sqlDataWhere;         
        $sthDataWhere->execute();        
    }  
    
    
    /**
     * insert
     * @param string $table A name of table to insert into
     * @param string $data An associative array
     */
    public function insert($table, $data)
    {
        ksort($data);
        
        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = ':' . implode(', :', array_keys($data));
        
        $sth = $this->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");
        $sql = "INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)";
        
        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
            $sql = str_replace(":$key", $value, $sql);
        }
        
        $this->_lastSql = $sql; 
        
        $sth->execute();
    }
    
    /**
     * update
     * @param string $table A name of table to insert into
     * @param string $data An associative array
     * @param string $where the WHERE query part
     */
    public function update($table, $data, $where)
    {
        ksort($data);
        
        $fieldDetails = NULL;
        foreach($data as $key=> $value) {
            $fieldDetails .= "`$key`=:$key,";
        }
        $fieldDetails = rtrim($fieldDetails, ',');        
        
        $sth = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");
        $sql = "UPDATE $table SET $fieldDetails WHERE $condition";
        
        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", "$value");
            $sql = str_replace(":$key", $value, $sql);
        }
        $this->_lastSql = $sql;         
        $sth->execute();        
    }
    
    /**
     * delete
     * 
     * @param string $table
     * @param string $where
     * @param integer $limit
     * @return integer Affected Rows
     */
    public function delete($table, $where, $limit = 1)
    {
        
        $this->_lastSql = "DELETE FROM $table WHERE $where LIMIT $limit"; 
        return $this->exec("DELETE FROM $table WHERE $where LIMIT $limit");
    }
    
    /**
     * 
     * @return type
     */
    public function lastId() {
        return $this->lastInsertId();
    }
    
}