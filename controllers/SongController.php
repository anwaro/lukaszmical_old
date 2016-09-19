<?php


namespace app\controllers;

use base\Controller;
use models\Song;

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

    /**
     * @return mixed
     */
    public function actionRand()
    {
        return (new Song())->randId();
    }

    /**
     * @param $id
     * @param $which
     * @return string
     */
    public function actionGet($id, $which){
        $model = new Song();
        $id = intval($id);
        $min = intval($model->min());
        $max = intval($model->max());

        switch ($which){
            case "PREVIOUS":
                if($id == $min){
                    $song =  $model->one($max);
                }
                else{
                    $song = $model->prev($id)->getAttributes();
                }
                break;
            case "NEXT":
                if($id == $max){
                    $song =  $model->one($min);
                }
                else{
                    $song = (new Song())->next($id)->getAttributes();
                }
                break;
            default:
                $song =  (new Song())->one($id);
        }
        $song['which'] = $which;
        return json_encode($song);
    }
}
