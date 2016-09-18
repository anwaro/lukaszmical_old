<?php

namespace base;

use Lii;

class Bootstrap {
    /**
     * @var Controller
     */
    private $_controller;
    /**
     * @var Controller
     */
    private $_errorController;

    /**
     * @var string
     */
    private $_controllerPath = 'controllers/'; // Always include trailing slash

    /**
     * @var string
     */
    private $_renderedPage = '';

    /**
     * @var string
     */
    private $controllerName = 'index';

    /**
     * @var string
     */
    private $actionName = 'index';

    /**
     * @var array
     */
    private $actionParams = [];


    /**
     * Starts the Bootstrap
     *
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
            $this->_errorController->before($this->_actionName());
            $this->_renderedPage =  $this->_callErrorMethod(); 
        }
    }

    /**
     * @return string
     */
    public function getRenderedPage(){
        return $this->_renderedPage;
    }

    /**
     *
     */
    private function _parseUrl(){        
        $path = Lii::$app->url->getPathArray();
        
        if(isset($path[0])){
            $this->controllerName = $path[0];
        }
        if(isset($path[1])){
            $this->actionName = $path[1];
        }
        if(count($path) > 2){
            $this->actionParams = array_slice($path, 2);
        }       
        
    }


    /**
     * Load an existing controller if there IS a GET parameter passed
     *
     * @param $controllerName
     * @return null|Controller
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
     * @return bool|mixed
     */
    private function _callControllerMethod()
    {
        $action = $this->_actionName();
        if (!method_exists($this->_controller, $action)) {
            return $this->_callErrorMethod();
        }else{
            return call_user_func_array(
                    [$this->_controller, $action], 
                    $this->actionParams
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

    /**
     * @return string
     */
    private function _actionName(){        
        $part = explode("-", $this->actionName);
        array_walk($part, function(&$value){
            $value = ucfirst($value);
        });
        return "action" . implode($part);
    }

    /**
     * @param string $string
     * @return string
     */
    private function _controllerName($string){
        return 'app\controllers\\' . ucfirst($string) . 'Controller';
    }

    /**
     * @param string $string
     * @return string
     */
    private function _controllerFileName($string){
        return $this->_controllerPath . ucfirst($string) . 'Controller.php';
    }
}