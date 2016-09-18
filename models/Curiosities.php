<?php

namespace models;

use db\ActiveRecord;
use db\Db;

/**
 * Description of webstuff_model
 *
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

    public function remove($id) {
        return $this->db()->delete("webstuff", "id=". intval($id));
    }
}
