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

    /**
     * @param string $url
     * @return string
     */
    function actionShow($url) {
        $model = (new Projects())->findOne('url', '=', $url);
        
        $this->setTitle("Projects | ".$model->name);
        $this->setOgTags($model->getAttributes());
        $this->addJs(explode(";", $model->js));
        $this->addCss(explode(";", $model->css));
        $this->setTemplate($model->template);
        
        return $this->render("projects/" . $model->url);
    }

    /**
     * @return mixed
     */
    public function actionAll() {
        $model = new Projects();        
        
        return $this->render('project/all',[
            "projects" => $model->all()
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionEdit($id) {
        $model = (new Projects())->findOne($id);
        
        if(Lii::$app->request->post()){
            $model->load(Lii::$app->request->post());
            $model->save();
        }
        
        return $this->render('project/edit', [
            "info" => $model->getAttributes(),
        ]);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function actionDelete($name) {

    }

    /**
     * @return string
     */
    public function actionAdd() {
        $projectUrl = Lii::$app->request->post('url', '');
        
        if(Lii::$app->request->post('add')){
            $model = new Projects();
            $model->load(Lii::$app->request->post());
            $model->date = date("Y-m-d");
            $model->save();            
            return $this->render('project/edit', [
                "info" => $model->getAttributes(),
            ]);
        }
        else{
            return $this->render('project/add', [
                "projectUrl" => $projectUrl
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