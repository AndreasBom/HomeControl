<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-10-23
 * Time: 21:48
 */

namespace view;


class CookieStorage
{
    private static $logoutMessage = "LogoutMessage";

    public function setMessage()
    {
        setcookie(self::$logoutMessage, "<h4>You are logged out</h4>", -1);
    }

    public function getMessageAndDelete()
    {
        if(isset($_COOKIE[self::$logoutMessage]))
        {
            $message = $_COOKIE[self::$logoutMessage];
            setcookie(self::$logoutMessage, "", time()-3600);
            return $message;
        }
        return null;
    }

    public function checkForMessage()
    {
        return isset($_COOKIE[self::$logoutMessage]);
    }
}