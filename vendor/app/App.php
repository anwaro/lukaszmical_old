<?php

namespace app;

use app\Config;
use web\User;

/**
 * Description of App
 *
 * @author lukasz
 */
class App {
    private $_config;
    
    public $user;
    public $params;
    public $request;
    public $log;
    public $mailer;
    public $response;
    public $security;
    public $session;


    public function __construct($config) {
        $this->_config = new Config();
        $this->_config->loadConfig($config);
        
        $this->user = new User();
        
    }
    
    
    public function parm($path){
        return $this->_config->getParam($path);
    }
}
