<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-10-16
 * Time: 19:46
 */

namespace exceptions;


class AuthErrorException extends \Exception
{
    public function message()
    {
        return "Error while trying to connect to authorization provider. Please try again";
    }
}