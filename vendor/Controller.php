<?php

class Controller extends Config {

    function __construct() {
        //echo 'Main controller<br />';
        $this->view = new View();
        
    }
    
    public function loadConfig($config) {        
        parent::loadConfig($config);
        $this->view->loadConfig($config);
        
    }


    
    /**
     * 
     * @param string $name Name of the model
     * @param string $modelPath Location of the models
     */
    public function loadModel($name, $modelPath = 'models/') {
        
        $path = $modelPath . $name.'.php';
        
        if (file_exists($path)) {
            require $modelPath .$name.'.php';
            
            $modelName = $name . '_Model';
            $this->model = new $modelName();
            $this->model->loadConfig($this->_config);
        }        
    }

}