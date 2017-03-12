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

    /**
     * @param \PDOStatement $sth
     * @param array $data
     * @param string $prefix
     * @return \PDOStatement
     */
    private function _bind($sth, $data, $prefix=''){
        foreach ($data as $key => $value) {
            $sth->bindValue(":$prefix"."$key", "$value");
        }
        return $sth;
    }

    /**
     * @param string $sql
     * @param array $data
     * @param string $prefix
     * @return string
     */
    private function _bindSql($sql, $data, $prefix=''){
        foreach ($data as $key => $value) {
            if(is_string($value)) $value = "'$value'";
            $sql = str_replace(":$prefix"."$key", $value, $sql);
        }
        return $sql;
    }

    /**
     * @param array $data
     * @return string
     */
    private function _fieldName($data)
    {
        $fieldNames = implode('`, `', array_keys($data));
        return "`$fieldNames`";
    }

    /**
     * @param array $data
     * @return string
     */
    private function _fieldVal($data)
    {
        return ':' . implode(', :', array_keys($data));
    }
    /**
     * @param $sql
     * @param array $array
     * @param int $fetchMode
     * @return array
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
        
        $sthDataValid = $this->_bind($sth, $data);
        $sqlDataValid = $this->_bindSql($sql, $data);
        
        $sthDataWhereValid = $this->_bind($sthDataValid, $where, 'conditions_');
        $sqlDataWhereValid = $this->_bindSql($sqlDataValid, $where, 'conditions_');
        
        $this->_lastSql = $sqlDataWhereValid;
        $sthDataWhereValid->execute();
    }  
    
    
    /**
     * insert
     * @param string $table A name of table to insert into
     * @param array $data An associative array
     */
    public function insert($table, $data)
    {
        ksort($data);

        $fieldNames = $this->_fieldName($data);
        $fieldValues = $this->_fieldVal($data);

        $sql = "INSERT INTO $table ($fieldNames) VALUES ($fieldValues)";
        $sth = $this->prepare($sql);

        $sthValid = $this->_bind($sth, $data);
        $sqlValid = $this->_bindSql($sql, $data);

        $this->_lastSql = $sqlValid;
        $sthValid->execute();
    }
    
    /**
     * update
     * @param string $table A name of table to insert into
     * @param array $data An associative array
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

        $sql = "UPDATE $table SET $fieldDetails WHERE $where";
        $sth = $this->prepare($sql);
        
        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", "$value");
            $sql = str_replace(":$key", $value, $sql);
        }
        $this->_lastSql = $sql;         
        $sth->execute();        
    }

    public function deleteNew($sql, $where)
    {
        $sth = $this->prepare($sql);

        $sthValid = $this->_bind($sth, $where);
        $sqlValid = $this->_bindSql($sql, $where);

        $this->_lastSql = $sqlValid;
        $sthValid->execute();
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
     * @return string
     */
    public function lastId() {
        return $this->lastInsertId();
    }

    public function execSql($sql){
        $sth = $this->prepare($sql);
        $sth->execute();
        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }
}