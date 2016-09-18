<?php

namespace web;


use web\Auth;
use Lii;

/**
 * Description of User
 *
 * @author lukasz
 */
class User extends Auth{    
    
    public function validPass($password, $hash) {
        return md5($password) == $hash;
    }
    
    public function login($user) {
        Lii::$app->session->set('user', $user);
        $return = Lii::$app->request->get('back');
        if(Lii::parm('auth/back') && $return && strlen($return)){
             $url = Lii::$app->url->create(
                    Lii::parm('url'),
                    Lii::$app->url->decode($return)
                    );   
            Lii::$app->response->redirect($url);
        }
        
    }
    
    public function isLogin() {
        return Lii::$app->session->isSetVar('user');
        
    }
    
    public function logout() {
        Lii::$app->session->unSetVar('user');
    }
    
    public function access() {
        if(!$this->isLogin()){
            $url = Lii::$app->url->create(
                    Lii::parm('url'),
                    Lii::parm('auth/url'),
                    ['back' => Lii::$app->url->getPath()]
                    );
 
            Lii::$app->response->redirect($url);
            exit;
        }
        return TRUE;
    }
    
}
