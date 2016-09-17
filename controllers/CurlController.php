<?php

class CurlController extends Controller {

    function __construct() {
        parent::__construct();
    }
    
    function actionIndex() {
    
    }
    
    function actionFindCover($name){
        $this->model->getCover($name);
    
    }
    
    function actionYttomp3() {
        $this->model->downloadMp3();
    }
}
