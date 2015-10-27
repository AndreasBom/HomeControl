<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-10-12
 * Time: 08:06
 */

namespace login\control;

require_once'./src/login/LoginModel.php';

require_once'./src/login/LoginView.php';
require_once'./src/model/Device.php';
require_once'./src/control/AppController.php';


use control\AppController;
use exceptions\AuthErrorException;
use login\model\LoginModel;
use login\view\LoginView;
use model\Device;
use view\AppView;
use view\LayoutView;

class LoginController
{

    private static $logout = "LoginController::Logout";



    private $loginM;
    private $appV;
    private $layoutV;
    private $loginV;
    private $appC;


    public function __construct($loginModel, LoginView $loginView, AppView $appView, LayoutView $layoutView)
    {
        $this->loginM = $loginModel;
        $this->loginV = $loginView;
        $this->appV = $appView;
        $this->layoutV = $layoutView;
        $this->appC = new AppController();
    }

    public function doLogin()
    {

        if($this->loginV->userTriesToLogin())
        {
            if ($this->loginM->getSessionAccessToken() == null)
            {
                try
                {
                    $url = $this->loginM->login();
                    header("Location: ".$url);
                }
                catch(AuthErrorException $ex)
                {
                    $this->layoutV->setErrorMessage($ex->message());
                }
            }
        }

<<<<<<< HEAD


        //User IS logged in
        if($this->loginM->getSessionAccessToken() != null)
        {
            $body = $this->appC->runApp($this->appV, $this->layoutV, $this->loginM);

=======
        //User is NOT logged in
        if($this->loginM->getSessionAccessToken() == null)
        {
            $body = $this->loginV->renderLoginView();
>>>>>>> third
        }
        //User is NOT logged in
        else
        {

            $body = $this->loginV->renderLoginView();
        }


        $this->layoutV->response($body);
    }



}