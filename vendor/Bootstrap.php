<?php


class Bootstrap {

    private $_url = null;
    private $_controller = null;
    
    private $_controllerPath = 'controllers/'; // Always include trailing slash
    private $_modelPath = 'models/'; // Always include trailing slash
    private $_errorFile = 'errorController.php';
    private $_defaultFile = 'indexController.php';
    private $_defaultModel = 'index';
    
    private $_config;


    /**
     * Starts the Bootstrap
     * 
     * @return boolean
     */
    public function init($config)
    {
        $this->_config = $config;
        
        // Sets the protected $_url
        $this->_getUrl();
        
        // Load the default controller if no URL is set
        // eg: Visit http://localhost it loads Default Controller
        if (empty($this->_url[0])) {
            
            return $this->_loadDefaultController();
        }

        $this->_loadExistingController();
        return $this->_callControllerMethod();
    }
    
    /**
     * (Optional) Set a custom path to controllers
     * @param string $path
     */
    public function setControllerPath($path)
    {
        $this->_controllerPath = trim($path, '/') . '/';
    }
    
    /**
     * (Optional) Set a custom path to models
     * @param string $path
     */
    public function setModelPath($path)
    {
        $this->_modelPath = trim($path, '/') . '/';
    }
    
    /**
     * (Optional) Set a custom path to the error file
     * @param string $path Use the file name of your controller, eg: error.php
     */
    public function setErrorFile($path)
    {
        $this->_errorFile = trim($path, '/');
    }
    
    /**
     * (Optional) Set a custom path to the error file
     * @param string $path Use the file name of your controller, eg: index.php
     */
    public function setDefaultFile($path)
    {
        $this->_defaultFile = trim($path, '/');
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
     * This loads if there is no GET parameter passed
     */
    private function _loadDefaultController()
    {
        require $this->_controllerPath . $this->_defaultFile;
        $this->_controller = new IndexController();
        $this->_controller->loadConfig($this->_config);
        $this->_controller->loadModel($this->_defaultModel, $this->_modelPath);
        return $this->_controller->actionIndex();
    }
    
    /**
     * Load an existing controller if there IS a GET parameter passed
     * 
     * @return boolean|string
     */
    private function _loadExistingController()
    {
        $file = $this->_controllerFileName($this->_url[0]);
        
        if (file_exists($file)) {
            require $file;
            $className = $this->_controllerName($this->_url[0]);
            $this->_controller = new $className;
            
            $this->_controller->loadModel($this->_url[0], $this->_modelPath);
        } else {
            $this->_error();
            return false;
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
        $length = count($this->_url);
        
        // Make sure the method we are calling exists
        if ($length > 1) {
            if (!method_exists($this->_controller, $this->_actionName($this->_url[1]))) {
                return $this->_error();
            }
        }
        switch ($length) {
            case 5:
                return $this->_controller
                    ->{$this->_actionName($this->_url[1])}
                    ($this->_url[2], $this->_url[3], $this->_url[4]);                          
            case 4:
                return $this->_controller
                    ->{$this->_actionName($this->_url[1])}
                    ($this->_url[2], $this->_url[3]);  
            case 3:
                return $this->_controller
                    ->{$this->_actionName($this->_url[1])}
                    ($this->_url[2]);  
            case 2:
                return $this->_controller
                    ->{$this->_actionName($this->_url[1])}();  
            default:
                return $this->_controller
                    ->{$this->_actionName("index")}();
        }
    }
    
    /**
     * Display an error page if nothing exists
     * 
     * @return boolean
     */
    private function _error() {
        require $this->_controllerPath . $this->_errorFile;
        $this->_controller = new ErrorController();
        $this->_controller->loadModel("error", $this->_modelPath);
        $this->_controller->loadConfig($this->_config);
        $this->_controller->actionIndex();
        exit;
    }

    private function _actionName($string){
        $part = explode("-", $string);
        array_walk($part, function(&$vaulue, $key){
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