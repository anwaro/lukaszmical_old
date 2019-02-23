<?php
/**
 * Created by PhpStorm.
 * User: lukasz
 * Date: 07.10.16
 * Time: 19:29
 * Project: lukaszmical.pl
 */
namespace controllers;
use vendor\base\Controller;

/**
 * Class TestController
 * @package controllers
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