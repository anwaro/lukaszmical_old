<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace vendor\app;

use vendor\Lii;

/**
 * Description of Url
 *
 * @author lukasz
 */
class Url {
    
    private $_url;


    public function __construct($url) {
        $this->_url = parse_url($url);       
    }
    
    /**
     * Return decoded url
     * E.g. 
     * 
     * example.com%3Fpath%3Dadmin%2Flogin
     * 
     * --> example.com?path=admin/login
     * 
     * 
     * @param string $url Url to decode
     * @return string decoded url
     */
    public function decode($url=NULL) {
        if($url == NULL){
            $url = Lii::$app->request->getUrl();
        }
        return urldecode($url);
    }
    
    /**
     * Return encoded url
     * E.g. 
     * 
     * example.com?path=admin/login
     * 
     * --> example.com%3Fpath%3Dadmin%2Flogin
     * 
     * 
     * @param string $url Url to encode
     * @return string encoded url
     */
    public function encode($url = NULL){
        if($url == NULL){
            $url = Lii::$app->request->getUrl();
        }
        return urlencode($url);
    }

    public function getBaseUrl()
    {
        return $this->getScheme() . "://" . $this->getHost() . "/";
    }
    
    public function getScheme() {
        return $this->_url["scheme"];
    }
    
    public function getHost() {
        return $this->_url["host"];
    }
    
    public function getUser() {
        return $this->_url["user"];
    }
    
    public function getPass() {
        return $this->_url["pass"];
    }
    
    public function getPath() {
        return $this->_url["path"];
    }
    
    public function getPathArray() {
        $path = explode('/', $this->getPath());
        $pathElem = array_filter($path, function($val){return $val !== '';});
        return array_values($pathElem);
    }
    
    public function getQuery() {
        return $this->_url["query"];
    }
    
    public function getFragment() {
        return $this->_url["fragment"];
    }
    
    /**
     * Create url
     *  
     *  create('http://example.com', 'admin/login', ['id'=1, path='admin/login], 'top')
     *  |
     *  '--> http://example.com/admin/login?id=1&path=admin%2login#top
     * 
     * @param string $base
     * @param string $path
     * @param array $query
     * @param string $frag
     * @return string
     */
    public function create($base, $path=NULL, $query=[], $frag = NULL) {
        $url = rtrim($base, '/') . '/';
        
        if($path !== NULL){
            $url .= rtrim(ltrim($path, '/'), '/') . '/';
        }
        if(count($query)){
            $urlQuery = '?';
            foreach ($query as $key => $value) {
                $urlQuery .= $key . '=' . $this->encode($value);
                $urlQuery .= '&';
            }
            $url .= rtrim($urlQuery, '&');
        }
        if($frag !== NULL){
            $url .= '#' . $frag;
        }
        return $url;
    }
}
