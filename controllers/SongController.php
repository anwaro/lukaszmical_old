<?php


namespace app\controllers;

use base\Controller;
use models\Song;
use Lii;

/**
 * Class SongController
 * @package app\controllers
 * @author lukasz
 */
class SongController extends Controller {

    /**
     * @inheritdoc
     */
    public function rules(){
        return [
            '*' => ['actionGet', 'actionRand'],
            '@' => ['*'],
        ];
    }


    public function actionGet(){
        $model = new Song();
        return json_encode($model->db()->from($model->getTableName())->where('show', '=', 1)->all());
    }
    public function actionAll()
    {
        $model = new Song();
        return $this->render('song/all', [
            'songs' => $model->all()
        ]);
    }

//    public function actionDelete($id){
//
//        $model = new Song();
//        $model->findOne($id);
//        if(Lii::$app->request->post()){
//            $model->delete();
//        }
//        return $this->render('song/remove', [
//            'song' => $model->getAttributes()
//        ]);
//    }

    public function actionCopy($id)
    {
//        $model = new Song();
//        $model->findOne($id);
//        $error = $model->copySong();
//        $model->new = 1;
//        $model->save();
//        return json_encode($error);
    }

    public function actionDelete($id)
    {
//        $model = new Song();
//        $model->findOne($id);
//        $error = $model->deleteSong();
//        $model->remove = 1;
//        $model->save();
//        return json_encode($error);
    }
}
