<?php

class AjaxController extends Controller {

    function __construct() {
        parent::__construct();
    }
    
    
    function actionStudent(){
        return  $this->model->getStudent();
    }
}