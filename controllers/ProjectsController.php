<?php
namespace app\controllers;

use base\Controller;
use models\Projects;

class ProjectsController extends Controller {

    
    function actionIndex() {        
        $model = new Projects();
        return $this->render('projects/index',[
            "projects" => $model->getAll(),
        ]);
        
    }
    
    
    function actionShow($name) { 
        $model = new Projects();
        $info = $model->getInfo($name);
        
        $this->setTitle("Projects | ".$info["name"]);        
        $this->setOgTags($info);        
        $this->addJs(explode(";", $info["js"]));
        $this->addCss(explode(";", $info["css"]));
        $this->setTemplate($info["template"]);   
        
        return $this->render("projects/" . $info["url"]);
    }
    
    function actionAjax(){
        $model = new Projects();
        $model->savePhoto();
        return $this->model->post("number");
    }
    
    function actionAjaxVideo() {
        $model = new Projects();
        $model->getVideo();
    }
    
    function actionAjaxWord(){
        $model = new Projects();
        return $model->getWord();
    }
    
    function actionAjaxSong($id, $elem){
        $model = new Projects();
        return $model->getSong($id, $elem);
    }
    
    
}