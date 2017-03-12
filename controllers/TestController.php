<?php
/**
 * Created by PhpStorm.
 * User: lukasz
 * Date: 07.10.16
 * Time: 19:29
 * Project: lukaszmical.pl
 */
namespace app\controllers;
use base\Controller;

/**
 * Class TestController
 * @package app\controllers
 * @author lukasz
 */
class TestController extends Controller{
    
    
    public function rules() {
        return [
            '*' => ['*'],
        ];
    }

    public function actionIndex()
    {
        return $this->render('test/index');
    }
}