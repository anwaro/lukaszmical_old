<?php
namespace models;

use vendor\db\ActiveRecord;

class Admin extends ActiveRecord {

    public function getTableName() {
        return 'user';
    }
    
    public function getTableColumns() {
        return [
            "id",
            "name",
            "password",
            "role",
        ];
    }
    
    public function getGlobalArray() {
        $data = [];
        $data["Cookie"] = $_COOKIE;
        $data["Env"] = $_ENV;
        $data["Files"] = $_FILES;
        $data["Request"] = $_REQUEST;
        $data["Server"] = $_SERVER;
        $data["Session"] = $_SESSION;
        return $data;
    }
    
    function size(){
        return  intval((disk_total_space(getcwd())/1024)/1024/1024);
    }
    
}
