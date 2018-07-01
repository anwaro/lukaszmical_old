<?php
namespace app\controllers;

use base\Controller;
use models\Ajax;

/**
 * Class AjaxController
 * @package app\controllers
 */
class AjaxController extends Controller 
{

    function actionBtc() {
        $model = new Ajax();
        return $model->getBtcPrices();
        
    }
    
}