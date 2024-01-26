<?php

namespace Core\Session;

class Flash
{
    public static function addMessage(string $message, string $color){

        $flashMessage = [
            "message"=>$message,
            "color"=>$color
        ];

        $flashMessages = Session::get("flashMessages");
        if(!$flashMessages){$flashMessages = [] ; }

        $flashMessages[] = $flashMessage;

        Session::set("flashMessages", $flashMessages);

    }

    public static function clearMessages()
    {
        Session::set("flashMessages", []);
    }

    public static function getFlashes()
    {

        $messages =  Session::get("flashMessages");
        Flash::clearMessages();
        return $messages;
    }
}