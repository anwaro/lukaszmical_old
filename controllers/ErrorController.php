<?php
namespace app\controllers;

use base\Controller;
use models\Error;

class  ErrorController extends Controller {
        
    public function actionIndex() {
        $this->setTitle("Nie odnaleziono danej strony");
        
        (new Error())->index();
        
        $this->addJs("404.js");
        return $this->render('error/index');
        
    }
}

