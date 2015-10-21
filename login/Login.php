<?php

require_once dirname(__DIR__) . '/src/common.php';

class Login
{

    public function getRequestToken()
    {
        session_start();
        $consumer = new HTTP_OAuth_Consumer(constant('PUBLIC_KEY'), constant('PRIVATE_KEY'));
        var_dump(constant('BASE_URL'));
        $consumer->getRequestToken(constant('REQUEST_TOKEN'), constant('BASE_URL'));

        $_SESSION['token'] = $consumer->getToken();
        $_SESSION['tokenSecret'] = $consumer->getTokenSecret();

        $url = $consumer->getAuthorizeUrl(constant('AUTHORIZE_TOKEN'));
        header('Location:'.$url);
    }

    public function getAccessToken()
    {


        $consumer = new HTTP_OAuth_Consumer(constant('PUBLIC_KEY'), constant('PRIVATE_KEY'), $_SESSION['token'], $_SESSION['tokenSecret']);

        try
        {
            $consumer->getAccessToken(constant('ACCESS_TOKEN'));

            $_SESSION['accessToken'] = $consumer->getToken();
            $_SESSION['accessTokenSecret'] = $consumer->getTokenSecret();

            //header('Location: ' .'http://'.$_SERVER["PHP_SELF"]);

            header('Location: ../index.php');
        }
        catch (Exception $e)
        {
            throw new \Exception("login::getAccessToken. Error Accessing");
        }

    }
}


