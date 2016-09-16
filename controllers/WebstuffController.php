<?php

namespace app\controllers;

use base\Controller;
use models\Webstuff;

class WebstuffController extends Controller {
    
    function actionIndex() {
        $model = new Webstuff();
        $webstuffs = $model->getAll();
        
        echo "poszlo";
        
        return $this->render('webstuff/index', [
            'webstuffs' => $webstuffs
        ]);      
    }   
    
    function actionAdd(){        
        Auth::handleLogin();
        if($this->model->is_post("add_webstuff")){
            $id = $this->model->add();
            return $this->actionEdit($id);
        }
        return $this->render('webstuff/add');
    }
    
    
    function actionAll(){        
        Auth::handleLogin();
        $webstuffs = $this->model->getAll();
        
        return $this->render('webstuff/all', [
            'webstuffs' => $webstuffs
        ]);
        
    }
    
    function actionEdit($id){        
        Auth::handleLogin();
        $webstuffOld = $this->model->getOne($id);
        $webstuffNew = $webstuffOld;
        if($this->model->is_post("edit_webstuff")){
            $this->model->edit($id);
            $webstuffNew = $this->model->getOne($id);
        }
        return $this->render('webstuff/edit', [
            '_web' => $webstuffOld,
            'web' => $webstuffNew
        ]);
    }
    
    
    function actionRemove($id){        
        Auth::handleLogin();
        $removed = False;
        $webstuff = $this->model->getOne($id);
        if($this->model->is_post("remove_webstuff")){
            $this->model->remove($id);
            $removed = True;
        }
        return $this->render('webstuff/remove', [
            'web' => $webstuff,
            'removed' => $removed,
        ]);
    }   
}