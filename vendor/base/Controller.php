<?php
namespace base;

use Lii;

/**
 * Class Controller
 * @package base
 * @author lukasz
 */
class Controller extends View {

    /**
     * Return access rules
     *```
     * return [
     *  '*' => ['actionName1', 'actionName2'],
     *  '@' => ['*'],
     *  ];
     * ```
     * @return array
     */
    public function rules() {
        return [
            '*' => ['*'],
        ];
    }

    /**
     * @param string $currentAction Action name
     * @return bool
     */
    public function before($currentAction) {
        $rules = $this->rules();
        foreach ($rules as $rule => $actions) {
            if(in_array($currentAction, $actions) ||
                in_array('*', $actions)){
                return $this->verifyAccess($rule);
            }
        }
        return true;
    }

    /**
     * @param $rule
     * @return bool
     */
    public function verifyAccess($rule) {
        if($rule == '@'){
            Lii::$app->user->access();
        }
        return true;
    }
}