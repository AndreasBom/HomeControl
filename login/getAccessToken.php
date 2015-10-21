<?php

require_once 'Login.php';
require '../vendor/autoload.php';

$login = new Login();

$login->getAccessToken();


