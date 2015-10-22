<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-10-12
 * Time: 10:03
 */

namespace view;

require_once'Menu.php';

class LayoutView
{
    private $errorMessage = '';
    private $errorCss = '';
    private static $menu;

    public function response($content)
    {

        echo '
            <!DOCTYPE html>
            <html>
                <head>
                    <title>Telldus Home Automatization </title>
                    <!-- Latest compiled and minified CSS -->
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
                    <!-- Optional theme -->
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
                    <link href="https://fonts.googleapis.com/css?family=Prosto+One" rel="stylesheet" type="text/css">
                    <link rel="stylesheet" href="src/css/stylesheet.css">
                    <meta charset="UTF-8">
                    <!--<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">-->
                </head>
                <body>
                    <div class="container">
                        <div class="jumbotron jumbotron-blue">
                           <h1 class="colorWhite header-font text-border" style="color: white"><span class="header-small">Home</span><span class="">Control</span></h1>

                        </div>
                        '. self::$menu .'
                        <pre>'. $content .'</pre>
                        <p class="'. $this->errorCss .'">'. $this->errorMessage .' </p>
                    </div>

                </body>

            </html>


        ';
    }

    /**
     * Setting error message and warning css class
     *
     * @param $exception
     */
    public function setErrorMessage($exception)
    {
        $this->errorCss = 'alert alert-warning';
        $this->errorMessage = $exception;
    }

    public function renderMenu()
    {
        //Render Menu. called from AppController after login
        $m = new Menu();
        self::$menu = $m->getMenu();
    }

}