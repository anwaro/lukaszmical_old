<?php
namespace app\controllers;

use base\Controller;
use models\Projects;


class IndexController extends Controller {

    function actionIndex() {
        $model = new Projects();
        $this->addJs('projects/rate.js');
        return $this->render('index/index',[
            "projects" => $model->getBestProjects()
        ]);
        
    }
    
}