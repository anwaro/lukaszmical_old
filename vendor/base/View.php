<?php
namespace base;

use Lii;


/**
 * Class View
 * @package base
 * @property string $js
 * @property string $title
 * @property string $meta
 * @property string $content
 * @property string $css
 * @property string $url
 * @property string $image
 * @property string $descr
 */
class View{
    
    protected $_template = '';

    public $components = array(
        "js" => "",
        "title" => "Witam na mojej stronie",
        "meta" => "",
        "content" => "",
        "css" => "",       
        "url" => "",
        "image" => "web/images/stat/logo256.jpg",
        "descr" => "Małe projekty wykonane w js, html5, css"
    );
    /**
     * 
     * @param string $name
     * @param string $value
     */  
    public function __set($name, $value) {
        $this->components[$name] = $value;
    }
    
    /**
     * 
     * @param string $name
     * @return string
     */
    public function __get($name) {
        return $this->components[$name];        
    }  
    
    /**
     * 
     * @param string $name
     */
    public function setTemplate($name){
        $this->_template = $name;
    }
    
    /**
     * 
     * @return string
     */
    public function getTemplate(){
        $temp = strlen($this->_template) ? $this->_template . "." : "";
        return "views/template." . $temp . "php";
    }
        
    public function renderContent($content, $variables = []) {
        return $this->render($content, $variables, FALSE);
    }

    /**
     * @param $content
     * @param array $variables
     * @param bool $renderWithTemplate
     * @return string
     */
    public function render($content, $variables = [], $renderWithTemplate = TRUE) {
        $this->beforeRender();
        $viewName = 'views/' . $content . '.php'; 
        
        $renderContent = $this->_render($viewName, $variables);
        
        $finalRender = $renderContent;
        if($renderWithTemplate){
            return $this->_render(
                    $this->getTemplate(), 
                    ["content" => $renderContent]
                    );
        }
        return $finalRender;
    }

    /**
     *
     */
    public function beforeRender() {
        $this->components["url"] = Lii::params('url');
    }

    /**
     * @param $viewName
     * @param $variables
     * @return string
     */
    protected function _render($viewName, $variables) {
        ob_start();
        extract($variables);
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
     * @param string $name
     */
    private function _addJs($name) {
        $name = str_replace(' ', '', $name);
        if($name!=='') {
            $this->components["js"] .= sprintf(
                "<script src='%sweb/js/%s'></script> \n\t\t",
                Lii::params("url"),
                str_replace(" ", "", $name)
            );
        }
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
        $name = str_replace(' ', '', $name);
        if($name!==''){
            $this->components["css"].= $this->link($name);
        }
    }

    private function link($name)
    {
        if(!preg_match('/^http/', $name)){
            $name = sprintf("%sweb/css/%s", Lii::params("url"), str_replace(" ", "",$name));
        }
        return "<link rel='stylesheet' href='$name' >\n\t\t";
    }

    /**
     * 
     * @param string $key
     * @param string $value
     */
    public function addMataData($key, $value){
        $this->components["metadata"].= '<meta name="'.$key.'" content="'.$value.'" />'."\n\t\t";
    }

    /**
     * 
     * @param string $title
     */
    public function setTitle($title) {
        $this->components["title"]=$title;
    }
    
    /**
     * 
     * @param array $info
     */
    public function setOgTags($info) {
        $this->components["image"] = Lii::params("path/proj_image") . "/" . $info["photo"];
        $this->components["description"] = $info["description"];
    }

    /**
     * 
     * @param string $name
     * @return string
     */
    private function getComponents($name) {
        return $this->components[$name[1]];        
    }
}