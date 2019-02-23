<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace vendor\app;

/**
 * Description of Request
 *
 * @author lukasz
 */
class Request {
    
    private $_url;
    private $_queryParams;
    private $_baseUrl;
    private $_hostInfo;
    private $_hostName;



    /**
     * 
     * @return boolean
     */
    public function isPost(){
        return $this->getMethod() === 'POST';
    }
    
    /**
     * 
     * @param string $name
     * @param mixed $defaultValue
     * @return mixed
     */
    public function post($name = null, $defaultValue = NULL)
    {
        if ($name === NULL) {
            return $this->getBodyParam();
        } else {
            return $this->getBodyParam($name, $defaultValue);
        }
    }

    /**
     * @param null $name
     * @param null $defaultValue
     * @return null
     */
    public function get($name = null, $defaultValue = null){
        if ($name === null) {
            return $this->getQueryParams();
        } else {
            return $this->getQueryParam($name, $defaultValue);
        }
    }

    /**
     * @param $name
     * @param null $defaultValue
     * @return null
     */
    public function getQueryParam($name, $defaultValue = null){
        $params = $this->getQueryParams();

        return isset($params[$name]) ? $params[$name] : $defaultValue;
    }

    /**
     * @return mixed
     */
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
     * @param string|null $name
     * @param mixed $defaultValue
     * @return mixed
     */
    public function getBodyParam($name=NULL, $defaultValue = NULL){
        $params= filter_input_array(INPUT_POST);
        if($name == NULL){
            return $params;
        }else{
            return isset($params[$name]) ? $params[$name] : $defaultValue;            
        }
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        if ($this->_url === null) {
            $this->_url = $this->getBaseUrl() . $this->resolveRequestUri();
        }

        return $this->_url;
    }

    /**
     * @return mixed|string
     * @throws \Error
     */
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
            throw new \Error('Unable to determine the request URI.');
        }

        return $requestUri;
    }

    public function getBaseUrl()
    {
        if(is_null($this->_baseUrl)){
            $this->_baseUrl = $this->getHostInfo();
        }
        return $this->_baseUrl;
    }


    public function getHostInfo()
    {
        if ($this->_hostInfo === null) {
            $secure = $this->getIsSecureConnection();
            $http = $secure ? 'https' : 'http';
            if (isset($_SERVER['HTTP_HOST'])) {
                $this->_hostInfo = $http . '://' . $_SERVER['HTTP_HOST'];
            } elseif (isset($_SERVER['SERVER_NAME'])) {
                $this->_hostInfo = $http . '://' . $_SERVER['SERVER_NAME'];
                $port = $secure ? $this->getSecurePort() : $this->getPort();
                if (($port !== 80 && !$secure) || ($port !== 443 && $secure)) {
                    $this->_hostInfo .= ':' . $port;
                }
            }
        }
        return $this->_hostInfo;
    }


    /**
     * Return if the request is sent via secure channel (https).
     * @return bool if the request is sent via secure channel (https)
     */
    public function getIsSecureConnection()
    {
        return isset($_SERVER['HTTPS']) && (strcasecmp($_SERVER['HTTPS'], 'on') === 0 || $_SERVER['HTTPS'] == 1)
        || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') === 0;
    }


    private $_securePort;
    /**
     * Returns the port to use for secure requests.
     * Defaults to 443, or the port specified by the server if the current
     * request is secure.
     * @return int port number for secure requests.
     * @see setSecurePort()
     */
    public function getSecurePort()
    {
        if ($this->_securePort === null) {
            $this->_securePort = $this->getIsSecureConnection() && isset($_SERVER['SERVER_PORT']) ? (int) $_SERVER['SERVER_PORT'] : 443;
        }
        return $this->_securePort;
    }


    private $_port;
    /**
     * Returns the port to use for insecure requests.
     * Defaults to 80, or the port specified by the server if the current
     * request is insecure.
     * @return int port number for insecure requests.
     * @see setPort()
     */
    public function getPort()
    {
        if ($this->_port === null) {
            $this->_port = !$this->getIsSecureConnection() && isset($_SERVER['SERVER_PORT']) ? (int) $_SERVER['SERVER_PORT'] : 80;
        }
        return $this->_port;
    }
}
