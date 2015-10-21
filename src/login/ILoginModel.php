<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-10-19
 * Time: 10:50
 */

namespace login;


interface ILoginModel
{
    public static function getSessionAccessToken();
    public static function getSessionAccessTokenSecret();
    public static function getSessionRequestToken();
    public static function getSessionRequestTokenSecret();

    public function login();

}