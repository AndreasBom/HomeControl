<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-10-12
 * Time: 09:56
 */

namespace login\view;

require_once dirname(__DIR__) .'/view/IView.php';
use view\IView;

class LoginView
{

    private static $loginUser = "login";
    private static $publicEntrance = "public";


    public function userTriesToLogin()
    {
        return isset($_GET[self::$loginUser]);
    }

    public function userTriesToAccessPublicArea()
    {
        return isset($_GET[self::$publicEntrance]);
    }



    public function renderLoginView()
    {
        $html = '
        <div class="btn_holder">
            <form method="get" class="form-group">
                <input type="submit" class="btn btn-default margin-top" value="Logga in" name="'.self::$loginUser.'">
            </form>
            <a href="'. self::$publicEntrance .'">Publik ingång--></a>
        </div>
        ';
        return $html;
    }
}