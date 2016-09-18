<?php

namespace models;

use db\ActiveRecord;
use db\Db;

/**
 * Description of webstuff_model
 *
 * @author lukasz
 */
class Webstuff extends ActiveRecord {
    
    public function getTableName(){
        return 'webstuff';
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
    
    public function add() {
        $this->db()->insert("webstuff", [
            "text" => $this->post("webstuff-text"),
            "links" => $this->post("webstuff-links"),
            "date" => date("Y-m-d"),
        ]);
        return $this->db()->lastId();
    }
    
    public function edit($id) {
        $this->db()->update("webstuff", [
            "text" => $this->post("webstuff-text"),
            "links" => $this->post("webstuff-links"),
            "date" => $this->post("webstuff-date"),
        ],
        "id=". intval($id));
    }
}
