<?php 

function __autoload($class) {
    $classFile = str_replace('\\', '/' ,$class .".php");    
    $vendor = "vendor/" . $classFile;
    
    if(file_exists($classFile)){
        require $classFile;
        return true;
    }
    elseif(file_exists($vendor)){
        require $vendor;
        return true;
    }
}

//require 'config/config.php';


Session::init();

$config = require(__DIR__ . '/config/web.php');

$bootstrap = new Bootstrap();

Lii::loadCofig($config);


echo $bootstrap->init($config);
