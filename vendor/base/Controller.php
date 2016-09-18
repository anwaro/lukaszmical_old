<?php
namespace base;

use Lii;

class Controller extends View {
    
    public function rules() {
        return [
            '*' => ['*']
        ];
    }
    
    public function before($currentAction) {
        $rules = $this->rules();
        foreach ($rules as $rule => $actions) {
            if(in_array($currentAction, $actions) ||
                in_array('*', $actions)){
                return $this->verifyAccess($rule);
            }
        }
    }
    
    public function verifyAccess($rule) {
        if($rule == '@'){
            Lii::$app->user->access();
        }
    }
}