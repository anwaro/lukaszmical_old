<?php
namespace models;

use db\ActiveRecord;

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
    
    public function printGlobalArray() {
        echo '$_COOKIE ';
        var_dump($_COOKIE);
        echo 'ENV ';
        var_dump($_ENV);
        echo '$_FILES ';
        var_dump($_FILES);
        echo '$_REQUEST ';
        var_dump($_REQUEST);
        echo '$_SERVER ';
        var_dump($_SERVER);
        echo '$_SESSION ';
        var_dump($_SESSION);
    }
    
    function size(){
        return  intval((disk_total_space (getcwd())/1024)/1024/1024);
    }
    
}
