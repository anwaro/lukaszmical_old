<?php

namespace vendor\db;



/**
 * Class ActiveRecord
 * @package db
 * @author lukasz
 */
class ActiveRecord extends ActiveRecordAbstract
{
    /**
     * @var array
     */
    private $_attributes = [];

    /**
     * @var string
     */
    private $_action = 'INSERT';

    /**
     * @var Db
     */
    private $_db;

    /**
     * ActiveRecord constructor.
     */
    public function __construct()
    {
        $this->_db = new Db();
    }

    /**
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        if (in_array($name, $this->getTableColumns())) {
            if(isset($this->_attributes[$name])){
                return $this->_attributes[$name];
            }
            else{
                return NULL;
            }
        } else {
            throw new \Exception("Undefined index: " . $name . " ");
        }
    }

    /**
     * @param string $name
     * @param mixed $value
     * @throws \Exception
     */
    public function __set($name, $value)
    {
        if (in_array($name, $this->getTableColumns())) {
            $this->_attributes[$name] = $value;
        } else {
            throw new \Exception("Undefined index: " . $name . " ");
        }
    }

    public function __isset($name)
    {
        return isset($this->_attributes[$name]);
    }


    /**
     * @return $this
     */
    private function _insert()
    {
        $this->_db
            ->to($this->getTableName())
            ->insert($this->_attributes);
        $id = $this->_db->lastId();
        $this->load(["id" => $id]);
        return $this;
    }

    /**
     * @return $this
     */
    private function _update()
    {
        $this->_db
            ->update($this->getTableName())
            ->set($this->_attributes)
            ->exec();
        return $this;

    }

    /**
     * @param null $col
     * @param null $sign
     * @param null $val
     * @return array
     */
    public function all($col=NULL, $sign = NULL, $val = NULL)
    {
        $query = $this->_db
            ->select('*')
            ->from($this->getTableName());
        if($sign != NULL){
            if ($sign == NULL) {
                $val = $col;
                $sign = "=";
                $col = 'id';
            }
            $query->where($col, $sign, $val);
        }

        return $query->all();
    }

    /**
     * @param string|int $col
     * @param string $sign
     * @param string|int $val
     * @return array
     */
    public function one($col, $sign = NULL, $val = NULL)
    {
        if ($sign == NULL) {
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

    /**
     * @param string|int $col
     * @param string $sign
     * @param string|int $val
     * @return $this
     */
    public function findOne($col, $sign = NULL, $val = NULL)
    {
        $this->load($this->one($col, $sign, $val));
        $this->_action = 'UPDATE';
        return $this;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function next($id)
    {
        $idNext = $this->_db
            ->select('MIN(id) as id')
            ->from($this->getTableName())
            ->where('id', '>', $id)
            ->one();
        $next = $this->_db
            ->select('*')
            ->from($this->getTableName())
            ->where('id', '=', $idNext['id'])
            ->one();
        $this->load($next);
        return $this;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function prev($id)
    {
        $idNext = $this->_db
            ->select('MAX(id) as id')
            ->from($this->getTableName())
            ->where('id', '<', $id)
            ->one();  
        
        $next = $this->_db
            ->select('*')
            ->from($this->getTableName())
            ->where('id', '=', $idNext["id"])
            ->one();
        $this->load($next);
        return $this;
    }

    /**
     * Return row count
     * @return int
     */
    public function count()
    {
        $count = $this->_db
            ->select('SUM(*) as count')
            ->from($this->getTableName())
            ->one();
        return intval($count['count']);
    }

    /**
     * @param string $col
     * @return mixed
     */
    public function min($col = 'id')
    {
        $min = $this->_db
            ->select("MIN($col) as min")
            ->from($this->getTableName())
            ->one();
        return $min['min'];
    }

    /**
     * @param string $col
     * @return mixed
     */
    public function max($col = 'id')
    {
        $max = $this->_db
            ->select("MAX($col) as max")
            ->from($this->getTableName())
            ->one();
        return $max['max'];
    }

    /**
     * @return mixed
     */
    public function randId(){
        return $this->randCol('id');
    }

    /**
     * @param string $col
     * @return mixed
     */
    public function randCol($col)
    {
        $rand = $this->_db
            ->select("$col as col")
            ->from($this->getTableName())
            ->orderBy('RAND()')
            ->one();
        return $rand['col'];
    }

    /**
     * @param array $value
     * @return $this
     */
    public function load($value)
    {
        $colsName = $this->getTableColumns();
        foreach ($value as $key => $val) {
            if (in_array($key, $colsName)) {
                $this->_attributes[$key] = $val;
            }
        }
        return $this;
    }

    /**
     * @return $this|ActiveRecord
     */
    public function save()
    {
        switch ($this->_action) {
            case 'INSERT':
                return $this->_insert();
            case 'UPDATE':
                return $this->_update();
        }
        return $this;
    }

    /**
     * @param mixed $col
     * @param string $sign
     * @param mixed $val
     * @throws \InvalidArgumentException
     * @return $this
     */
    public function delete($col = NULL, $sign = NULL, $val = NULL)
    {
        if(!is_null($val)){
            $this->_db->where($col, $sign, $val);
        }
        elseif (!is_null($col)){
            $this->_db->where('id', '=', $col);
        }
        elseif (is_null($col) && isset($this->id)){
            $this->_db->where('id', '=', $this->id);
        }
        else{
            throw new \InvalidArgumentException('Condition not set');
        }
        $this->_db->delete();
        return $this;
    }

    /**
     * @return Db
     */
    public function db()
    {
        return $this->_db;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->_attributes;
    }
}
