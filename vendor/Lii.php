<?php


use app\App;

/**
 * Description of App
 * @property app\App $app 
 * 
 * @author lukasz
 */
class Lii {
    public static $app = NULL;
    
    public static function loadCofig($config) {
        self::$app = new App($config);
    }
    
    public static function parm($path){
        return self::$app->parm($path);
    }
    
}
