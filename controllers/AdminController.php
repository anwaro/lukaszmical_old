<?php

namespace app\controllers;

use base\Controller;
use models\Admin;
use Session;
use Lii;

class AdminController extends Controller {
    
    function actionIndex() {
        $model = new Admin();
        $info = '';
        if(Lii::$app->request->post("login")){
            if(md5($this->model->post("password")) =="5d9828eb0fb4064df20bff5aa9388760"){
                Session::set("login", TRUE);
            }
            else {
                $info = "Nieprawidłowe hasło";
            }
        }        
        if(Session::get("login")){
            //$this->model->printGlobalArray();
            return $this->render('admin/index',[
                "size" => $model->size(),
                "info" => "",
            ]);
        }
        else{            
            return $this->render('admin/login', [
                "info" => $info
            ]);
        } 
    }
    
    function actionLogout() {
        Session::destroy();        
        return $this->render('admin/login', [
           "info" => "Wylogowano z panelu administracyjnego"
        ]);        
    }
    
    public function actionAll() {
        Lii::$app->user->handleLogin();
        $model = new Admin();        
        
        return $this->render('admin/all',[
            "list" => $model->all()
        ]);
    }
    
    public function actionEdit($id) {
        Lii::$app->user->handleLogin();
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
        Lii::$app->user->handleLogin();
        
        $this->model->deleteProject($name);
        return $this->actionAll();
    }
    
    public function actionAdd() {
        Lii::$app->user->handleLogin();
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