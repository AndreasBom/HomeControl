<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-10-12
 * Time: 07:52
 */

namespace login\model;

use exceptions\AuthErrorException;
use login\ILoginModel;

require_once'./src/common.php';
require_once'./src/exceptions/AuthErrorException.php';
require_once'ILoginModel.php';

class LoginModel implements ILoginModel
{

    private static $accessToken= "LoginModel::accessToken";
    private static $accessTokenSecret = "LoginModel::accessTokenSecret";
    private static $requestToken = "LoginModel::RequestToken";
    private static $requestTokenSecret = "LoginModel::RequestTokenSecret";
    private static $commingBackFromAuth = "LoginModel::CommingBackFromAuth";


    public static function getSessionVerificationTriedToLogIn()
    {
        return isset($_SESSION[self::$commingBackFromAuth]);
    }

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

    public static function getSessionRequestToken()
    {
        if(isset($_SESSION[self::$requestToken]))
        {
            return $_SESSION[self::$requestToken];
        }

        return null;
    }

    public static function getSessionRequestTokenSecret()
    {
        if(isset($_SESSION[self::$requestTokenSecret]))
        {
            return $_SESSION[self::$requestTokenSecret];
        }

        return null;
    }

    public function login()
    {
        return $this->getRequestToken();
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        $_SESSION[self::$accessToken] = null;
    }


    public function getRequestToken()
    {
        try
        {
            $consumer = new \HTTP_OAuth_Consumer(constant('PUBLIC_KEY'), constant('PRIVATE_KEY'));

            $consumer->getRequestToken(constant('REQUEST_TOKEN'), constant('BASE_URL'));

            $_SESSION[self::$requestToken] = $consumer->getToken();
            $_SESSION[self::$requestTokenSecret] = $consumer->getTokenSecret();
            $_SESSION[self::$commingBackFromAuth] = true;

            $url = $consumer->getAuthorizeUrl(constant('AUTHORIZE_TOKEN'));

            return $url;

        }
        catch(\HTTP_OAuth_Exception $ex)
        {
            throw new AuthErrorException();
        }



    }

    public static function getAccessToken()
    {
        try
        {

            //$consumer = new \HTTP_OAuth_Consumer(constant('PUBLIC_KEY'), constant('PRIVATE_KEY'), $_SESSION[self::$requestToken], $_SESSION[self::$requestTokenSecret]);

            unset($_SESSION[self::$commingBackFromAuth]);


            $consumer = new \HTTP_OAuth_Consumer(constant('PUBLIC_KEY'), constant('PRIVATE_KEY'), $_SESSION[self::$requestToken], $_SESSION[self::$requestTokenSecret]);


            $consumer->getAccessToken(constant('ACCESS_TOKEN'));


            $_SESSION[self::$accessToken] = $consumer->getToken();
            $_SESSION[self::$accessTokenSecret] = $consumer->getTokenSecret();

            //header('Location: ../../index.php');
            return true;

        }
        catch(\HTTP_OAuth_Exception $ex)
        {
            throw new AuthErrorException();
        }

    }

}