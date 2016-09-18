<?php

namespace app\controllers;

use base\Controller;
use models\Admin;
use Lii;

class AdminController extends Controller {
    
    public function rules() {
        return [
            'actionLogin' => '*',
            '*' => '@',
        ];
    }
    
    function actionLogin(){   
        $info = '';
        if(Lii::$app->request->post()){
            $pass = Lii::$app->request->post("password");
            $hash = "5d9828eb0fb4064df20bff5aa9388760";
            
            if(Lii::$app->user->validPass($pass, $hash)){
                Lii::$app->user->login(true);
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
    
    public function actionAll() {
        $model = new Admin();        
        
        return $this->render('admin/all',[
            "list" => $model->all()
        ]);
    }
    
    public function actionEdit($id) {
        $model = (new Admin())->find($id);    
        
        if(Lii::$app->request->post()){
            $model->load(Lii::$app->request->post());
            $model->save();
        }
        
        return $this->render('admin/edit', [
            "info" => $model->getRow(),
        ]);
    }
    
    public function actionDelete($name) {
        $this->model->deleteProject($name);
        return $this->actionAll();
    }
    
    public function actionAdd() {
        $projUrl = Lii::$app->request->post('url', '');
        $model = new Admin();  
        
        if(Lii::$app->request->post('add')){
            $model->load(Lii::$app->request->post());
            $model->date = date("Y-m-d");
            $model->save();            
            return $this->render('admin/edit', [
                "info" => $model->getRow(),
            ]);
        }
        else{
            return $this->render('admin/add', [
                "projUrl" => $projUrl
            ]);
        }        
    }    
}