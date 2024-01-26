<?php

namespace Core\Session;

use Exception;

class Session
{
    public static function start()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }
    public static function get($index){

        if(isset($_SESSION[$index])){
            return $_SESSION[$index];
        }
        else{return false; }
    }

    public static function userConnected():bool
    {
        if( Session::get("user") )
        {
            return true;
        }
        return false;
    }

    public static function user()
    {
        if(Session::userConnected()){
            return Session::get('user');

        }else{
            throw new Exception("user session empty");
        }
    }

    public static function set($index, $value)
    {
        $_SESSION[$index] = $value;
    }

    public static function remove($index)
    {
        unset($_SESSION[$index]);
    }
}