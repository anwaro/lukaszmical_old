<?php

namespace app\controllers;

use base\Controller;
use models\Curiosities;
use Lii;
use Auth;

class CuriositiesController extends Controller {
    
    function actionIndex($type = "webstuff") {
        $model = new Curiosities($type);
        
        return $this->render('curiosities/index', [
            'curiosities' => $model->all(),
            'type' => $type,
        ]);      
    }   
    
    function actionAdd($type = "webstuff"){        
        Auth::handleLogin();
        $model = new Curiosities($type);
        
        if(Lii::$app->request->isPost()){
            $model->load(Lii::$app->request->post());
            $model->date = date("Y-m-d");
            $model->save();
        }
        return $this->render('curiosities/add', [
            'type' => $type,
        ]);
    }
    
    
    function actionAll($type = "webstuff"){        
        Auth::handleLogin();
        $model = new Curiosities($type);
        
        return $this->render('curiosities/all', [
            'curiosities' => $model->all(),
            'type' => $type,
        ]);
        
    }
    
    function actionEdit($type, $id){        
        Auth::handleLogin();
        $model = (new Curiosities($type))->find($id);
        $webstuffOld = $model->getRow();      
        
        if(Lii::$app->request->isPost()){
            $model->load(Lii::$app->request->post());
            $model->save();
        }
        
        return $this->render('curiosities/edit', [
            '_web' => $webstuffOld,
            'web' => $model->getRow(),
            'type' => $type,
        ]);
    }
    
    
    function actionRemove($id){        
        Auth::handleLogin();
        $removed = False;
        $webstuff = $this->one($id);
        if($this->model->is_post("remove_webstuff")){
            $this->model->remove($id);
            $removed = True;
        }
        return $this->render('curiosities/remove', [
            'web' => $webstuff,
            'removed' => $removed,
            'type' => $type,
        ]);
    }   
}