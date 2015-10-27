<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-10-12
 * Time: 08:04
 */
//require_once __DIR__ . '/src/common.php';
require __DIR__ . '/vendor/autoload.php';
require_once 'src/login/LoginController.php';
require_once'./src/view/AppView.php';
require_once'./src/view/LayoutView.php';
require_once'./src/login/LoginFactory.php';
require_once'./src/login/ILoginModel.php';


session_start();
$factory = new \login\LoginFactory();
$loginM = $factory->createLoginModel();
$loginV = new login\view\LoginView();
$appV = new view\AppView();
$layoutV = new view\LayoutView();


//If user comes back from api.Telldus.com after login attempt. Will run LoginModel::getAccessToken()
if(\login\model\LoginModel::getSessionVerificationTriedToLogIn())
{
<<<<<<< HEAD
    \login\model\LoginModel::getAccessToken();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}
=======
    try
    {
        $appV->runAccessScript();
    }
    //on authorization failure, show error message
    catch(\exceptions\AuthErrorException $ex)
    {
        $layoutV->setErrorMessage($ex->message());
    }
}


//Mandatory for device state to be in correct 'state'
if($appV->didUserChangeStateOnDevice())
{
    header('Location: ' .$_SERVER['PHP_SELF'] . '?'.$appV->getDeviceMenuQuery());
}

>>>>>>> third

$loginC = new login\control\LoginController($loginM, $loginV, $appV, $layoutV);
$loginC->doLogin();



<<<<<<< HEAD
=======


>>>>>>> third
