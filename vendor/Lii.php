<?php


use app\App;

/**
 * Description of App
 *
 * @author lukasz
 */
class Lii {
    public static $app = NULL;
    
    public static function loadCofig($config) {
        self::$app = new App($config);
    }
    
}
