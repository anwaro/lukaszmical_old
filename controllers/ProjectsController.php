<?php
namespace app\controllers;

use base\Controller;
use models\Projects;
use models\Rate;
use models\Analise;
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
                'actionVote',
                'actionUpdateVote',
                'actionPreview',
                ],
            '@' => ['*'],
        ];
    }
    
    function actionIndex() {        
        $model = new Projects();
        $this->addJs('projects/rate.js');
        return $this->render('project/index',[
            "projects" => $model->getAll(),
        ]);        
    }

    public function actionVote()
    {
        $model = new Rate();
        $model->load(Lii::$app->request->post());
        $model->analise_id = Lii::$app->getAnaliseId();
        $model->save();
        return json_encode($model->getAttributes());
    }


    public function actionUpdateVote()
    {
        $id = Lii::$app->request->post('id');
        $model = (new Rate())->findOne($id);
        $model->load(Lii::$app->request->post());
        $model->save();
        return json_encode($model->getAttributes());
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
        $this->addJs('projects/an.js');
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



    function actionDelete($id){
        $model = new Projects();
        $removed = False;
        $model->findOne($id);
        if(Lii::$app->request->isPost()){
            $model->delete();
            $removed = True;
        }
        return $this->render('project/delete', [
            'project' => $model->getAttributes(),
            'removed' => $removed,
        ]);
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

    function actionPreview($name)
    {
        $remoteUrl = "http://lukaszmical.pl/";
        $content = file_get_contents("{$remoteUrl}projects/show/$name");
        $url = Lii::$app->url->getBaseUrl();
        return str_replace($remoteUrl, $url, $content);
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