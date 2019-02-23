<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace vendor\helper;

use vendor\base\View;

/**
 * Description of Exception
 *
 * @author lukasz
 */
class PrintException extends View{
   
    private $_ex;


    public function __construct($ex) {
        $this->_ex = $ex;
    }
    
    public function register(){
        //print_r($this->_getAllEx());
        return $this->renderContent('helper/error', [
            'errors' => $this->_getAllEx()
        ]);
    }
    
    private function _getAllEx(){        
         //$call = debug_backtrace();
         //$info = date("Y-m-d H:m:s") . " log in " . $call[0]["file"] . ":" . $call[0]["line"];
        $ex = $this->_ex;
        $exs = [$this->exDetail($ex)];
        
        while($ex = $ex->getPrevious()){
            array_push($exs, $this->exDetail($ex));
        }
        return $exs;
        
    }
    
    public function exDetail($ex){
        return [
            'trace' => $ex->getTrace(),
            'msg'   => $ex->getMessage(),
            'code'  => $ex->getCode(),
            'file'  => $ex->getFile(),
            'line'  => $ex->getLine(),
        ];
    }
}
