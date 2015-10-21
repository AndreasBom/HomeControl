<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-10-12
 * Time: 09:00
 */

namespace login\model;


require_once 'LoginModel.php';
require '../../vendor/autoload.php';

//$login = new \login\model\LoginModel();

LoginModel::getAccessToken();

