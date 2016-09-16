<?php
class  ErrorController extends Controller {
    
    function __construct() {
        parent::__construct();        
    }
    
    public function actionIndex() {
        $this->view->setTitle("Nie odnaleziono danej strony");
        
        $this->model->index();
        
        $this->view->addJs("404");
        return $this->view->render('error/index');
        
    }
}

