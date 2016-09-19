<?php

namespace app\controllers;

use base\Controller;
use models\Curiosities;
use Lii;
use models\Projects;

class CuriositiesController extends Controller {
        
    public function rules() {
        return [
            '*'=>['actionIndex'],
            '@'=>['*'],
        ];
    }
    
    function actionIndex($type = "webstuff") {
        $model = new Curiosities($type);
        
        return $this->render('curiosities/index', [
            'curiosities' => $model->all(),
            'type' => $type,
        ]);      
    }   
    
    function actionAdd($type = "webstuff"){      
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
        $model = new Curiosities($type);
        
        return $this->render('curiosities/all', [
            'curiosities' => $model->all(),
            'type' => $type,
        ]);
        
    }
    
    function actionEdit($type, $id){   
        $model = (new Curiosities($type))->findOne($id);
        $webstuffOld = $model->getAttributes();
        
        if(Lii::$app->request->isPost()){
            $model->load(Lii::$app->request->post());
            $model->save();
        }
        
        return $this->render('curiosities/edit', [
            '_web' => $webstuffOld,
            'web' => $model->getAttributes(),
            'type' => $type,
        ]);
    }
    
    
    function actionDelete($type, $id){
        $model = new Curiosities($type);
        $removed = False;
        $model->findOne($id);
        if(Lii::$app->request->isPost()){
            $model->delete();
            $removed = True;
        }
        return $this->render('curiosities/delete', [
            'web' => $model->getAttributes(),
            'removed' => $removed,
            'type' => $type,
        ]);
    }   
}