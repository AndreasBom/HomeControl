<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-10-19
 * Time: 11:06
 */

namespace login;

require_once 'src/login/LoginModel.php';
use login\model\LoginModel;

class LoginFactory
{

    //Was used in production for simplicity
    public function createLoginModel()
    {
        return new LoginModel();
        //return new LoginWithoutAuth();
    }
}