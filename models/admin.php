<?php

class Admin_Model extends Model {

    
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
    
    public function getList() {
        $query = $this->db()->select("SELECT name, url, photo, display FROM projects" );
        return $query;
    }
    
    public function getInfo($name) {
        $query = $this->db()->select("SELECT * FROM projects WHERE url = :name", array(":name"=>$name));
        return $query[0];
    }
    
    public function deleteProject($name) {
        //$this->db()->delete("projects", "url = ".$name);
        return "Projekt o nazwie $name został usunięty";
    }
    
    public function update($name) {
        if($this->is_post("edit")){
            $this->db()->update("projects",array(
                "url"=>  $this->post("url"),
                "name"=>  $this->post("name"),
                "descr"=>  $this->post("descr"),
                "photo"=>  $this->post("photo"),
                "css"=>  $this->post("css"),
                "js"=>  $this->post("js"),
                "date"=>  $this->post("date"),
                "display"=>  $this->post("display"),
                "template"=>  $this->post("template")
            ),"`url`='".$name."'");
        }
    }  
    
    public function add() {
        if($this->is_post("add_new")){
            $this->db()->insert("projects",array(
                "name"=>  $this->post("name"),
                "url"=>  $this->post("url"),
                "descr"=>  $this->post("descr"),
                "photo"=>  $this->post("photo"),
                "css"=>  $this->post("css"),
                "js"=>  $this->post("js"),
                "date"=>  $this->post("date"),
                "date"=>  Date::getDate(),
                "template"=>  $this->post("template"),
                "display"=>  0
            ));
            return true;
        }
        return false;
    }
    
    public function prUrl() {
        
        if($this->is_post("url")){
            return $this->post("url");
        }
        return '';
    }
    
    
    
    function size(){
        return  intval((disk_total_space (getcwd())/1024)/1024/1024);
    }
    
}
