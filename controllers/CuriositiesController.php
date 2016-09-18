<?php

namespace app\controllers;

use base\Controller;
use models\Webstuff;
use Lii;
use Auth;

class WebstuffController extends Controller {
    
    function actionIndex() {
        $model = new Webstuff();
        
        return $this->render('webstuff/index', [
            'webstuffs' => $model->all()
        ]);      
    }   
    
    function actionAdd(){        
        Auth::handleLogin();
        $model = new Webstuff();
        
        var_dump(Lii::$app->request->isPost());
        
        if(Lii::$app->request->isPost()){
            $model->text = Lii::$app->request->post('webstuff-text');
            $model->links = Lii::$app->request->post('webstuff-links');
            $model->date = date("Y-m-d");
            $model->dsate = date("Y-m-d");
            $model->save();
        }
        
        /*
        
        if($this->model->is_post("add_webstuff")){
            $id = $this->model->add();
            return $this->actionEdit($id);
        }
         * */
        return $this->render('webstuff/add');
    }
    
    
    function actionAll(){        
        Auth::handleLogin();
        $model = new Webstuff();
        
        return $this->render('webstuff/all', [
            'webstuffs' => $model->all()
        ]);
        
    }
    
    function actionEdit($id){        
        Auth::handleLogin();
        $model = new Webstuff();
        
        $webstuffOld = $model->one($id);
        $webstuffNew = $webstuffOld;
        
        if($this->model->is_post("edit_webstuff")){
            $this->model->edit($id);
            $webstuffNew = $model->one($id);
        }
        return $this->render('webstuff/edit', [
            '_web' => $webstuffOld,
            'web' => $webstuffNew
        ]);
    }
    
    
    function actionRemove($id){        
        Auth::handleLogin();
        $removed = False;
        $webstuff = $this->o($id);
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