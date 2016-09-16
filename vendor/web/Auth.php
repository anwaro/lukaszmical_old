<?php

namespace web;


class Auth
{
    
    public static function handleLogin()
    {
        $logged = $_SESSION['login'];
        if ($logged == false) {
            session_destroy();
            header('location: ../admin');
            exit;
        }
    }
    
    public static function isLogin() {
        return $_SESSION["login"];
    }
    
}