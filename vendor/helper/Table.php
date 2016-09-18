<?php

class Table {
    
    private $table;
    
    private $head='';
    
    private $body='';
    
    private $id="";
    
    private $class="";
    
            
            
    function __construct() {
        
    }
    
    public function reset() {
        $this->table = "";
        $this->body= "";
        $this->head="";
        $this->class="";
        $this->id="";        
    }
    
    public function setClass($class){
        $this->class = $class;
    }
    
    public function setId($id){
        $this->id = $id;
    }
    
    public function setHead($array, $fromValue=1){
        $this->head = "<thead> <tr>\n";
        if($fromValue){
            foreach ($array as $value) {
                $this->head.="<td> $value </td>\n";
            }            
        }else{
            foreach ($array as $key => $value) {
                $this->head.="<td> $key </td>\n";
            }
        }        
        $this->head.= "</tr>\n</thead>\n";
    }
    
    public function setBody($array) {
        if(!is_array($array[0])){
            $newArray = array($array);
        }
        else {
            $newArray = $array;
        }
        $this->body = "<tbody>\n";
        foreach ($newArray as $value) {
            $this->body.= "<tr>\n";
            foreach ($value as $val) {
                $this->body.="<td > $val </td>\n";
            }
            $this->body.= "</tr>\n";
        }
        
        $this->body.= "</tbody>\n";
    }
    
    public function getTable() {
        $this->table="<table id='$this->id' class='$this->class'>\n";
        $this->table.=$this->head;
        $this->table.=$this->body;
        $this->table.="</table>\n";
        
        return $this->table;
    }
}