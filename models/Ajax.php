<?php

class Ajax_Model extends Model {

    function __construct() {
        parent::__construct();
    }
    
    
    function getStudent(){
        $data = 'HTTP method GET is not supported by this URL';
        if($this->is_post('byname')){
            $data = $this->db()->select("SELECT * FROM student " .
                    " WHERE UPCASE(name) LIKE UPCASE(%:name%) LIMIT 10", array(':name' => $this->post('name')),
                    PDO::FETCH_NUM);
        }
        if($this->is_post('byindex')){
            $data = $this->db()->select("SELECT * FROM student "  .
                    " WHERE index_nr = :index_nr", array(':index_nr' => $this->post('index')),
                    PDO::FETCH_NUM);
        }
        return json_encode($data);
    }
}