<?php

namespace db;

use Lii;

class Database extends \PDO
{
    private $_lastSql = '';


    public function __construct()
    {
        $type = Lii::$app->parm("db/type");
        $host = Lii::$app->parm("db/host");
        $name = Lii::$app->parm("db/name");
        $user = Lii::$app->parm("db/user");
        $pass = Lii::$app->parm("db/pass");
        try{
            parent::__construct(
                    $type.':host='.$host.';dbname='.$name, 
                    $user, 
                    $pass,
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
     * select
     * @param string $sql An SQL string
     * @param array $array Paramters to bind
     * @param constant $fetchMode A \PDO Fetch mode
     * @return mixed
     */
    public function selectOne($sql, $array = [], $fetchMode = \PDO::FETCH_ASSOC)
    {
        $all = $this->select($sql, $array, $fetchMode);
        
        return $all?$all[0]:[];
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
        $str = "UPDATE $table SET $fieldDetails WHERE $where";
        
        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", "$value");
            $str = str_replace(":$key", $value, $str);
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