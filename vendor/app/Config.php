<?php

namespace app;

/**
 * Description of Config
 *
 * @author lukasz
 */
class Config {
    
    protected $_config;


    public function loadConfig($config) {
        $this->_config = $config;
    }
    
    public function getParam($path){
        $indexs = explode("/", $path);
        $configParm = $this->_config;
        try{
            foreach ($indexs as $index){
                $configParm = $configParm[$index];
            }
        } catch (Exception $ex) {
            throw new Exception("Undefined index in config: config[" 
                    . implode("][", $indexs) . "] in " ,$ex->getFile());
        }        
        return $configParm;
    }
    
}