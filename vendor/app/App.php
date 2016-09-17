<?php

namespace app;

use app\Config;
use app\Session;
use app\Request;
use app\Response;
use app\Security;
use web\User;

/**
 * Description of App
 *
 * @author lukasz
 */
class App {
    private $_config;
    
    /**
     * @var User $user  
     */
    public $user;
    
    /**
     * @var Request $request
     */
    public $request;
    /**
     * @var Log $log
     */
    public $log;
    /**
     * @var type 
     */
    public $mailer;
    /**
     * @var Response $response
     */
    public $response;
    /**
     * @var  Security $security
     */
    public $security;
    /**
     * @var Session $session
     */
    public $session;


    public function __construct($config) {
        $this->_config = new Config();
        $this->_config->loadConfig($config);
        
        $this->user = new User();
        $this->request = new Request();
        $this->session = new Session();
        $this->response = new Response();
        $this->security = new Security();
        
    }
    
    
    public function parm($path){
        return $this->_config->getParam($path);
    }
}
