<?php


class Date {

    function __construct() {        
        
    }
    
    public static function getDate() {
        return date("Y-m-d");
    }
    
    public static function getDateTime() {
        return date("Y-m-d h:i");
    }
    
    public static function getTime() {
        return date("h:i");
    }
    

}