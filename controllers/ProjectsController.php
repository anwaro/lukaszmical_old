<?php
namespace app\controllers;

use base\Controller;
use models\Projects;
use Lii;

class ProjectsController extends Controller {
    
    
    public function rules() {
        return [
            '*' => [
                'actionIndex', 
                'actionShow',
                'actionAjax',
                'actionAjaxSong',
                'actionAjaxWord',
                'actionAjaxVideo',
                ],
            '@' => ['*'],
        ];
    }
    
    function actionIndex() {        
        $model = new Projects();
        return $this->render('project/index',[
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
    
     public function actionAll() {
        $model = new Projects();        
        
        return $this->render('project/all',[
            "list" => $model->all()
        ]);
    }
    
    public function actionEdit($id) {
        $model = (new Projects())->find($id);    
        
        if(Lii::$app->request->post()){
            $model->load(Lii::$app->request->post());
            $model->save();
        }
        
        return $this->render('project/edit', [
            "info" => $model->getRow(),
        ]);
    }
    
    public function actionDelete($name) {
        $this->model->deleteProject($name);
        return $this->actionAll();
    }
    
    public function actionAdd() {
        $projUrl = Lii::$app->request->post('url', '');
        $model = new Projects();  
        
        if(Lii::$app->request->post('add')){
            $model->load(Lii::$app->request->post());
            $model->date = date("Y-m-d");
            $model->save();            
            return $this->render('project/edit', [
                "info" => $model->getRow(),
            ]);
        }
        else{
            return $this->render('project/add', [
                "projUrl" => $projUrl
            ]);
        }        
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