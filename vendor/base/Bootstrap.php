<?php

namespace base;

use Lii;

class Bootstrap {

    private $_controller = null;
    private $_errorController = null;    
    private $_controllerPath = 'controllers/'; // Always include trailing slash
    
    private $_renderedPage = '';
    
    private $controllerName = 'index';
    private $actionName = 'index';
    private $actionParms = [];


    /**
     * Starts the Bootstrap
     * 
     * @return boolean
     */
    public function init()
    {        
        $this->_parseUrl();       
        
        $this->_controller = $this->_loadExistingController($this->controllerName);
        $this->_errorController = $this->_loadExistingController('error');
        
        if($this->_controller != NULL){
            
            $this->_controller->before($this->_actionName());
            $this->_renderedPage =  $this->_callControllerMethod();            
        }
        else{
            $this->_controller->before($this->_actionName());
            $this->_renderedPage =  $this->_callErrorMethod(); 
        }
    }
    
    public function getRenderedPage(){
        return $this->_renderedPage;
    }

    private function _parseUrl(){        
        $path = Lii::$app->url->getPathArray();
        
        if(isset($path[0])){
            $this->controllerName = $path[0];
        }
        if(isset($path[1])){
            $this->actionName = $path[1];
        }
        if(count($path) > 2){
            $this->actionParms = array_slice($path, 2);
        }       
        
    }
    
    
    /**
     * Load an existing controller if there IS a GET parameter passed
     * 
     * @return boolean|string
     */
    private function _loadExistingController($controllerName)
    {
        $file = $this->_controllerFileName($controllerName); 
        if (file_exists($file)) {
            require $file;
            $className = $this->_controllerName($controllerName);
            return new $className;
        } else {
            return NULL;
        }
    }
    
    /**
     * 
     *  http://localhost/controller/method/(param)/(param)/(param)
     */
    private function _callControllerMethod()
    {
        $action = $this->_actionName();
        if (!method_exists($this->_controller, $action)) {
            return $this->_callErrorMethod();
        }else{
            return call_user_func_array(
                    [$this->_controller, $action], 
                    $this->actionParms
                    );
        }
    }
    
    /**
     * Display an error page if nothing exists
     * 
     * @return boolean
     */
    private function _callErrorMethod() {        
        return $this->_errorController->actionIndex();        
    }

    private function _actionName(){        
        $part = explode("-", $this->actionName);
        array_walk($part, function(&$vaulue){
            $vaulue = ucfirst($vaulue);
        });
        return "action" . implode($part);
    }
    
    private function _controllerName($string){
        return 'app\controllers\\' . ucfirst($string) . 'Controller';
    }
    
    private function _controllerFileName($string){
        return $this->_controllerPath . ucfirst($string) . 'Controller.php';
    }
}