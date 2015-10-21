<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-10-12
 * Time: 16:56
 */

namespace model;

require_once dirname(__DIR__) . '/common.php';
require_once'BaseREST.php';

class Device extends BaseREST
{

    public function listDevices()
    {
        $params = array('supportedMethods' => 1023);
        $response = $this->getResponse('/devices/list', $params);
        return $response;
    }

    public function turnOn($id)
    {
        $params = array('id'=>$id);
        $response = $this->sendResponse('/device/turnOn', $params);

    }

    public function turnOff($id)
    {
        $params = array('id'=>$id);
        $response = $this->sendResponse('/device/turnOff', $params);

    }

    public function dim($id, $dimValue)
    {
        $params = array('id'=>$id, 'level'=>$dimValue);
        $response = $this->sendResponse('device/dim', $params);

    }





}