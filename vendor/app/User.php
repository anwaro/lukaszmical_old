<?php

namespace app;

use Lii;

/**
 * Description of User
 *
 * @author lukasz
 */
class User extends Auth{

    /**
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public function validPass($password, $hash) {
        return md5($password) == $hash;
    }

    /**
     * @param mixed $user
     */
    public function login($user) {
        Lii::$app->session->set('user', $user);
        $return = Lii::$app->request->get('back');
        if(Lii::params('auth/back') && $return && strlen($return)){
             $url = Lii::$app->url->create(
                    Lii::params('url'),
                    Lii::$app->url->decode($return)
                    );   
            Lii::$app->response->redirect($url);
        }
    }

    /**
     * @return bool
     */
    public function isLogin() {
        return Lii::$app->session->isSetVar('user');
        
    }

    /**
     *
     */
    public function logout() {
        Lii::$app->session->unSetVar('user');
    }

    /**
     * @return bool
     */
    public function access() {
        if(!$this->isLogin()){
            $url = Lii::$app->url->create(
                    Lii::params('url'),
                    Lii::params('auth/url'),
                    ['back' => Lii::$app->url->getPath()]
                    );
 
            Lii::$app->response->redirect($url);
            exit;
        }
        return TRUE;
    }
}
