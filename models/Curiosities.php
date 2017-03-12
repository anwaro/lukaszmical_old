<?php

namespace models;

use db\ActiveRecord;
use db\Db;

/**
 * Description of webstuff_model
 *
 * @property integer $is
 * @property string $text
 * @property string $links
 * @property string $date
 * @author lukasz
 */
class Curiosities extends ActiveRecord {
    
    private $table;


    public function __construct($type) {
        parent::__construct();
        $this->table = strtolower($type);
    }
    
    public function getTableName(){
        return $this->table;
    }
    
    public function getTableColumns() {
        return[
            'id',
            'text',
            'links',
            'date',
        ];
    }

    public function allByDate()
    {
        $result = $this->db()
            ->from($this->getTableName())
            ->orderBy('date', 'DESC')
            ->all();
        return $result;
    }
}
