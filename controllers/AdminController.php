<?php

namespace app\controllers;

use base\Controller;
use models\Admin;
use Lii;

class AdminController extends Controller {
    
    public function rules(){
        return [
            '*'=>['actionLogin'],
            '@'=>['*'],
        ];
    }
    
    function actionLogin(){   
        $info = '';
        if(Lii::$app->request->post()){
            $model = (new Admin())->find('name', '=', 'admin');
            
            $pass = Lii::$app->request->post("password");
            $hash = $model->password;
            
            if(Lii::$app->user->validPass($pass, $hash)){
                Lii::$app->user->login($model->getRow());
                return $this->actionIndex();
            }
            else {
                $info = "Nieprawidłowe hasło";
            }
        }        
        return $this->render('admin/login', [
            "info" => $info
        ]);        
    }
            
    function actionIndex() {  
        $model = new Admin();    
        //$this->model->printGlobalArray();
        return $this->render('admin/index',[
            "size" => $model->size(),
            "info" => "",
        ]);
    }
            
    function actionLogout() {
        Lii::$app->user->logout();     
        return $this->render('admin/login', [
           "info" => "Wylogowano z panelu administracyjnego"
        ]);        
    }
    
   
}