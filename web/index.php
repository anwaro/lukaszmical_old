<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * @param $severity
 * @param $message
 * @param $file
 * @param $line
 *
 * @throws ErrorException
 */
function exception_error_handler($severity, $message, $file, $line)
{
    throw new ErrorException($message, 0, $severity, $file, $line);
}

set_error_handler("exception_error_handler");

/**
 * @param $class
 *
 * @return bool
 */
function __autoload($class)
{
    $classFile = str_replace('\\', '/', $class . ".php");
    $appClass  = "../$classFile";
    if (file_exists($appClass)) {
        include $appClass;
        return true;
    }
    return false;
}


use vendor\base\Bootstrap;
use vendor\Lii;

//try {
    $config = require(__DIR__ . '/../config/web.php');


    Lii::loadConfig($config);

    $bootstrap = new Bootstrap();


    echo $bootstrap->init();
//} catch (Exception $ex) {
//    var_dump($ex);
////    echo (new helper\PrintException($ex))->register();
//}

