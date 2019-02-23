<?php
namespace controllers;

use vendor\base\Controller;
use models\Ajax;

/**
 * Class AjaxController
 * @package controllers
 */
class AjaxController extends Controller 
{

    function actionBtc() {
        $model = new Ajax();
        return $model->getBtcPrices();
        
    }
    
}