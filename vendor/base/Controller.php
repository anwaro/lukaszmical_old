<?php
namespace base;

use Lii;

class Controller extends View {
    
    public function rules() {
        return [
            '*' => '*'
        ];
    }
    
    public function before($currentAction) {
        $rules = $this->rules();
        foreach ($rules as $action => $rule) {
            if($action == $currentAction 
                    || $action == '*'){
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