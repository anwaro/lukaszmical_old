<?php

namespace app\controllers;

use base\Controller;
use models\Admin;
use Session;

class AdminController extends Controller {
    
    function actionIndex() {
        $info = '';
        if($this->model->is_post("login")){
            if(md5($this->model->post("password"))
                    =="5d9828eb0fb4064df20bff5aa9388760"){
                Session::set("login", TRUE);
            }
            else {
                $info = "Nieprawidłowe hasło";
            }
        }
        
        if(Session::get("login")){
            //$this->model->printGlobalArray();
            return $this->render('admin/index',[
                "size" => $this->model->size(),
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
        Auth::handleLogin();        
        
        return $this->render('admin/all',[
            "list" => $this->model->getList()
        ]);
    }
    
    public function actionEdit($name) {
        Auth::handleLogin();        
        
        return $this->render('admin/edit', [
            "info" => $this->model->getInfo($name),
        ]);
    }
    
    public function actionDelete($name) {
        Auth::handleLogin();
        
        $this->model->deleteProject($name);
        return $this->actionAll();
    }
    
    public function actionUpdate($name) {
        Auth::handleLogin();        
        
        $this->model->actionUpdate($name);
        
        return $this->render('admin/edit', [
            "info" => $this->model->getInfo($name)
        ]);
        
    }
    
    public function actionAdd() {
        Auth::handleLogin();
        
        
        if($this->model->add()){
            return $this->edit($this->model->prUrl());
        }
        else{
            return $this->render('admin/add', [
                "prUrl" => $this->model->prUrl()
            ]);

        }
        
    }
    
}