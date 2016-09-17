<?php


class Bootstrap {

    private $_url = null;
    private $_controller = null;
    private $_errorController = null;    
    private $_controllerPath = 'controllers/'; // Always include trailing slash
    
    private $_renderedPage = '';
    
    /**
     * Starts the Bootstrap
     * 
     * @return boolean
     */
    public function init()
    {        
        // Sets the protected $_url
        $this->_getUrl();
        
        $controller = empty($this->_url[0]) ? 'index' : $this->_url[0];
        
        $this->_controller = $this->_loadExistingController($controller);
        $this->_errorController = $this->_loadExistingController('error');
        if($this->_controller != NULL){
            $this->_renderedPage =  $this->_callControllerMethod();            
        }
        else{
            $this->_renderedPage =  $this->_callErrorMethod(); 
        }
    }
    
    public function getRenderedPage(){
        return $this->_renderedPage;
    }

    /**
     * Fetches the $_GET from 'url'
     */
    private function _getUrl()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $this->_url = explode('/', $url);
    }
    
    
    /**
     * Load an existing controller if there IS a GET parameter passed
     * 
     * @return boolean|string
     */
    private function _loadExistingController($controler)
    {
        $file = $this->_controllerFileName($controler);        
        if (file_exists($file)) {
            require $file;
            $className = $this->_controllerName($controler);
            return new $className;
        } else {
            return NULL;
        }
    }
    
    /**
     * If a method is passed in the GET url paremter
     * 
     *  http://localhost/controller/method/(param)/(param)/(param)
     *  url[0] = Controller
     *  url[1] = Method
     *  url[2] = Param
     *  url[3] = Param
     *  url[4] = Param
     */
    private function _callControllerMethod()
    {
        $action = $this->_actionName();
        if (!method_exists($this->_controller, $action)) {
            return $this->_callErrorMethod();
        }else{
            return call_user_func_array(
                    [$this->_controller, $action], 
                    $this->_getActionParms()
                    );
        }
//        $foo = new foo;
//        call_user_func_array(array($foo, "bar"), array("three", "four"));
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
        $action = isset($this->_url[1]) ? $this->_url[1] : "index";
        $part = explode("-", $action);
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
    
    private function _getActionParms(){
        $parms = [];
        if(count($this->_url)>2){
            $parms = array_merge($parms, array_slice($this->_url, 2));
        }
        return $parms;
    }
}