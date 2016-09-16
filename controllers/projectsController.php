<?php

class ProjectsController extends Controller {

    function __construct() {
        parent::__construct();
    }
    
    function actionIndex() {        
        return $this->view->render('projects/index',[
            "allProjects" => $this->model->getInfoAll(),
        ]);
        
    }
    
    
    function actionShow($name) {
        $this->view->info = $this->model->getInfo($name);
        $this->view->setTitle("Projects | ".$this->view->info["name"]);
        $this->view->setOgTags($this->view->info);
        
        foreach ($this->view->info["css"] as $css) {
            if(strlen($css) > 2 ){
                $this->view->addCss($css);
            }
        }
        foreach ($this->view->info["js"] as $js) {
            if(strlen($js) > 2 ){
                $this->view->addJs($js);
            }
        }
        $this->view->setTemplate($this->view->info["template"]);        
        return $this->view->render($this->view->info["url"]);
    }
    
    function actionAjax(){
        $this->model->savePhoto();
        return $this->model->post("number");
    }
    
    function actionAjaxVideo() {
        $this->model->getVideo();
    }
    
    function actionAjaxWord(){
        return $this->model->getWord();
    }
    
    function actionAjaxSong($id, $elem){
        return $this->model->getSong($id, $elem);
    }
    
    
}