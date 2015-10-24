<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-10-12
 * Time: 09:56
 */

namespace login\view;

use view\CookieStorage;

require_once dirname(__DIR__) .'/view/IView.php';
require_once './src/view/CookieStorage.php';

class LoginView
{

    private static $loginUser = "login";

    public function userTriesToLogin()
    {
        return isset($_GET[self::$loginUser]);
    }

    public function message()
    {
        $s = new CookieStorage();
        if($s->checkForMessage() == false)
        {
            return '<h4> Press button to log in</h4>';
        }
        $message = $s->getMessageAndDelete();
        return $message;
    }

    public function renderLoginView()
    {
        $html = '

        <div class="btn_holder">
            <form method="get" class="form-group">
                <h3>'. $this->message() .'</h3>
                <input type="submit" class="btn btn-default margin-top" value="Log in" name="'.self::$loginUser.'">
            </form>
        </div>

        ';
        return $html;
    }
}