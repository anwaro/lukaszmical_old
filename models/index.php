<?php

class Index_Model extends Model {
    
    public function index() {
        
    }
    
    public function getBestProjects() {
        $sth = $this->db()->select("SELECT * FROM " . "projects" . " WHERE display = 1 ORDER BY mark DESC LIMIT 6");
        return $sth;
    }
}
