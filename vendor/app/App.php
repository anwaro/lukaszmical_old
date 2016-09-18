<?php

namespace app;

/**
 * Class App
 * @package app
 * @author lukasz
 */
class App {
    /**
     * @var Config $_config
     */
    private $_config;
    
    /**
     * @var User $user  
     */
    public $user;
    
    /**
     * @var Request $request
     */
    public $request;

//    /**
//     * @var Log $log
//     */
//    public $log;
//    /**
//     * @var type
//     */
//    public $mailer;
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
    /**
     * @var Url $url
     */
    public $url;

    /**
     * App constructor.
     * @param array $config
     */
    public function __construct($config) {
        $this->setVar();
        
        $this->session->init();        
        $this->_config->loadConfig($config);
    }

    /**
     *
     */
    private function setVar(){
        $this->_config = new Config();        
        $this->user = new User();
        $this->request = new Request();
        $this->session = new Session();
        $this->response = new Response();
        $this->security = new Security();
        $this->url = new Url($this->request->getUrl());
        
    }


    /**
     * @param $path
     * @return mixed
     */
    public function params($path){
        return $this->_config->getParams($path);
    }
}
