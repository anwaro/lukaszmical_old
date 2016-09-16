<?php

namespace models;

use base\Model;
use db\Db;

/**
 * Description of webstuff_model
 *
 * @author lukasz
 */
class Webstuff extends Model {
    
    public function getAll() {
        return (new Db())->select('*')
                ->from('webstuff')
                ->orderBy('id', 'DESC')
                ->all();
        
        //return $this->db()->select("SELECT * FROM webstuff ORDER BY id DESC");
    }
    
    public function getOne($id) {
        return $this->db()->selectOne("SELECT * FROM webstuff WHERE id = :id", [":id"=>intval($id)]);
        
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
