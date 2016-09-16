<?php
namespace base;


class Controller extends View {

    
    
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