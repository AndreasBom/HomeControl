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

require_once 'src/login/LoginWithoutAuth.php';
require_once'./src/view/AppView.php';
require_once'./src/view/LayoutView.php';
require_once'./src/login/LoginFactory.php';

require_once'./src/login/ILoginModel.php';


session_start();
$factory = new \login\LoginFactory();
$loginM = $factory->createLoginModel();

//$loginM = new \login\model\LoginModel();
$loginV = new login\view\LoginView();
$appV = new view\AppView();
$layoutV = new view\LayoutView();



$loginC = new login\control\LoginController($loginM, $loginV, $appV, $layoutV);
$loginC->doLogin();


