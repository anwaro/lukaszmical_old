<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app;

/**
 * Description of Request
 *
 * @author lukasz
 */
class Request {
    
    private $_url;
    private $_queryParams;




    /**
     * 
     * @return boolean
     */
    public function isPost(){
        return $this->getMethod() === 'POST';
    }
    
    /**
     * 
     * @param type $name
     * @param type $defaultValue
     * @return type
     */
    public function post($name = null, $defaultValue = NULL)
    {
        if ($name === NULL) {
            return $this->getBodyParam();
        } else {
            return $this->getBodyParam($name, $defaultValue);
        }
    }
    
    public function get($name = null, $defaultValue = null){
        if ($name === null) {
            return $this->getQueryParams();
        } else {
            return $this->getQueryParam($name, $defaultValue);
        }
    }

    public function getQueryParam($name, $defaultValue = null){
        $params = $this->getQueryParams();

        return isset($params[$name]) ? $params[$name] : $defaultValue;
    }
    
    public function getQueryParams(){
        if ($this->_queryParams === null) {
            return $_GET;
        }

        return $this->_queryParams;
    }
    
    /**
     * 
     * @return string
     */
    public function getMethod()
    {        
        if (isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'])) {
            return strtoupper($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']);
        }
        
        if (isset($_SERVER['REQUEST_METHOD'])) {
            return strtoupper($_SERVER['REQUEST_METHOD']);
        }
        
        return 'GET';
    }
    
    /**
     * 
     * @param type $name
     * @param type $defaultValue
     * @return type 
     */
    public function getBodyParam($name=NULL, $defaultValue = NULL){
        $params= filter_input_array(INPUT_POST);
        if($name == NULL){
            return $params;
        }else{
            return isset($params[$name]) ? $params[$name] : $defaultValue;            
        }
    }


    public function getUrl()
    {
        if ($this->_url === null) {
            $this->_url = $this->resolveRequestUri();
        }

        return $this->_url;
    }
    
    protected function resolveRequestUri()
    {
        if (isset($_SERVER['HTTP_X_REWRITE_URL'])) { // IIS
            $requestUri = $_SERVER['HTTP_X_REWRITE_URL'];
        } elseif (isset($_SERVER['REQUEST_URI'])) {
            $requestUri = $_SERVER['REQUEST_URI'];
            if ($requestUri !== '' && $requestUri[0] !== '/') {
                $requestUri = preg_replace('/^(http|https):\/\/[^\/]+/i', '', $requestUri);
            }
        } elseif (isset($_SERVER['ORIG_PATH_INFO'])) { // IIS 5.0 CGI
            $requestUri = $_SERVER['ORIG_PATH_INFO'];
            if (!empty($_SERVER['QUERY_STRING'])) {
                $requestUri .= '?' . $_SERVER['QUERY_STRING'];
            }
        } else {
            throw new InvalidConfigException('Unable to determine the request URI.');
        }

        return $requestUri;
    }
}
