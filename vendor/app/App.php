<?php

namespace vendor\app;

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
     * @var int $_analiseId
     */
    private $_analiseId;
    
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
        $config['url'] = $this->url->getBaseUrl();
        $this->_config->loadConfig($config);
        $this->setTimeZone();
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

    public function setTimeZone(){
        date_default_timezone_set ("Europe/Warsaw");
    }

    public function setAnaliseId($id){
        $this->_analiseId = $id;
    }

    public function getAnaliseId(){
        return $this->_analiseId;
    }
}
