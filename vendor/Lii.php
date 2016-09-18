<?php


use app\App;

/**
 * Description of App
 * 
 * @author lukasz
 */
class Lii {
    /**
     * @var app\App
     */
    public static $app;
    
    public static function loadConfig($config) {
        self::$app = new App($config);

    }
    
    public static function params($path){
        return self::$app->params($path);
    }
    
}
