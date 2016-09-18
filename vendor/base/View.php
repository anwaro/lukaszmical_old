<?php
namespace base;

use Lii;

class View{
    
    protected $_template = '';

    public $components = array(
        "js" => "",
        "title" => "Witam na mojej stronie",
        "meta" => "",
        "content" => "",
        "css" => "",       
        "url" => "",
        "fullurl"=> "",
        "image" => "public/images/stat/logo256.jpg",
        "descr" => "Małe projekty wykonane w js, html5, css"
    );
    /**
     * 
     * @param type $name
     * @param type $value
     */  
    public function __set($name, $value) {
        $this->components[$name] = $value;
    }
    
    /**
     * 
     * @param type $name
     * @return type
     */
    public function __get($name) {
        return $this->components[$name];        
    }  
    
    /**
     * 
     * @param type $name
     */
    public function setTemplate($name){
        $this->_template = $name;
    }
    
    /**
     * 
     * @return type
     */
    public function getTemplate(){
        $temp = strlen($this->_template) ? $this->_template . "." : "";
        return "views/template." . $temp . "php";
    }
        
    public function renderContent($content, $varible = []) {
        $this->_renderedContent = $this->render($content, $varible, FALSE);
    }
    
    /**
     * 
     * @param type $content
     */
    public function render($content, $varible = [], $renderWithTemplate = TRUE) {
        $this->beforeRender();
        $viewName = 'views/' . $content . '.php'; 
        
        $renderContent = $this->_render($viewName, $varible);        
        
        $finalRender = $renderContent;
        if($renderWithTemplate){
            return $this->_render(
                    $this->getTemplate(), 
                    ["content" => $renderContent]
                    );
        }
        return $finalRender;
    }
    public function beforeRender() {
        $this->components["url"] = Lii::parm('url');
    }
 
    protected function _render($viewName, $varible) {
        ob_start();
        foreach ($varible as $varName => $var) {
            $$varName = $var;
        }
        require $viewName;          
        $buffer = ob_get_contents();        
        ob_end_clean();
        return preg_replace_callback('/{%([^%]+)%}/', 'self::getComponents', $buffer);
    }

    /**
     * 
     * @param array|string $names
     */
    public function addJs($names) {
        if(is_array($names)){
            foreach ($names as $name) {
                $this->_addJs($name);
            }
        }else{
            $this->_addJs($names);           
        }
    }
    /**
     * 
     * @param type $name
     */
    private function _addJs($name) {
        $this->components["js"] .= sprintf(
                "<script src='%sweb/js/%s.js'></script> \n\t\t", 
                Lii::parm("url"),
                str_replace(" ", "",$name)
                );
    }

    /**
     * 
     * @param array|string  $names 
     */
    public function addCss($names) {
        if(is_array($names)){
            foreach ($names as $name) {
                $this->_addCss($name);
            }
        }else{
            $this->_addCss($names);           
        }
    }
    
    private function _addCss($name){
        $this->components["css"].= sprintf(
                "<link rel='stylesheet' href='%sweb/css/%s.css' >\n\t\t", 
                Lii::parm("url"),
                str_replace(" ", "",$name)
                );
    }

    /**
     * 
     * @param type $key
     * @param type $value
     */
    public function addMataData($key, $value){
        $this->components["metadata"].= '<meta name="'.$key.'" content="'.$value.'" />'."\n\t\t";
    }

    /**
     * 
     * @param type $title
     */
    public function setTitle($title) {
        $this->components["title"]=$title;
    }
    
    /**
     * 
     * @param type $info
     */
    public function setOgTags($info) {
        $this->components["image"] = Lii::parm("path/proj_image") . "/" . $info["photo"];
        $this->components["descr"] = $info["descr"];        
    }

    /**
     * 
     * @param type $name
     * @return type
     */
    private function getComponents($name) {
        return $this->components[$name[1]];        
    }
}