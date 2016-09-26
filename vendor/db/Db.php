<?php

namespace db;


/**
 * Class Db
 * @package db
 * @author lukasz
 */
class Db
{
    private $_table;
    private $_columns = ['*'];
    private $_conditions = [];
    private $_limit = [NULL, NULL];
    private $_orderBy = [];

    private $_conditionVal = [];
    private $_updateData = [];
    private $_insertData = [];


    private $_action = 'SELECT';
    private $_db;
    private $_sql;
    private $_lastSql;
    private $_lastId;


    public function __construct()
    {
        $this->_db = new Database();
    }

    /**
     *
     * @return Database
     */
    protected function db()
    {
        return $this->_db;
    }

    /**
     * Prepare select sql query
     */
    private function _prepareSelect()
    {
        $sql = 'SELECT';
        $sql .= $this->_prepareColumn();
        $sql .= ' FROM ' . $this->_table;
        $sql .= $this->_prepareConditions();
        $sql .= $this->_prepareOrderBy();
        $sql .= $this->_prepareLimit();
        $this->_sql = $sql;
    }

    private function _prepareUpdate()
    {
        $sql = 'UPDATE ';
        $sql .= $this->_table;
        $sql .= ' SET ' . $this->_prepareFieldDetails();
        $sql .= $this->_prepareConditions('conditions_');
        $this->_sql = $sql;
    }

    private function _prepareDelete()
    {
        $sql = 'DELETE FROM ';
        $sql .= $this->_table;
        $sql .= $this->_prepareConditions();
        $sql .= $this->_prepareLimit();
        $this->_sql = $sql;
    }

    private function _prepareFieldDetails()
    {

        $fieldDetails = '';
        foreach ($this->_updateData as $key => $value) {
            $fieldDetails .= "`$key`=:$key,";
        }
        return rtrim($fieldDetails, ',');
    }


    /**
     *
     * @return string
     */
    private function _prepareLimit()
    {
        $limit = '';
        if(!is_null($this->_limit[0])&& !is_null($this->_limit[1])){
            $limit .= ' LIMIT ' . $this->_limit[1];
            $limit .= ', ' . $this->_limit[0];
        }
        elseif (!is_null($this->_limit[0])){
            $limit .= ' LIMIT ' . $this->_limit[0];
        }
        elseif (!is_null($this->_limit[1])){
            $limit .= ' OFFSET ' . $this->_limit[1];
        }
        return $limit;
    }

    /**
     * Reset all settings
     */
    public function reset()
    {
        $this->_table = '';
        $this->_columns = [];
        $this->_conditions = [];
        $this->_limit = [];
        $this->_orderBy = [];
        $this->_action = '';
    }

    /**
     *
     * @return string
     */
    private function _prepareOrderBy()
    {
        $order = '';
        if (count($this->_orderBy)) {
            $order .= ' ORDER BY ' . $this->_orderBy[0];
            $order .= ' ' . $this->_orderBy[1];
        }
        return $order;
    }

    /**
     * @param string $prefix
     * @return string
     */
    private function _prepareConditions($prefix = '')
    {
        $formatCon = '';
        foreach ($this->_conditions as $condition) {
            $this->_conditionVal[$condition[0]] = $condition[2];
            $formatCon .=
                ' `' . $condition[0] . '` '
                . ' ' . $condition[1]
                . ' ' . ":$prefix{$condition[0]}";
            $formatCon .= ' AND';
        }
        if (strlen($formatCon) > 1) {
            $formatCon = ' WHERE ' . substr($formatCon, 0, -3);
        }
        return $formatCon;
    }

    /**
     *
     * @return string
     */
    private function _prepareColumn()
    {
        $colsFormat = '';
        foreach ($this->_columns as $column) {
            if ($column == "*") {
                $colsFormat .= ' *,';
            } elseif (stripos($column, '(') !== false
                || stripos($column, ' ') !== false
            ) {
                $colsFormat .= " $column,";
            } else {
                $col = array_map(
                    function ($val) {
                        return "`$val`";
                    },
                    explode('.', $column)
                );
                $colsFormat .= ' ' . implode('.', $col) . ',';
            }
        }

        return rtrim($colsFormat, ',');
    }

    /**
     * Execute sql query
     * @return array
     */
    public function exec()
    {
        switch ($this->_action) {
            case 'SELECT':
                $result = $this->db()->select($this->_sql, $this->_conditionVal);
                $this->_lastId = $this->db()->lastId();
                break;
            case 'UPDATE':
                $this->_prepareUpdate();
                $result = $this->db()->updateNew(
                    $this->_sql,
                    $this->_updateData,
                    $this->_conditionVal
                );
                $this->_lastId = $this->db()->lastId();
                break;
            case 'INSERT':
                $result = $this->db()->insert($this->_table, $this->_insertData);
                $this->_lastId = $this->db()->lastId();
                break;
            case 'DELETE':
                $result = $this->db()->deleteNew($this->_sql, $this->_conditionVal);
                $this->_lastId = $this->db()->lastId();
                break;
            default:
                $result = NULL;
        }
        $this->_lastSql = $this->db()->getSql();
        return $result;
    }

    /**
     *
     * @param mixed $col
     * @return \db\Db
     */
    public function select($col)
    {
        $this->_action = 'SELECT';
        if (is_array($col)) {
            $this->_columns = $col;
        } else {
            $this->_columns = [$col];
        }
        return $this;
    }

    public function addSelect($col)
    {
        $this->_action = 'SELECT';
        if (is_array($col)) {
            $this->_columns = array_merge($this->_columns, $col);
        } else {
            array_push($this->_columns, $col);
        }
        return $this;
    }

    /**
     *
     * @param string $name
     * @return \db\Db
     */
    public function update($name)
    {
        $this->_action = 'UPDATE';
        $this->_table = $name;
        return $this;
    }

    /**
     * @param $params
     * @return $this
     */
    public function insert($params)
    {
        $this->_action = 'INSERT';
        $this->_insertData = $params;
        $this->exec();
        return $this;
    }

    /**
     * @return $this
     */
    public function delete()
    {
        $this->_action = 'DELETE';
        $this->_prepareDelete();
        $this->exec();
        return $this;
    }


    /**
     *
     * @param array $params
     * @return \db\Db
     */
    public function set($params)
    {
        $this->_updateData = $params;
        return $this;
    }

    /**
     *
     * @param string $name
     * @return \db\Db
     */
    public function from($name)
    {
        $this->_table = $name;
        return $this;
    }

    /**
     *
     * @param string $name
     * @return \db\Db
     */
    public function to($name)
    {
        $this->_table = $name;
        return $this;
    }

    /**
     *
     * @param string $col
     * @param string $sign
     * @param string|int $val
     * @return \db\Db
     */
    public function where($col, $sign, $val)
    {
        $this->_conditions = [[$col, $sign, $val]];
        return $this;
    }

    /**
     *
     * @param string $col
     * @param string $sign
     * @param string|int $val
     * @return \db\Db
     */
    public function whereAnd($col, $sign, $val)
    {
        array_push($this->_conditions, [$col, $sign, $val]);
        return $this;
    }

    /**
     *
     * @param int $limit LIMIT
     * @param int $offset OFFSET
     * @return \db\Db
     */
    public function limit($limit, $offset = NULL)
    {
        if (is_null($offset)) {
            $this->_limit[0] = $limit;
        } else {
            $this->_limit = [$limit, $offset];
        }
        return $this;
    }

    /**
     * @param int $offset
     * @return $this
     */
    public function offset($offset)
    {
        $this->_limit[1] = $offset;
        return $this;
    }

    /**
     * @param $col
     * @param string $sort
     * @return $this
     */
    public function orderBy($col, $sort = 'ASC')
    {
        $this->_orderBy = [$col, $sort];
        return $this;
    }

    /**
     * @return array
     */
    public function all()
    {
        $this->_prepareSelect();
        return $this->exec();

    }

    /**
     * @return mixed
     */
    public function one()
    {
        $this->limit(1);
        $this->_prepareSelect();
        $result = $this->exec();
        return $result[0];
    }

    /**
     * @return string
     */
    public function lastSql()
    {
        return $this->_lastSql;
    }


    /**
     * @return mixed
     */
    public function lastId()
    {
        return $this->_lastId;
    }


    public function next($id)
    {

    }
}
