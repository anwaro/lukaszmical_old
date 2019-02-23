<?php

namespace vendor\app;

/**
 * Class Config
 * @package app
 * @author lukasz
 */
class Config {

    /**
     * @var array
     */
    protected $_config;

    /**
     * @param array $config
     */
    public function loadConfig($config) {
        $this->_config = $config;
    }

    /**
     * @param string $path
     * @return array|mixed
     * @throws \Exception
     */
    public function getParams($path){
        $indexes = explode("/", $path);
        $configParams = $this->_config;
        try{
            foreach ($indexes as $index){
                $configParams = $configParams[$index];
            }
        } catch (\Exception $ex) {
            throw new \Exception("Undefined index in config: config[" 
                    . implode("][", $indexes) . "] in " ,$ex->getFile());
        }        
        return $configParams;
    }
}