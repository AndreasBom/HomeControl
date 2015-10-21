<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-10-19
 * Time: 10:37
 */

namespace login;


require_once'ILoginModel.php';

class LoginWithoutAuth implements ILoginModel
{

    private static $accessToken= "LoginModel::accessToken";
    private static $accessTokenSecret = "LoginModel::accessTokenSecret";
    private static $requestToken = "LoginModel::RequestToken";
    private static $requestTokenSecret = "LoginModel::RequestTokenSecret";

    public static function getSessionAccessToken()
    {
        if(isset($_SESSION[self::$accessToken]))
        {
            return $_SESSION[self::$accessToken];
        }

        return null;
    }

    public static function getSessionAccessTokenSecret()
    {
        if(isset($_SESSION[self::$accessTokenSecret]))
        {
            return $_SESSION[self::$accessTokenSecret];
        }

        return null;
    }

    public function getSessionRequestToken()
    {
        if(isset($_SESSION[self::$requestToken]))
        {
            return $_SESSION[self::$requestToken];
        }

        return null;
    }

    public function getSessionRequestTokenSecret()
    {
        if(isset($_SESSION[self::$requestTokenSecret]))
        {
            return $_SESSION[self::$requestTokenSecret];
        }

        return null;
    }


    public function login()
    {
        $_SESSION[self::$accessToken] = constant('TOKEN');
        return ($_SERVER['PHP_SELF']) ;
    }

}