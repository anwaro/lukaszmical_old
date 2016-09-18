<?php 

function __autoload($class) {
    $classFile = str_replace('\\', '/' ,$class .".php");    
    $vendor = "vendor/" . $classFile;
    
    if(file_exists($classFile)){
        include_once $classFile;
        return true;
    }
    elseif(file_exists($vendor)){
        include_once $vendor;
        return true;
    }
}

$config = require(__DIR__ . '/config/web.php');


Lii::loadCofig($config);

use base\Bootstrap;
$bootstrap = new Bootstrap();



//try{
    $bootstrap->init($config); 
    echo $bootstrap->getRenderedPage();
//} catch (Exception $ex) {
 //   echo (new helper\PrintException($ex))->register();
//}

