<?php

class IndexController extends Controller {

    function actionIndex() {        
        return $this->view->render('index/index',[
            "projects" => $this->model->getBestProjects()
        ]);
        
    }
    
}